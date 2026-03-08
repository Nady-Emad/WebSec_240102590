@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="content-card card mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="h3 mb-2">Welcome to WebSecService</h1>
                    <p class="text-muted mb-0">
                        Explore number utilities and manage products from one clean, responsive interface.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('products_list') }}" class="btn btn-primary">Open Products</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 col-lg-3"><a class="btn btn-outline-secondary w-100" href="{{ url('/even-numbers') }}">Even Numbers</a></div>
        <div class="col-md-6 col-lg-3"><a class="btn btn-outline-secondary w-100" href="{{ url('/odd-numbers') }}">Odd Numbers</a></div>
        <div class="col-md-6 col-lg-3"><a class="btn btn-outline-secondary w-100" href="{{ url('/prime-numbers') }}">Prime Numbers</a></div>
        <div class="col-md-6 col-lg-3"><a class="btn btn-outline-secondary w-100" href="{{ url('/square-numbers') }}">Square Numbers</a></div>
    </div>
@endsection
