<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Invoice') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Customer *</label>
                            <select name="customer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Description *</label>
                            <textarea name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $invoice->description) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Amount *</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount', $invoice->amount) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Tax *</label>
                            <input type="number" step="0.01" name="tax" value="{{ old('tax', $invoice->tax) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Due Date *</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('invoices.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>