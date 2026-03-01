@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        User Dashboard 👋
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Welcome back, {{ auth()->user()->name }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mb-10">
                <a href="{{ route('admin.colocations.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                    Créer une colocation
                </a>

                <a href="{{ route('colocations.joinForm') }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                    Rejoindre une colocation
                </a>
            </div>

            <!-- Current Colocation -->
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    Colocation actuelle
                </h2>

                @if($currentColocation ?? null)
                    <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ $currentColocation->titre }}
                            </h3>
                            <p class="text-gray-500 mt-2">
                                Status: {{ $currentColocation->statut }}
                            </p>
                        </div>

                        <a href="{{ route('colocations.show', $currentColocation->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow transition">
                            Entrer
                        </a>
                    </div>
                @else
                    <p class="text-gray-500">
                        Vous n'êtes dans aucune colocation active.
                    </p>
                @endif
            </div>

            <!-- Past Colocations -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    Anciennes colocations
                </h2>

                @forelse($pastColocations ?? collect() as $colocation)
                    <div class="bg-white p-6 rounded-2xl shadow-md mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $colocation->titre }}
                        </h3>
                        <p class="text-gray-500 mt-1">
                            Status: {{ $colocation->statut }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 italic text-center mt-4">
                        Aucune ancienne colocation.
                    </p>
                @endforelse
            </div>

        </div>
    </div>
@endsection