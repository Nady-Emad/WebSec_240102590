@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<style>
    .product-show-image-wrapper {
        min-height: 340px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 0.75rem;
    }

    .product-show-image {
        max-width: 100%;
        max-height: 420px;
        width: auto;
        height: auto;
        object-fit: contain;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Product Details</h4>
                    <a href="{{ route('products_list') }}" class="btn btn-danger">Back</a>
                </div>

                <div class="card-body">
                    @php
                        $photoSrc = filter_var($product->photo, FILTER_VALIDATE_URL)
                            ? $product->photo
                            : asset("images/$product->photo");
                    @endphp

                    <div class="row">
                        <div class="col-md-5 mb-3 mb-md-0">
                            <div class="product-show-image-wrapper">
                                <img src="{{ $photoSrc }}" alt="{{ $product->name }}" class="product-show-image img-thumbnail">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <h3 class="mb-3">{{ $product->name }}</h3>
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 180px;">Name</th>
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

                            <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('products_delete', $product->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection