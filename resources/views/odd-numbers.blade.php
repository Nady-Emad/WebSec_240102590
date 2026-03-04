@extends('layouts.app')

@section('title', 'Odd Numbers')

@section('content')
    <div class="card m-4">
        <div class="card-header">Odd Numbers (1-50)</div>
        <div class="card-body">
            @foreach (range(1, 50) as $i)
                @if($i%2!=0)
                    <span class="badge bg-primary">{{$i}}</span>
                @else
                    <span class="badge bg-secondary">{{$i}}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection
