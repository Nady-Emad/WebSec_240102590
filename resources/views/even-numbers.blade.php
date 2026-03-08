@extends('layouts.app')

@section('title', 'Even Numbers')

@section('content')
    <div class="content-card card">
        <div class="card-header py-3">
            <h1 class="h5 mb-0">Even Numbers (1-100)</h1>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach (range(1, 100) as $i)
                    <span class="badge {{ $i % 2 === 0 ? 'bg-primary' : 'bg-light text-dark border' }} fs-6 fw-normal">{{ $i }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
