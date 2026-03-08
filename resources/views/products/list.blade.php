@extends('layouts.app')

@section('title', 'Products')

@push('styles')
<style>
    .product-image-wrapper {
        height: 220px;
        width: 100%;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 0.75rem;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Products</h1>
            <p class="text-muted mb-0">Browse, filter, and manage your product catalog.</p>
        </div>
        <a href="{{ route('products_edit') }}" class="btn btn-primary">Add Product</a>
    </div>

    <div class="content-card card mb-4">
        <div class="card-body p-4">
            <form action="{{ route('products_list') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6 col-lg-3">
                    <label for="keywords" class="form-label">Search</label>
                    <input type="text" name="keywords" id="keywords" class="form-control" value="{{ request('keywords') }}" placeholder="Name keywords">
                </div>

                <div class="col-md-6 col-lg-2">
                    <label for="min_price" class="form-label">Min Price</label>
                    <input type="number" min="0" step="0.01" name="min_price" id="min_price" class="form-control" value="{{ $minPrice ?? request('min_price') }}">
                </div>

                <div class="col-md-6 col-lg-2">
                    <label for="max_price" class="form-label">Max Price</label>
                    <input type="number" min="0" step="0.01" name="max_price" id="max_price" class="form-control" value="{{ $maxPrice ?? request('max_price') }}">
                </div>

                <div class="col-md-6 col-lg-2">
                    <label for="product_type" class="form-label">Type</label>
                    <select name="product_type" id="product_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach ($productTypes as $type)
                            <option value="{{ $type }}" {{ ($selectedType ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-lg-1">
                    <label for="name_sort" class="form-label">Name</label>
                    <select name="name_sort" id="name_sort" class="form-select">
                        <option value="">-</option>
                        <option value="asc" {{ ($nameSort ?? '') === 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ ($nameSort ?? '') === 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-1">
                    <label for="price_sort" class="form-label">Price</label>
                    <select name="price_sort" id="price_sort" class="form-select">
                        <option value="">-</option>
                        <option value="asc" {{ ($priceSort ?? '') === 'asc' ? 'selected' : '' }}>Low</option>
                        <option value="desc" {{ ($priceSort ?? '') === 'desc' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Apply Filters</button>
                    <a href="{{ route('products_list') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-md-6 col-xl-4">
                <div class="content-card card h-100">
                    <div class="card-body d-flex flex-column">
                        @php
                            $photoSrc = filter_var($product->photo, FILTER_VALIDATE_URL)
                                ? $product->photo
                                : asset("images/$product->photo");
                        @endphp

                        <div class="product-image-wrapper mb-3">
                            <img src="{{ $photoSrc }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                        </div>

                        <h2 class="h5 mb-3">{{ $product->name }}</h2>

                        <div class="table-responsive mb-3">
                            <table class="table table-sm align-middle mb-0">
                                <tr>
                                    <th class="text-nowrap" style="width: 96px;">Model</th>
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
                            </table>
                        </div>

                        @if ($product->description)
                            <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                        @endif

                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a href="{{ route('products_show', $product->id) }}" class="btn btn-outline-success btn-sm">View</a>
                            <a href="{{ route('products_edit', $product->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <a href="{{ route('products_delete', $product->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">No products found for the selected filters.</div>
            </div>
        @endforelse
    </div>
@endsection
