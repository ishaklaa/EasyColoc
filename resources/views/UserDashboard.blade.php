@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-10 rounded-2xl shadow-lg text-center">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Welcome User 👋
        </h1>

        <p class="text-gray-500 mb-8">
            You are logged in successfully.
        </p>

        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                Logout
            </button>
        </form>

    </div>
</div>
@endsection