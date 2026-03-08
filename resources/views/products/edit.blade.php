@extends('layouts.app')

@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@push('styles')
<style>
    .preview-image {
        max-width: 260px;
        max-height: 260px;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ $product->exists ? 'Edit Product' : 'Add Product' }}</h1>
        <a href="{{ route('lab1.products.index') }}" class="btn btn-outline-secondary">Back to Products</a>
    </div>

    <div class="content-card card">
        <div class="card-body p-4">
            <form action="{{ route('lab1.products.save', $product->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $product->code) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $product->model) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" min="0" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="col-12">
                    <label for="photo_file" class="form-label">Upload Photo</label>
                    <input type="file" name="photo_file" id="photo_file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.gif">
                    <div class="form-text">Allowed: JPG, PNG, WEBP, GIF. Max size: 2MB.</div>
                </div>

                <div class="col-12">
                    <label for="photo" class="form-label">Photo URL (optional)</label>
                    <input type="url" name="photo" id="photo" class="form-control" value="{{ old('photo', $product->photo) }}" placeholder="https://example.com/product.jpg">
                    <div class="form-text">Use HTTPS links only when needed. Uploaded file has priority.</div>
                </div>

                @php
                    $photoValue = old('photo', $product->photo);
                    $photoSrc = null;

                    if ($photoValue) {
                        $isHttpUrl = filter_var($photoValue, FILTER_VALIDATE_URL)
                            && in_array(strtolower((string) parse_url($photoValue, PHP_URL_SCHEME)), ['http', 'https'], true);

                        if ($isHttpUrl) {
                            $photoSrc = $photoValue;
                        } elseif (
                            \Illuminate\Support\Str::startsWith($photoValue, 'products/')
                        ) {
                            $photoSrc = asset('storage/' . $photoValue);
                        } else {
                            $photoSrc = asset("images/$photoValue");
                        }
                    }
                @endphp

                @if ($photoSrc)
                    <div class="col-12">
                        <label class="form-label">Image Preview</label>
                        <div>
                            <img src="{{ $photoSrc }}" alt="{{ old('name', $product->name) }}" class="img-thumbnail preview-image">
                        </div>
                    </div>
                @endif

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="col-12 d-flex flex-wrap gap-2 pt-2">
                    <button type="submit" class="btn btn-success">Save Product</button>
                    <a href="{{ route('lab1.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
