@extends('layouts.dashboard')
@section('title', 'Edit Product')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('farmer.products.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
    <div class="bg-white rounded-xl shadow p-6 mt-4">
        <h2 class="text-lg font-semibold mb-4">Edit Product</h2>
        <form method="POST" action="{{ route('farmer.products.update', $product) }}">
            @csrf @method('PUT')
            @include('farmer.products._form')
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 font-semibold">Update Product</button>
        </form>
    </div>
</div>
@endsection
