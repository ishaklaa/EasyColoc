@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Titre de la colocation --}}
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-gray-800">{{ $colocation->titre }}</h1>
            <p class="text-gray-500 mt-2">Tableau de bord membre</p>
        </div>

        {{-- Membres --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Membres</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($members as $user)
                    <div class="bg-gray-50 rounded-xl p-4 border">
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bouton pour créer une dépense --}}
        <div class="mb-10">
            <a href="{{ route('depense.create', $colocation->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow transition">
                Ajouter une dépense
            </a>
        </div>

        {{-- Dépenses non payées --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
            <h2 class="text-2xl font-semibold text-red-600 mb-6">Dépenses non payées</h2>
            <div class="space-y-4">
                @forelse($depensesNonPayees as $depense)
                    <div class="bg-red-50 p-4 rounded-lg border flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $depense->titre }} - {{ $depense->montant }}Dh</p>
                            <p class="text-gray-500 text-sm">Catégorie : {{ $depense->categorie ?? 'Non définie' }}</p>
                        </div>
                        <form method="POST" action="{{ route('depense.payer', $depense->id) }}">
                            @csrf
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition">
                                Payer
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune dépense non payée 🎉</p>
                @endforelse
            </div>
        </div>

        {{-- Dépenses payées --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
            <h2 class="text-2xl font-semibold text-green-600 mb-6">Dépenses payées</h2>
            <div class="space-y-4">
                @forelse($depensesPayees as $depense)
                    <div class="bg-green-50 p-4 rounded-lg border flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $depense->titre }} - {{ $depense->montant }}Dh</p>
                            <p class="text-gray-500 text-sm">Catégorie : {{ $depense->categorie ?? 'Non définie' }}</p>
                        </div>
                        <span class="text-green-600 font-semibold">✔ Payé</span>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune dépense payée.</p>
                @endforelse
            </div>
        </div>

        {{-- Qui doit à qui --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Qui doit à qui</h2>
            <div class="space-y-2">
                @forelse($dettes as $dette)
                    <p class="text-gray-700">{{ $dette->debiteur->name }} doit {{ $dette->creancier->name }} {{ $dette->montant }}dh</p>
                @empty
                    <p class="text-gray-500">Aucune dette pour le moment.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection