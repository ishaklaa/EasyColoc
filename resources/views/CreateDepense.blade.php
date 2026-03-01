@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer une nouvelle dépense</h1>

                <form method="POST" action="{{ route('depense.store', $colocation->id) }}">
                    @csrf

                    {{-- Titre --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                    </div>

                    {{-- Catégorie --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="categorie_id">Catégorie</label>
                        <select name="categorie_id" id="categorie_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->titre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payeur --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="payeur_id">Payeur</label>
                        <select name="payeur_id" id="payeur_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                            <option value="">Sélectionner un membre</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Montant total --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2" for="montant">Montant total (€)</label>
                        <input type="number" name="montant" id="montant" min="0" step="0.01" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                    </div>

                    <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg shadow transition">
                        Créer la dépense
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection