<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Invoice Details') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">Invoice #{{ $invoice->invoice_number }}</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><p class="text-gray-600">Customer:</p><p class="font-semibold">{{ $invoice->customer->name }}</p></div>
                        <div><p class="text-gray-600">Status:</p><p class="font-semibold"><span class="px-2 py-1 rounded {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($invoice->status) }}</span></p></div>
                        <div><p class="text-gray-600">Amount:</p><p class="font-semibold">${{ number_format($invoice->amount, 2) }}</p></div>
                        <div><p class="text-gray-600">Tax:</p><p class="font-semibold">${{ number_format($invoice->tax, 2) }}</p></div>
                        <div><p class="text-gray-600">Total:</p><p class="font-semibold text-xl text-green-600">${{ number_format($invoice->total, 2) }}</p></div>
                        <div><p class="text-gray-600">Due Date:</p><p class="font-semibold">{{ $invoice->due_date->format('M d, Y') }}</p></div>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-600">Description:</p>
                        <p class="font-semibold">{{ $invoice->description }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('invoices.edit', $invoice) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        
                        @if($invoice->status !== 'sent' && $invoice->status !== 'paid')
                        <form action="{{ route('invoices.send', $invoice) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Send this invoice to {{ $invoice->customer->email }}?')">
                                Send Invoice
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('invoices.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
