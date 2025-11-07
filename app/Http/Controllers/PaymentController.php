<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        
        return view('payment.checkout', compact('invoice'));
    }

    public function processPayment(Request $request, Invoice $invoice)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Invoice #' . $invoice->invoice_number,
                            'description' => $invoice->description,
                        ],
                        'unit_amount' => $invoice->total * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['invoice' => $invoice->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['invoice' => $invoice->id]),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request, Invoice $invoice)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $sessionId = $request->get('session_id');
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Create transaction
                $transaction = Transaction::create([
                    'invoice_id' => $invoice->id,
                    'customer_id' => $invoice->customer_id,
                    'transaction_id' => $session->payment_intent,
                    'amount' => $invoice->total,
                    'status' => 'completed',
                    'payment_method' => 'stripe',
                ]);

                // Update invoice status
                $invoice->update(['status' => 'paid']);

                // Send payment success email
                \Mail::to($invoice->customer->email)->send(new \App\Mail\PaymentSuccessMail($invoice, $transaction));

                return view('payment.success', compact('invoice'));
            }
        } catch (\Exception $e) {
            return redirect()->route('payment.cancel', $invoice->id)
                ->with('error', 'Payment verification failed.');
        }

        return redirect()->route('payment.cancel', $invoice->id);
    }

    public function cancel(Invoice $invoice)
    {
        return view('payment.cancel', compact('invoice'));
    }

    public function webhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;
                $invoiceId = $session->metadata->invoice_id;

                $invoice = Invoice::find($invoiceId);
                if ($invoice) {
                    $transaction = Transaction::create([
                        'invoice_id' => $invoice->id,
                        'customer_id' => $invoice->customer_id,
                        'transaction_id' => $session->payment_intent,
                        'amount' => $invoice->total,
                        'status' => 'completed',
                        'payment_method' => 'stripe',
                    ]);

                    $invoice->update(['status' => 'paid']);

                    // Send payment success email
                    \Mail::to($invoice->customer->email)->send(new \App\Mail\PaymentSuccessMail($invoice, $transaction));
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}