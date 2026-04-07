@extends('layouts.app')

@section('title', 'My Products - FarmConnect')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Products</h1>
        <a href="{{ route('farmer.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">KSh {{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-info">Stock: {{ $product->quantity }} {{ $product->unit }}</span>
                                <span class="badge bg-{{ $product->status === 'available' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="{{ route('farmer.products.show', $product) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('farmer.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete "{{ $product->name }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('farmer.products.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h3>No Products Yet</h3>
            <p class="text-muted">Start selling your farm products by adding your first product.</p>
            <a href="{{ route('farmer.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    @endif
</div>
@endsection