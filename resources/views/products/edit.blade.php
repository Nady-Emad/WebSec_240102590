@extends('layouts.app')

@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ $product->exists ? 'Edit Product' : 'Add Product' }}</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products_save', $product->id) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $product->code) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $product->model) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" min="0" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="text" name="photo" id="photo" class="form-control" value="{{ old('photo', $product->photo) }}" placeholder="https://example.com/product.jpg">
                            <small class="text-muted">You can enter a direct image URL or a local filename from public/images.</small>
                        </div>

                        @php
                            $photoValue = old('photo', $product->photo);
                            $photoSrc = $photoValue
                                ? (filter_var($photoValue, FILTER_VALIDATE_URL) ? $photoValue : asset("images/$photoValue"))
                                : null;
                        @endphp

                        @if ($photoSrc)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div>
                                    <img src="{{ $photoSrc }}" alt="{{ old('name', $product->name) }}" class="img-thumbnail" style="max-width: 260px; max-height: 260px; object-fit: contain;">
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('products_list') }}" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection