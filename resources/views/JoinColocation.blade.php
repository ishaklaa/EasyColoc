@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-md mx-auto px-6">

            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Rejoindre une colocation</h1>
                <p class="text-gray-500 mt-2">Entrez le token d'invitation pour rejoindre la colocation</p>
            </div>

            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif


            <form method="POST" action="{{ route('colocations.joinByToken') }}">
                @csrf

                <div class="mb-6">
                    <label for="token" class="block text-sm font-medium text-gray-700 mb-2">Token</label>
                    <input type="text" name="token" id="token" placeholder="Entrez le token"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                    Rejoindre
                </button>
            </form>

        </div>
    </div>
@endsection