<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">{{ $customer->name }}</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-600">Email:</p>
                            <p class="font-semibold">{{ $customer->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Phone:</p>
                            <p class="font-semibold">{{ $customer->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Company:</p>
                            <p class="font-semibold">{{ $customer->company ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Status:</p>
                            <p class="font-semibold">
                                <span class="px-2 py-1 rounded {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-600">Address:</p>
                        <p class="font-semibold">{{ $customer->address ?? 'N/A' }}</p>
                    </div>

                    <div class="flex space-x-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('customers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>