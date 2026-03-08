@extends('layouts.app')

@section('title', 'Products Catalog')

@push('styles')
<style>
    .filter-card {
        border: 0;
        border-radius: 1rem;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.07);
    }

    .catalog-card {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 0.7rem 1.8rem rgba(15, 23, 42, 0.08);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .catalog-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 2rem rgba(15, 23, 42, 0.12);
    }

    .catalog-image-wrap {
        height: 230px;
        background: radial-gradient(circle at top, #f8fafc, #eef2f7);
        border-bottom: 1px solid #e8edf3;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 0.75rem;
    }

    .catalog-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .cart-panel {
        position: sticky;
        top: 88px;
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.09);
    }

    .cart-item {
        border: 1px solid #e6ebf2;
        border-radius: 0.75rem;
        padding: 0.75rem;
        background: #fbfcfe;
    }

    .empty-state {
        border: 2px dashed #d9e2ec;
        border-radius: 1rem;
        background: #f8fafc;
    }

    @media (max-width: 991.98px) {
        .cart-panel {
            position: static;
        }
    }
</style>
@endpush

@section('content')
    @php
        $productsTotal = method_exists($products, 'total') ? $products->total() : $products->count();
    @endphp

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Products Catalog</h1>
            <p class="text-muted mb-0">Filter products quickly and manage your cart in one place.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge rounded-pill text-bg-dark px-3 py-2">Products: {{ $productsTotal }}</span>
            <span class="badge rounded-pill text-bg-success px-3 py-2">Cart Items: {{ $cartItemsCount }}</span>
        </div>
    </div>

    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('lab2.products.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6 col-xl-3">
                    <label for="keywords" class="form-label">Search</label>
                    <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Name keywords" value="{{ $keywords }}">
                </div>

                <div class="col-md-6 col-xl-2">
                    <label for="min_price" class="form-label">Min Price</label>
                    <input type="number" id="min_price" name="min_price" class="form-control" min="0" step="0.01" value="{{ $minPrice }}">
                </div>

                <div class="col-md-6 col-xl-2">
                    <label for="max_price" class="form-label">Max Price</label>
                    <input type="number" id="max_price" name="max_price" class="form-control" min="0" step="0.01" value="{{ $maxPrice }}">
                </div>

                <div class="col-md-6 col-xl-2">
                    <label for="product_type" class="form-label">Type</label>
                    <select id="product_type" name="product_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach ($productTypes as $type)
                            <option value="{{ $type }}" {{ $selectedType === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-xl-1">
                    <label for="name_sort" class="form-label">Name</label>
                    <select id="name_sort" name="name_sort" class="form-select">
                        <option value="">-</option>
                        <option value="asc" {{ $nameSort === 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ $nameSort === 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                <div class="col-md-6 col-xl-1">
                    <label for="price_sort" class="form-label">Price</label>
                    <select id="price_sort" name="price_sort" class="form-select">
                        <option value="">-</option>
                        <option value="asc" {{ $priceSort === 'asc' ? 'selected' : '' }}>Low</option>
                        <option value="desc" {{ $priceSort === 'desc' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div class="col-12 d-flex gap-2 pt-1">
                    <button type="submit" class="btn btn-success">Apply Filters</button>
                    <a href="{{ route('lab2.products.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 col-xl-9">
            <div class="row g-4">
                @forelse ($products as $product)
                    @php
                        $photoValue = (string) ($product->photo ?? '');
                        $isHttpUrl = $photoValue !== ''
                            && filter_var($photoValue, FILTER_VALIDATE_URL)
                            && in_array(strtolower((string) parse_url($photoValue, PHP_URL_SCHEME)), ['http', 'https'], true);

                        if ($isHttpUrl) {
                            $photoSrc = $photoValue;
                        } elseif ($photoValue !== '' && \Illuminate\Support\Str::startsWith($photoValue, 'products/')) {
                            $photoSrc = asset('storage/' . $photoValue);
                        } else {
                            $photoSrc = asset('images/' . ($photoValue !== '' ? $photoValue : 'placeholder.png'));
                        }
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <div class="card catalog-card h-100">
                            <div class="catalog-image-wrap">
                                <img src="{{ $photoSrc }}" alt="{{ $product->name }}" class="catalog-image" loading="lazy">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                    <h2 class="h6 mb-0">{{ $product->name }}</h2>
                                    <span class="badge text-bg-light border text-dark">{{ $product->model ?: 'N/A' }}</span>
                                </div>

                                <p class="text-muted small flex-grow-1 mb-3">{{ \Illuminate\Support\Str::limit($product->description ?: 'No description.', 90) }}</p>

                                <div class="d-flex justify-content-between align-items-center gap-2 mt-auto">
                                    <span class="fw-bold fs-5">${{ number_format((float) $product->price, 2) }}</span>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('lab1.products.show', ['product' => $product->id, 'from' => 'lab2']) }}" class="btn btn-outline-success btn-sm">View</a>
                                        <form method="POST" action="{{ route('lab2.products.add_to_cart', $product) }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state p-4 text-center text-muted">
                            No products found for selected filters.
                        </div>
                    </div>
                @endforelse
            </div>

            @if (method_exists($products, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <div class="col-lg-4 col-xl-3">
            <div class="card cart-panel">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h3 class="h6 mb-0">Shopping Cart</h3>
                    @if ($cartItemsCount > 0)
                        <form method="POST" action="{{ route('lab2.products.clear_cart') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Clear</button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($cartRows) === 0)
                        <div class="empty-state p-3 text-center text-muted">Your cart is empty.</div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach ($cartRows as $row)
                                <div class="cart-item">
                                    <div class="fw-semibold mb-1">{{ $row['name'] }}</div>
                                    <div class="small text-muted mb-2">${{ number_format($row['price'], 2) }} x {{ $row['quantity'] }}</div>
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <span class="fw-semibold">${{ number_format($row['line_total'], 2) }}</span>
                                        <div class="d-flex gap-1">
                                            <form method="POST" action="{{ route('lab2.products.remove_from_cart', $row['id']) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                                            </form>
                                            <form method="POST" action="{{ route('lab2.products.add_to_cart', $row['id']) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">+</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-bold fs-5">${{ number_format($cartTotal, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
