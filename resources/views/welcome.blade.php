@extends('layouts.landing')

@section('content')


    <div class="min-h-screen bg-gradient-to-br from-indigo-600 to-purple-700 flex flex-col">

       
        <div class="flex flex-1 items-center justify-center px-6">
            <div class="text-center text-white max-w-3xl">

                <h1 class="text-5xl font-extrabold mb-6">
                    Welcome to EasyColoc
                </h1>

                <p class="text-lg opacity-90 mb-8">
                    The smart way to manage shared living.
                    Connect with roommates, track reputation,
                    and create a better colocation experience.
                </p>

                <div class="flex justify-center gap-4">

                    @guest
                        <a href="{{ route('login') }}"
                            class="px-6 py-3 border border-white rounded-lg hover:bg-white hover:text-indigo-600 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Get Started
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('profile.dashboard') }}"
                            class="px-8 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Go to Dashboard
                        </a>
                    @endauth

                </div>

            </div>
        </div>

        
        <div class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-center">

                <div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        Reputation System
                    </h3>
                    <p class="text-gray-600">
                        Build trust between roommates with a transparent reputation score.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        User Management
                    </h3>
                    <p class="text-gray-600">
                        Easily manage users and maintain a safe community.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        Smart Living
                    </h3>
                    <p class="text-gray-600">
                        Simplify shared responsibilities and improve communication.
                    </p>
                </div>

            </div>
        </div>

        
        <footer class="text-center py-6 text-white bg-indigo-700">
            © {{ date('Y') }} EasyColoc. All rights reserved.
        </footer>

    </div>
@endsection