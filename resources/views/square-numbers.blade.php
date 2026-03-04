@extends('layouts.app')

@section('title', 'Square Numbers')

@section('content')
    <div class="card m-4">
        <div class="card-header">Square Numbers (1-20)</div>
        <div class="card-body">
            @foreach (range(1, 20) as $i)
                @if(sqrt($i) == floor(sqrt($i)))
                    <span class="badge bg-primary">{{$i}}</span>
                @else
                    <span class="badge bg-secondary">{{$i}}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection
