@extends('layouts.app')

@section('title', 'Odd Numbers')

@section('content')
    <div class="content-card card">
        <div class="card-header py-3">
            <h1 class="h5 mb-0">Odd Numbers (1-50)</h1>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach (range(1, 50) as $i)
                    <span class="badge {{ $i % 2 !== 0 ? 'bg-primary' : 'bg-light text-dark border' }} fs-6 fw-normal">{{ $i }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
