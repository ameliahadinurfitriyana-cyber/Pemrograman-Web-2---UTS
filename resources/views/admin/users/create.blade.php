@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Create New User</h1>

    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2m-2-2l-2-2m0 0l-2 2m2-2l2 2"></path></svg>
            <span>Please fix the errors below:</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-lg">
        @csrf
        <div class="form-control mb-4">
            <label for="name" class="label">
                <span class="label-text">Name</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
            @error('name')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="email" class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full @error('email') input-error @enderror" required />
            @error('email')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="password" class="label">
                <span class="label-text">Password</span>
            </label>
            <input type="password" id="password" name="password" class="input input-bordered w-full @error('password') input-error @enderror" required />
            @error('password')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="password_confirmation" class="label">
                <span class="label-text">Confirm Password</span>
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="input input-bordered w-full" required />
        </div>

        <div class="form-control mb-4">
            <label for="phone" class="label">
                <span class="label-text">Phone</span>
            </label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input input-bordered w-full @error('phone') input-error @enderror" required />
            @error('phone')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4">
            <label for="role" class="label">
                <span class="label-text">Role</span>
            </label>
            <select name="role" id="role" class="select select-bordered w-full @error('role') select-error @enderror" required>
                <option value="">-- Select Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>
            @error('role')<span class="text-error text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-control mb-4 flex flex-row gap-2">
            <button type="submit" class="btn btn-primary flex-1">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost flex-1">Cancel</a>
        </div>
    </form>
@endsection
