@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Header -->
            <div class="mb-10 flex justify-between items-center">

                <div>
                    <h1 class="text-4xl font-bold text-gray-800">
                        EasyColoc - Admin Dashboard
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Manage all users and their status
                    </p>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Logout
                    </button>
                </form>

            </div>

            <!-- Users Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $user)
                    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

                        <!-- User Name -->
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $user->name }}
                        </h2>

                        <!-- Email -->
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $user->email }}
                        </p>

                        <!-- Reputation -->
                        <div class="mt-4">
                            <span class="text-sm text-gray-600">Reputation:</span>
                            <span class="font-bold text-indigo-600">
                                {{ $user->reputation ?? 0 }}
                            </span>
                        </div>

                        <!-- Status Select -->
                        <div class="mt-6">
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>

                                <select name="status" onchange="this.form.submit()"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="bloque" {{ $user->status === 'bloque' ? 'selected' : '' }}>
                                        Bloqué
                                    </option>

                                </select>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection