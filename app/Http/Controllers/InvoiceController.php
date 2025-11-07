<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'status' => 'required|in:pending,sent,paid,cancelled',
            'due_date' => 'required|date',
        ]);

        $validated['total'] = $validated['amount'] + $validated['tax'];

        Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'status' => 'required|in:pending,sent,paid,cancelled',
            'due_date' => 'required|date',
        ]);

        $validated['total'] = $validated['amount'] + $validated['tax'];

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $invoice->update(['status' => $request->status]);
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice status updated successfully.');
    }

    public function sendInvoice(Invoice $invoice)
    {
        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));
        
        $invoice->update(['status' => 'sent']);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice sent successfully.');
    }
}