{{-- resources/views/authentication/expired-url.blade.php --}}
@extends('layouts.app')

@section('title', 'Link Expired')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full text-center">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Link Expired</h2>
            <p class="text-gray-600 mb-6">This verification link has expired. Please register again to receive a new verification email.</p>
            <a href="{{ route('register.show') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Register Again</a>
        </div>
    </div>
</div>
@endsection