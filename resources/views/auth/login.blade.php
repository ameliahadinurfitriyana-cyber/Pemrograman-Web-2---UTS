@extends('layouts.guest')

@section('content')
<div class="w-full flex justify-center">
    <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white shadow-2xl p-8">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-slate-900">Login Mel.Dev</h2>
            <p class="text-sm text-slate-500">Masuk untuk melanjutkan ke sistem kasir</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p>Login gagal. Periksa kembali email dan password Anda.</p>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700" for="password">Password</label>
                <input type="password" name="password" id="password" class="mt-1 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" required>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" />
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary-focus">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-primary-focus">Login</button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            <span>Don't have an account?</span>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-primary-focus">Register</a>
            @endif
        </div>
    </div>
</div>
@endsection
