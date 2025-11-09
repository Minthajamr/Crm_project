<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Transaction Details') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">Transaction Details</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><p class="text-gray-600">Transaction ID:</p><p class="font-semibold font-mono">{{ $transaction->transaction_id }}</p></div>
                        <div><p class="text-gray-600">Customer:</p><p class="font-semibold">{{ $transaction->customer->name }}</p></div>
                        <div><p class="text-gray-600">Invoice Number:</p><p class="font-semibold">{{ $transaction->invoice->invoice_number }}</p></div>
                        <div><p class="text-gray-600">Amount:</p><p class="font-semibold text-xl text-green-600">${{ number_format($transaction->amount, 2) }}</p></div>
                        <div><p class="text-gray-600">Payment Method:</p><p class="font-semibold">{{ ucfirst($transaction->payment_method) }}</p></div>
                        <div><p class="text-gray-600">Status:</p><p class="font-semibold"><span class="px-2 py-1 rounded {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($transaction->status) }}</span></p></div>
                        <div><p class="text-gray-600">Transaction Date:</p><p class="font-semibold">{{ $transaction->created_at->format('M d, Y H:i:s') }}</p></div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('transactions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back to Transactions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>