@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="hero min-h-screen bg-base-200 rounded-xl shadow-md">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Welcome to MyApp!</h1>
                <p class="py-6">This is a simple Laravel homepage using DaisyUI components.</p>
                <a href="#" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </div>
@endsection
