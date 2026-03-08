@extends('layouts.app')

@section('title', 'System Status')

@section('content')
    <div class="content-card card">
        <div class="card-header bg-success-subtle border-0 py-3">
            <h1 class="h5 mb-0">System Status</h1>
        </div>
        <div class="card-body p-4">
            <p class="mb-3">Laravel environment is running successfully.</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100 bg-light">
                        <div class="small text-muted">Service</div>
                        <div class="fw-semibold">WebSecService</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100 bg-light">
                        <div class="small text-muted">Server Time</div>
                        <div class="fw-semibold">{{ now()->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
