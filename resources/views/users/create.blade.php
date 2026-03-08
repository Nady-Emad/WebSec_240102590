@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 mb-0">Add New User</h1>
                    <a href="{{ route('lab3.users.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('lab3.users.store') }}" method="POST">
                        @csrf
                        @include('users._form', ['buttonText' => 'Create User'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

