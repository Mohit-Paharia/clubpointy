{{-- resources/views/authentication/check-email.blade.php --}}
@extends('layouts.app')

@section('title', 'Check Your Email')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full text-center">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Check your email</h2>
            <p class="text-gray-600 mb-6">We've sent you a verification link. Please check your email and click the link to verify your account.</p>
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Back to Login</a>
        </div>
    </div>
</div>
@endsection

