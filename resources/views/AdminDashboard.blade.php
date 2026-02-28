@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-6">

            
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">
                        EasyColoc - Admin Dashboard
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Manage all users and their status
                    </p>
                </div>

                <div class="flex gap-4">
                    
                    <a href="{{ route('admin.colocations.index') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Colocation Dashboard
                    </a>

                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

           
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Nombre des colocations</span>
                    <span class="text-2xl font-bold text-indigo-600">{{ $colocationsCount ?? 0 }}</span>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Utilisateurs bannés</span>
                    <span class="text-2xl font-bold text-red-500">{{ $bannedUsersCount ?? 0 }}</span>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center">
                    <span class="text-gray-500 text-sm">Nombre des utilisateurs</span>
                    <span class="text-2xl font-bold text-green-600">{{ $usersCount ?? 0 }}</span>
                </div>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $user)
                    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

                       
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $user->name }}
                        </h2>

                       
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $user->email }}
                        </p>

                        
                        <div class="mt-4">
                            <span class="text-sm text-gray-600">Reputation:</span>
                            <span class="font-bold text-indigo-600">
                                {{ $user->reputation ?? 0 }}
                            </span>
                        </div>

                        
                        <div class="mt-6">
                            <form method="POST" action="{{ route('admin.users.updateStatus', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>

                                <select name="status" onchange="this.form.submit()"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                                    <option value="active" {{ $user->statut === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="bloque" {{ $user->statut === 'bloque' ? 'selected' : '' }}>
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