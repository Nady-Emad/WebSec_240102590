@extends('layouts.app')

@section('title', 'Square Numbers')

@section('content')
    <div class="content-card card">
        <div class="card-header py-3">
            <h1 class="h5 mb-0">Square Numbers (1-20)</h1>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach (range(1, 20) as $i)
                    <span class="badge {{ sqrt($i) == floor(sqrt($i)) ? 'bg-primary' : 'bg-light text-dark border' }} fs-6 fw-normal">{{ $i }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
