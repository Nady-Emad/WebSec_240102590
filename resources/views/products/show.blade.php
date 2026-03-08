@extends('layouts.app')

@section('title', 'Product Details')

@push('styles')
<style>
    .product-show-image-wrapper {
        min-height: 340px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 1rem;
    }

    .product-show-image {
        max-width: 100%;
        max-height: 420px;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
    @php
        $photoSrc = filter_var($product->photo, FILTER_VALIDATE_URL)
            ? $product->photo
            : asset("images/$product->photo");
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Product Details</h1>
        <a href="{{ route('products_list') }}" class="btn btn-outline-secondary">Back to Products</a>
    </div>

    <div class="content-card card">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-5">
                    <div class="product-show-image-wrapper">
                        <img src="{{ $photoSrc }}" alt="{{ $product->name }}" class="product-show-image" loading="lazy">
                    </div>
                </div>

                <div class="col-md-7">
                    <h2 class="h4 mb-3">{{ $product->name }}</h2>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped align-middle mb-0">
                            <tr>
                                <th style="width: 180px;">Model</th>
                                <td>{{ $product->model }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>${{ number_format((float) $product->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description ?: 'No description provided.' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary">Edit Product</a>
                        <a href="{{ route('products_delete', $product->id) }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
