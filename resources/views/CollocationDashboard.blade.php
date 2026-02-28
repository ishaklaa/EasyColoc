@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-6">

            
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">
                        Colocations Dashboard
                    </h1>
                    <p class="text-gray-500 mt-2">
                        List of all colocations
                    </p>
                </div>

                
                <a href="{{ route('admin.colocations.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition">
                    Créer une colocation
                </a>
            </div>

           
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($colocations as $colocation)
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition min-h-[140px] flex flex-col justify-between">

                        <div>
                            
                            <h2 class="text-xl font-semibold text-gray-800">
                                {{ $colocation->titre }}
                            </h2>

                            
                            <p class="text-sm text-gray-500 mt-3">
                                Owner:
                                <span class="font-medium text-gray-700">
                                    {{ $colocation->owner->first()->name ?? 'N/A' }}
                                </span>
                            </p>
                        </div>

                        

                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        No colocations found.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection