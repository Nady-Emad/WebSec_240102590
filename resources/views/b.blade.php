@extends('layouts.app')

@section('title', 'Records & Prime Check')

@section('content')
    @php
        $isPrime = static function (int $num): bool {
            if ($num < 2) {
                return false;
            }
            if ($num === 2) {
                return true;
            }
            if ($num % 2 === 0) {
                return false;
            }
            for ($i = 3; $i <= sqrt($num); $i += 2) {
                if ($num % $i === 0) {
                    return false;
                }
            }
            return true;
        };
    @endphp

    <div class="content-card card mb-4">
        <div class="card-header py-3">
            <h1 class="h5 mb-0">Records Summary</h1>
        </div>
        <div class="card-body">
            @if (count($records) === 1)
                <div class="alert alert-info mb-0">I have one record.</div>
            @elseif (count($records) > 1)
                <div class="alert alert-success mb-0">I have multiple records ({{ count($records) }}).</div>
            @else
                <div class="alert alert-warning mb-0">I don't have any records.</div>
            @endif
        </div>
    </div>

    <div class="content-card card">
        <div class="card-header py-3">
            <h2 class="h5 mb-0">Prime Numbers (1-100)</h2>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach (range(1, 100) as $i)
                    <span class="badge {{ $isPrime($i) ? 'bg-primary' : 'bg-light text-dark border' }} fs-6 fw-normal">{{ $i }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
