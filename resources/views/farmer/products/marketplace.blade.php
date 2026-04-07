{{-- resources/views/farmer/products/marketplace.blade.php --}}
@extends('layouts.app')

@section('title', 'Buy from Other Farmers - FarmConnect')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Buy from Other Farmers</h1>
        <a href="{{ route('farmer.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> My Products
        </a>
    </div>

    <!-- Search and Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('farmer.products.marketplace') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                            <div class="mb-2">
                                <span class="badge bg-success">KSh {{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-info">Stock: {{ $product->quantity }} {{ $product->unit }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> {{ $product->farmer->name }}
                                </small>
                            </div>
                            <div class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($product->average_rating ?? 0))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <small class="text-muted">({{ $product->reviews_count ?? 0 }})</small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="{{ route('farmer.products.view', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('farmer.products.contact', $product->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-envelope"></i> Message Seller
                                </a>
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
            <i class="fas fa-store fa-4x text-muted mb-3"></i>
            <h3>No Products Available</h3>
            <p class="text-muted">No products found from other farmers at the moment.</p>
            <a href="{{ route('farmer.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Sell Your Products
            </a>
        </div>
    @endif

    <!-- Tips Section -->
    <div class="card bg-light mt-4">
        <div class="card-body">
            <h5><i class="fas fa-lightbulb text-warning"></i> Tips for Buying from Farmers</h5>
            <ul class="mb-0">
                <li>Message the seller directly to negotiate prices for bulk purchases</li>
                <li>Check product ratings and reviews before purchasing</li>
                <li>Confirm delivery options and costs with the seller</li>
                <li>Share your own products to earn extra income</li>
            </ul>
        </div>
    </div>
</div>
@endsection