@extends('products.layout')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Product Details</h2>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Back</a>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                @if($product->photo)
                                    <img src="{{ asset('storage/'.$product->photo) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                                        <span class="text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Name</h3>
                                    <p class="text-lg font-semibold">{{ $product->name }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                    <p class="text-gray-700">{{ $product->detail }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Price</h3>
                                    <p class="text-lg font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Added on</h3>
                                    <p class="text-gray-700"> {{ formatDateWithTime('2025-01-01') }} </p>
                                </div>
                                
                                <div class="pt-4 flex space-x-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</a>
                                    
                                    <form action="{{ route('products.destroy', $pr. oduct->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
