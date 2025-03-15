@extends('products.layout')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl">Add New Product</h2>
        <a class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('products.index') }}"> Back</a>
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
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div class="form-group @error('name') has-error @enderror">
                <label class="block text-gray-700">Name:</label>
                <input type="text" name="name" class="form-control border rounded w-full py-2 px-3" placeholder="Name" value="{{ old('name') }}">
                @error('name')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group @error('detail') has-error @enderror">
                <label class="block text-gray-700">Detail:</label>
                <input type="text" name="detail" class="form-control border rounded w-full py-2 px-3" placeholder="Detail" value="{{ old('detail') }}">
                @error('detail')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </div>
    </form>
@endsection

