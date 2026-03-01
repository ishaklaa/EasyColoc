@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Titre de la colocation --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-800">
                    {{ $colocation->titre }}
                </h1>
                <p class="text-gray-500 mt-2">
                    Gestion de la colocation
                </p>
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

            {{-- Catégories --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Catégories</h2>
                <div class="mb-6">
                    @forelse($categories as $category)
                        <div class="inline-block bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm mr-2 mb-2">
                            {{ $category->titre }}
                        </div>
                    @empty
                        <p class="text-gray-500">Aucune catégorie pour le moment.</p>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('store.categorie', $colocation->id) }}">
                    @csrf
                    <div class="flex gap-4">
                        <input type="text" name="categorie" placeholder="Nom de la catégorie"
                            class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg shadow transition">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Générer un token d'invitation --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Générer un Token d'invitation</h2>
                <form method="POST" action="{{ route('owner.colocation.token', $colocation->id) }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow transition">
                        Générer Token
                    </button>
                </form>
                @if($invitation_token)
                    <div class="mt-6 p-4 bg-green-50 border border-green-300 rounded-lg">
                        <p class="text-sm text-gray-600 mb-2">Token actuel :</p>
                        <div class="bg-white p-3 rounded-lg border">
                            <span class="font-mono text-green-600 break-all">{{ $invitation_token }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Dépenses --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dépenses</h2>

                {{-- Bouton pour créer une dépense --}}
                <a href="{{ route('depense.create', $colocation->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow transition mb-6 inline-block">
                    Ajouter une dépense
                </a>

                {{-- Liste des dépenses --}}
                <div class="space-y-4 mt-4">
                    @forelse($depenses as $depense)
                        <div class="bg-gray-50 p-4 rounded-lg border flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $depense->titre }} - {{ $depense->montant }}€</p>
                                <p class="text-gray-500 text-sm">
                                    Catégorie : {{ $depense->categorie->titre ?? 'Non définie' }}
                                </p>
                            </div>

                            <div>
                                @if(!$depense->is_paid)
                                    <form method="POST" action="{{ route('depense.payer', $depense->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition">
                                            Payer
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-600 font-semibold">La dépense est payée</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucune dépense pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- Qui doit à qui --}}
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Qui doit à qui</h2>
                <div class="space-y-2">
                    @forelse($dettes as $dette)
                        <p class="text-gray-700">
                            {{ $dette->debiteur->name }} doit {{ $dette->creancier->name }} {{ $dette->montant }}€
                        </p>
                    @empty
                        <p class="text-gray-500">Aucune dette pour le moment.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection