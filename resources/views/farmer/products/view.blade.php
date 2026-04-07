{{-- resources/views/farmer/products/view.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - FarmConnect')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('farmer.products.marketplace') }}">Marketplace</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                    
                    <!-- Seller Info -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-circle fa-2x text-success"></i>
                                <strong class="ms-2">{{ $product->farmer->name }}</strong>
                                <br>
                                <small class="text-muted">Farmer since {{ $product->farmer->created_at->format('M Y') }}</small>
                            </div>
                            <a href="{{ route('farmer.products.contact', $product->id) }}" class="btn btn-success">
                                <i class="fas fa-envelope"></i> Message Seller
                            </a>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->average_rating ?? 0))
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <span class="ms-2">({{ $product->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    <!-- Price -->
                    <p class="h3 text-primary mb-3">KSh {{ number_format($product->price, 2) }} / {{ $product->unit }}</p>
                    
                    <!-- Stock Status -->
                    @if($product->quantity > 0)
                        <p class="text-success"><i class="fas fa-check-circle"></i> In Stock ({{ $product->quantity }} {{ $product->unit }} available)</p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i> Out of Stock</p>
                    @endif

                    <!-- Description -->
                    <h5>Description</h5>
                    <p>{{ $product->description }}</p>

                    <!-- Category -->
                    <p><strong>Category:</strong> {{ ucfirst($product->category) }}</p>

                    <!-- Interested Section -->
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> 
                        Interested in this product? Click "Message Seller" to discuss pricing, delivery, and bulk purchases.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seller's Other Products -->
    @if($sellerProducts->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <h3>More from {{ $product->farmer->name }}</h3>
        </div>
        @foreach($sellerProducts as $sellerProduct)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <img src="{{ $sellerProduct->image_url }}" class="card-img-top" alt="{{ $sellerProduct->name }}" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h6 class="card-title">{{ $sellerProduct->name }}</h6>
                    <p class="text-primary">KSh {{ number_format($sellerProduct->price, 2) }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('farmer.products.view', $sellerProduct->id) }}" class="btn btn-sm btn-outline-primary w-100">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection