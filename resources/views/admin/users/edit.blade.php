@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Edit User</h1>
            <p class="mt-1 text-sm text-slate-500">Update user account details, role, and password.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l2 2m2-2l-2-2m0 0l2 2m-2-2l2 2"></path></svg>
                <span>Please fix the errors below:</span>
            </div>
        @endif

        <div class="card bg-white shadow-xl border border-slate-200">
            <div class="card-body gap-5 p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="name" class="label">
                            <span class="label-text font-medium text-slate-700">Name</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="input input-bordered w-full border-slate-300 bg-white @error('name') input-error @enderror" required />
                        @error('name')<span class="mt-1 text-error text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="email" class="label">
                            <span class="label-text font-medium text-slate-700">Email</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full border-slate-300 bg-white @error('email') input-error @enderror" required />
                        @error('email')<span class="mt-1 text-error text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="password" class="label">
                            <span class="label-text font-medium text-slate-700">Password (leave blank to keep current)</span>
                        </label>
                        <input type="password" id="password" name="password" class="input input-bordered w-full border-slate-300 bg-white @error('password') input-error @enderror" />
                        @error('password')<span class="mt-1 text-error text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="password_confirmation" class="label">
                            <span class="label-text font-medium text-slate-700">Confirm Password</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input input-bordered w-full border-slate-300 bg-white" />
                    </div>

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="phone" class="label">
                            <span class="label-text font-medium text-slate-700">Phone</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="input input-bordered w-full border-slate-300 bg-white @error('phone') input-error @enderror" required />
                        @error('phone')<span class="mt-1 text-error text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-control rounded-lg border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <label for="role" class="label">
                            <span class="label-text font-medium text-slate-700">Role</span>
                        </label>
                        <select name="role" id="role" class="select select-bordered w-full border-slate-300 bg-white @error('role') select-error @enderror" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('role')<span class="mt-1 text-error text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="btn btn-primary flex-1">Update User</button>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline flex-1">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
