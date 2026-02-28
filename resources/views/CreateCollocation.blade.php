@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto px-6">

        <div class="bg-white rounded-2xl shadow-md p-8">

            <h1 class="text-3xl font-bold text-gray-800 mb-6">
                Create New Colocation
            </h1>

            <form method="POST" action="{{ route('admin.colocations.store') }}">
                @csrf

                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Titre
                    </label>
                    <input type="text" name="titre" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

               

                

                
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Create
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection