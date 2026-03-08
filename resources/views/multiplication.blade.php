@extends('layouts.app')

@section('title', 'Multiplication Table')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="content-card card h-100">
                <div class="card-header py-3">
                    <h1 class="h5 mb-0">Choose Multiplier</h1>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ url('/multiplication') }}">
                        <div class="mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="number" name="number" id="number" min="1" class="form-control" value="{{ (int) $j }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Generate Table</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="content-card card h-100">
                <div class="card-header py-3">
                    <h2 class="h5 mb-0">{{ $j }} Multiplication Table</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expression</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (range(1, 10) as $i)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $i }} x {{ $j }}</td>
                                        <td class="fw-semibold">{{ $i * $j }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
