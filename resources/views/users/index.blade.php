@extends('layouts.app')

@section('title', 'Users CRUD')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Users Management</h1>
            <p class="text-muted mb-0">Search, filter, and maintain user records.</p>
        </div>
        <a href="{{ route('lab3.users.create') }}" class="btn btn-primary">Add New User</a>
    </div>

    <div class="content-card card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('lab3.users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Name or email" value="{{ $search }}">
                </div>

                <div class="col-md-4">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach ($roles as $roleOption)
                            <option value="{{ $roleOption }}" {{ $role === $roleOption ? 'selected' : '' }}>{{ ucfirst($roleOption) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">Apply</button>
                    <a href="{{ route('lab3.users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="content-card card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge text-bg-secondary">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('lab3.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('lab3.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
@endsection

