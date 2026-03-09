<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">

    <title>{{ config('app.name', 'Cards') }}</title>
    <!-- Google tag (gtag.js) -->

    <meta name="description"
        content="TapPayz offers instant virtual payment cards with 3DS support for secure online transactions. Create your card today and shop with confidence!">
    <meta name="keywords"
        content="virtual payment cards, 3DS support, secure online transactions, instant card creation, TapPayz, online shopping, digital payments, prepaid cards, virtual credit cards, secure payments">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    @if (session('status'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
        </style>
        <div id="alertBox"
            class="flex items-center justify-between bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-xl shadow-lg max-w-md animate-fade-in">
            <span>{{ session('status') }}</span>
            <button onclick="document.getElementById('alertBox').remove()"
                class="ml-4 text-green-700 hover:text-green-900 font-bold text-2xl">X</button>
        </div>
    </div>
    @endif

    {{-- layout styles --}}
    <style>
        /* GLOBAL FIX */

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Activates Mobile */
        @media (max-width: 769px) {
            #sidebar_id {
                display: none;
            }

            .container_app {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                width: 100%;
            }
        }

        /* Desktop */
        @media (min-width: 768px) {
            #mobile_top_nav {
                display: none;
            }

            .container_app {
                display: grid;
                grid-template-columns: minmax(0, 280px) minmax(0, 1fr);
                width: 100%;
            }
        }


        /* MOBILE DRAWER */
        #mob_sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            /* background: #1f2937; */
            background: white;
            /* gray-800 */
            color: white;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 50;
        }

        /* OPEN STATE */
        #mob_sidebar.open {
            transform: translateX(0);
        }

        /* BACKDROP */
        #drawer_backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 40;
            display: none;
        }

        #drawer_backdrop.show {
            display: block;
        }
    </style>

    {{-- MOBILE DRAWER --}}
    <div id="mob_sidebar" class="fixed top-0 left-0 z-50 h-[calc(100vh-3rem)] w-72 shadow-2xl
            rounded-r-2xl flex flex-col overflow-y-auto
            px-3 py-4 space-y-1">

        {{-- NAV ITEM --}}
        @php
        $item = fn ($active) => [
        'relative flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition',
        $active
        ? 'bg-emerald-600/20 text-emerald-400'
        : 'text-gray-300 hover:bg-gray-800 hover:text-emerald-400',
        ];
        @endphp

        <a href="{{ route('dashboard') }}"
            @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
            , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800'=>
            request()->routeIs('dashboard'),
            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
            dark:hover:text-slate-200 border-transparent' => !request()->routeIs('dashboard'),
            ])>
            <span
                class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-800/50 text-emerald-600 dark:text-emerald-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 5.25h16.5M3.75 9.75h7.5m-7.5 4.5h16.5M3.75 18.75h7.5" />
                </svg>
            </span>
            Dashboard
        </a>

        <a href="{{ route('cards') }}"
            @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
            , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800'=>
            request()->routeIs('cards'),
            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
            dark:hover:text-slate-200 border-transparent' => !request()->routeIs('cards'),
            ])>
            <span
                class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </span>
            My Cards
        </a>

        {{-- Transactions --}}
        <a href="{{ route('transactions') }}" @class($item(request()->routeIs('transactions') ||
            request()->is('transactions/*')))>
            @if(request()->routeIs('transactions') || request()->is('transactions/*'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-document-text class="h-5 w-5" />
            <span>Transactions</span>
        </a>

        {{-- Fundings --}}
        <a href="{{ route('fundings') }}" @class($item(request()->routeIs('fundings')))>
            @if(request()->routeIs('fundings'))
            <span class="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r"></span>
            @endif
            <x-heroicon-o-banknotes class="h-5 w-5" />
            <span>Funding</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-gray-800">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
                       text-sm font-medium text-red-400
                       hover:bg-red-500/10 transition">
                <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5" />
                <span>Logout</span>
            </button>
        </form>


    </div>


    <div id="drawer_backdrop"></div>


    <div class="container_app  w-full">
        {{-- Sidebar (20%) --}}
        <div id="sidebar_id" class="w-full flex flex-col">
            @include('layouts.aside')
        </div>

        {{-- Main Content (80%) --}}

        <main class="min-h-screen bg-gray-100 right_side">

            <div class="relative z-[999]">
                @include('layouts.app_header')
            </div>

            {{ $slot }}
        </main>
    </div>

    <script>
        const iconBtn = document.getElementById('icon_btn');
        const drawer = document.getElementById('mob_sidebar');
        const backdrop = document.getElementById('drawer_backdrop');

        iconBtn.addEventListener('click', () => {
            drawer.classList.add('open');
            backdrop.classList.add('show');
        });

        backdrop.addEventListener('click', () => {
            drawer.classList.remove('open');
            backdrop.classList.remove('show');
        });
    </script>

</body>

</html>