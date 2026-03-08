@php
    $isEdit = isset($user) && $user->exists;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $isEdit ? $user->name : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $isEdit ? $user->email : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="role" class="form-label">Role</label>
        <select id="role" name="role" class="form-select" required>
            @php $selectedRole = old('role', $isEdit ? $user->role : 'student'); @endphp
            @foreach (['student', 'instructor', 'admin'] as $roleOption)
                <option value="{{ $roleOption }}" {{ $selectedRole === $roleOption ? 'selected' : '' }}>{{ ucfirst($roleOption) }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="password" class="form-label">Password {{ $isEdit ? '(Optional)' : '' }}</label>
        <input type="password" id="password" name="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Confirm Password {{ $isEdit ? '(Optional)' : '' }}</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
    </div>
</div>

<div class="d-flex gap-2 pt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('lab3.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

