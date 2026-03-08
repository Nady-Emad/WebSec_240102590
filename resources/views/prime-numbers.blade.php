@extends('layouts.app')

@section('title', 'Prime Numbers')

@section('content')
    @php
        $isPrime = static function (int $number): bool {
            if ($number < 2) {
                return false;
            }

            if ($number === 2) {
                return true;
            }

            if ($number % 2 === 0) {
                return false;
            }

            for ($i = 3; $i <= sqrt($number); $i += 2) {
                if ($number % $i === 0) {
                    return false;
                }
            }

            return true;
        };
    @endphp

    <div class="content-card card">
        <div class="card-header py-3">
            <h1 class="h5 mb-0">Prime Numbers (1-100)</h1>
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
