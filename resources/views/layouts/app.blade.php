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
        content="Lanocard offers instant virtual payment cards with 3DS support for secure online transactions. Create your card today and shop with confidence!">
    <meta name="keywords"
        content="virtual payment cards, 3DS support, secure online transactions, instant card creation, Lanocard, online shopping, digital payments, prepaid cards, virtual credit cards, secure payments">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=PaTdWCwk68r2"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-screen overflow-hidden flex flex-col">

    @if (session('status'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 mt-20">
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

        :root {
            --mobile-header-height: 65px;
        }

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
                min-height: 0;
                height: 100%;
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
                min-height: 0;
                height: 100%;
            }
        }


        /* MOBILE DRAWER */
        #mob_sidebar {
            position: fixed;
            top: var(--mobile-header-height);
            left: 0;
            width: min(84vw, 304px);
            height: calc(100dvh - var(--mobile-header-height));
            transform: translateX(-104%);
            transition: transform 0.28s ease;
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
            background: rgba(15, 23, 42, 0.38);
            backdrop-filter: blur(1px);
            z-index: 40;
            display: none;
        }

        #drawer_backdrop.show {
            display: block;
        }

        body.drawer-open {
            overflow: hidden;
            touch-action: none;
        }
    </style>

    {{-- MOBILE DRAWER --}}
    <aside id="mob_sidebar"
        class="fixed left-0 z-50 flex flex-col overflow-hidden rounded-r-2xl border-r border-slate-200 bg-white shadow-2xl">

        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50/90">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-emerald-500 font-semibold">Lanocard</p>
                    <p class="text-sm font-semibold text-slate-900">Navigation</p>
                </div>
                <button id="closeDrawerBtn" type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Close navigation drawer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1.5 text-sm bg-white">
            <a href="{{ route('dashboard') }}"
                @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
                , 'bg-emerald-50 text-emerald-700 border-emerald-100' => request()->routeIs('dashboard'),
                'text-slate-600 hover:bg-slate-100 hover:text-slate-900 border-transparent' => !request()->routeIs('dashboard'),
                ])>
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 5.25h16.5M3.75 9.75h7.5m-7.5 4.5h16.5M3.75 18.75h7.5" />
                    </svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('cards') }}"
                @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
                , 'bg-emerald-50 text-emerald-700 border-emerald-100' => request()->routeIs('cards'),
                'text-slate-600 hover:bg-slate-100 hover:text-slate-900 border-transparent' => !request()->routeIs('cards'),
                ])>
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </span>
                My Cards
            </a>

            <a href="{{ route('fundings') }}"
                @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
                , 'bg-emerald-50 text-emerald-700 border-emerald-100' => request()->routeIs('fundings'),
                'text-slate-600 hover:bg-slate-100 hover:text-slate-900 border-transparent' => !request()->routeIs('fundings'),
                ])>
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </span>
                Add Balance
            </a>

            <a href="{{ route('settings') }}"
                @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
                , 'bg-emerald-50 text-emerald-700 border-emerald-100' => request()->routeIs('settings'),
                'text-slate-600 hover:bg-slate-100 hover:text-slate-900 border-transparent' => !request()->routeIs('settings'),
                ])>
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                Settings
            </a>
        </nav>

        <div class="px-4 py-3 border-t border-slate-200 bg-slate-50 text-[11px] text-slate-500">
            <p class="font-medium text-slate-700 mb-0.5">Need help?</p>
            <p>Use live chat for card and payment support.</p>
        </div>
    </aside>


    <div id="drawer_backdrop"></div>

    <div class="z-[999] w-full">
        @include('layouts.app_header')
    </div>

    <div class="container_app w-full flex-1 min-h-0">

        {{-- Sidebar (20%) --}}
        <div id="sidebar_id" class="w-full h-full min-h-0 flex flex-col overflow-y-auto">
            @include('layouts.aside')
        </div>

        {{-- Main Content (80%) --}}

        <main class="h-full min-h-0 overflow-y-auto bg-gray-100 right_side">
            {{ $slot }}
        </main>
    </div>

    <script>
        const iconBtn = document.getElementById('icon_btn');
        const drawer = document.getElementById('mob_sidebar');
        const closeDrawerBtn = document.getElementById('closeDrawerBtn');
        const backdrop = document.getElementById('drawer_backdrop');
        const drawerLinks = drawer ? drawer.querySelectorAll('a') : [];

        const openDrawer = () => {
            drawer.classList.add('open');
            backdrop.classList.add('show');
            document.body.classList.add('drawer-open');
        };

        const closeDrawer = () => {
            drawer.classList.remove('open');
            backdrop.classList.remove('show');
            document.body.classList.remove('drawer-open');
        };

        iconBtn?.addEventListener('click', openDrawer);
        closeDrawerBtn?.addEventListener('click', closeDrawer);
        backdrop?.addEventListener('click', closeDrawer);

        drawerLinks.forEach((link) => {
            link.addEventListener('click', closeDrawer);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeDrawer();
            }
        });
    </script>

</body>

</html>