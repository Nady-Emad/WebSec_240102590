@extends('layouts.app')

@section('title', 'Products')

@section('content')
<style>
    .product-image-wrapper {
        height: 240px;
        width: 100%;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 0.5rem;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }
</style>

<div class="container">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="mb-0">Products</h1>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('products_edit') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('products_list') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="keywords" class="form-label">Search Keywords</label>
                        <input type="text" name="keywords" id="keywords" class="form-control" value="{{ request('keywords') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="min_price" class="form-label">Min Price</label>
                        <input type="number" step="0.01" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="max_price" class="form-label">Max Price</label>
                        <input type="number" step="0.01" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="order_by" class="form-label">Order By</label>
                        <select name="order_by" id="order_by" class="form-control">
                            <option value="">Select</option>
                            <option value="name" {{ request('order_by') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price" {{ request('order_by') === 'price' ? 'selected' : '' }}>Price</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="order_direction" class="form-label">Order Direction</label>
                        <select name="order_direction" id="order_direction" class="form-control">
                            <option value="">Select</option>
                            <option value="ASC" {{ request('order_direction') === 'ASC' ? 'selected' : '' }}>ASC</option>
                            <option value="DESC" {{ request('order_direction') === 'DESC' ? 'selected' : '' }}>DESC</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('products_list') }}" class="btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3 text-center">
                            @php
                                $photoSrc = filter_var($product->photo, FILTER_VALIDATE_URL)
                                    ? $product->photo
                                    : asset("images/$product->photo");
                            @endphp
                            <div class="product-image-wrapper">
                                <img src="{{ $photoSrc }}" alt="{{ $product->name }}" class="product-image img-thumbnail">
                            </div>
                        </div>

                        <h5 class="card-title">{{ $product->name }}</h5>

                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $product->model }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ $product->price }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                        </table>

                        <div class="mt-auto">
                            <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('products_delete', $product->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">No products found.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection