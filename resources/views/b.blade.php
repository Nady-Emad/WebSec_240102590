@extends('layouts.app')

@section('title', 'Prime Numbers')

@section('content')
    <div class="card m-4">
        <div class="card-header">
            @if (count($records) === 1)
                I have one record!
            @elseif (count($records) > 1)
                I have multiple records!
            @else
                I don't have any records!
            @endif
        </div>

        <div class="card-body">
            @php
                function isPrime($num) {
                    if ($num < 2) return false;
                    if ($num == 2) return true;
                    if ($num % 2 == 0) return false;
                    for ($i = 3; $i <= sqrt($num); $i += 2) {
                        if ($num % $i == 0) return false;
                    }
                    return true;
                }
            @endphp
            
            @foreach (range(1, 100) as $i)
                @if(isPrime($i))
                    <span class="badge bg-primary">{{$i}}</span>
                @else
                    <span class="badge bg-secondary">{{$i}}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection