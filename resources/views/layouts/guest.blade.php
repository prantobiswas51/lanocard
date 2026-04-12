<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/fev.ico') }}">

    <title>{{ config('app.name', 'Lanocard') }}</title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y414B1LE4K"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-Y414B1LE4K');
    </script>
    <meta name="google-adsense-account" content="ca-pub-1076115507843658">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=ZiAPCuGL3IpX"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { 50: '#ecfdf5', 100: '#d1fae5', 500: '#10b981', 600: '#059669' }
          }
        }
      }
    }
    </script>
   
</head>

<body class=" text-gray-900">

    {{-- client design --}}
    @include('layouts.pub_nav')


    <div class="bg-gray-100">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-slate-800">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <svg class="w-full h-full" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <rect width="40" height="40" rx="8" fill="url(#lanocard-grad-footer)"></rect>
                            <path d="M10 10v20h16v-4H14V10H10z" fill="white"></path>
                            <circle cx="30" cy="10" r="2.5" fill="white" opacity="0.9"></circle>
                            <defs>
                                <linearGradient id="lanocard-grad-footer" x1="0" y1="0" x2="40" y2="0"
                                    gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#1e3a5f"></stop>
                                    <stop offset="1" stop-color="#22c55e"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="text-sm font-bold tracking-tight"><span class="text-[#1e3a5f]">Lano</span><span
                            class="text-[#22c55e]">Card</span></span>
                </div>
                <nav class="flex flex-wrap items-center justify-center gap-4 text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Home</a>
                    <a href="{{ route('virtual_card') }}" class="hover:text-emerald-600">Virtual Card</a>
                    <a href="{{ route('how_it_works') }}" class="hover:text-emerald-600">How it works</a>
                    <a href="{{ route('security') }}" class="hover:text-emerald-600">Security</a>
                    <a href="{{ route('pricing') }}" class="hover:text-emerald-600">Pricing</a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-600">FAQ</a>
                    <a href="{{ route('api_documentation') }}" class="hover:text-emerald-600">API Docs</a>
                    <a href="{{ route('privacy') }}" class="hover:text-emerald-600">Privacy</a>
                    <a href="{{ route('service_agreement') }}" class="hover:text-emerald-600">Terms</a>
                    <a href="{{ route('login') }}" class="hover:text-emerald-600">Log in</a>
                    <a href="{{ route('register') }}" class="hover:text-emerald-600">Sign up</a>
                    <a href="https://www.trustpilot.com/review/virtualcardglobal.com" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-slate-700 hover:border-emerald-300 hover:text-emerald-600 hover:bg-emerald-50 transition">
                        <svg class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                            </path>
                        </svg>
                        Reviews
                    </a>
                </nav>
            </div>
            <p class="mt-6 text-center text-xs text-slate-500">© LanoCard. Safer virtual cards worldwide. All rights
                reserved.</p>
        </div>
    </footer>

</body>

</html>