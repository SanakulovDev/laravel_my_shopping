@extends('products.layout')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl">Edit Product</h2>
        <a class="bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('products.index') }}">Back</a>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <div class="form-group @error('name') has-error @enderror">
                <label class="block text-gray-700">Name:</label>
                <input type="text" name="name" class="form-control border rounded w-full py-2 px-3" placeholder="Name" value="{{ $product->name }}">
                @error('name')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group @error('detail') has-error @enderror">
                <label class="block text-gray-700">Detail:</label>
                <input type="text" name="detail" class="form-control border rounded w-full py-2 px-3" placeholder="Detail" value="{{ $product->detail }}">
                @error('detail')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
