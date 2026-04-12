<style>
    .mobile-nav-open {
        transform: translateX(0);
    }

    .mobile-nav-closed {
        transform: translateX(100%);
    }

    @media (min-width: 768px) {
        .mobile-nav-panel {
            display: none !important;
        }
    }
</style>

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-slate-800">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                <svg class="w-full h-full" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <rect width="40" height="40" rx="8" fill="url(#lanocard-grad-header)"></rect>
                    <path d="M10 10v20h16v-4H14V10H10z" fill="white"></path>
                    <circle cx="30" cy="10" r="2.5" fill="white" opacity="0.9"></circle>
                    <defs>
                        <linearGradient id="lanocard-grad-header" x1="0" y1="0" x2="40" y2="0"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#1e3a5f"></stop>
                            <stop offset="1" stop-color="#22c55e"></stop>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <span class="text-sm font-bold tracking-tight"><span class="text-[#1e3a5f]">Lano</span><span
                    class="text-[#22c55e]">Card</span></span>
        </a>
        <nav class="hidden md:flex items-center gap-6 text-sm">
            <a href="{{ route('home') }}" class="text-emerald-600 font-medium">Home</a>
            <a href="{{ route('virtual_card') }}" class="text-slate-600 hover:text-emerald-600">Virtual Card</a>
            <a href="{{ route('how_it_works') }}" class="text-slate-600 hover:text-emerald-600">How it works</a>
            <a href="{{ route('security') }}" class="text-slate-600 hover:text-emerald-600">Security</a>
            <a href="{{ route('pricing') }}" class="text-slate-600 hover:text-emerald-600">Pricing</a>
            <a href="{{ route('faq') }}" class="text-slate-600 hover:text-emerald-600">FAQ</a>
            <a href="{{ route('api_documentation') }}" class="text-slate-600 hover:text-emerald-600">API Docs</a>
        </nav>
        <div class="hidden md:flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-1.5 text-sm font-medium text-slate-700 hover:text-emerald-600">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="px-3 py-1.5 text-sm font-medium text-slate-700 hover:text-emerald-600">Log in</a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-full bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-600 shadow-sm">Sign
                    up</a>
            @endauth
        </div>
        <button type="button" id="mobileMenuBtn"
            class="md:hidden p-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100"
            aria-label="Open menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div id="mobileNavOverlay"
        class="mobile-nav-panel fixed inset-0 z-50 bg-slate-900/20 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 md:hidden"
        aria-hidden="true"></div>

    <div id="mobileNavPanel"
        class="mobile-nav-panel mobile-nav-closed fixed top-0 right-0 z-50 w-72 max-w-[85vw] h-full bg-white border-l border-slate-200 shadow-xl transition-transform duration-200 ease-out md:hidden">
        <div class="flex items-center justify-between px-4 py-4 border-b border-slate-100">
            <span class="font-semibold text-slate-900">Menu</span>
            <button type="button" id="mobileMenuClose" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100"
                aria-label="Close menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="p-4 flex flex-col gap-1 text-sm">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-emerald-600 font-medium bg-emerald-50">Home</a>
            <a href="{{ route('virtual_card') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Virtual Card</a>
            <a href="{{ route('how_it_works') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">How it works</a>
            <a href="{{ route('security') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Security</a>
            <a href="{{ route('pricing') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">Pricing</a>
            <a href="{{ route('faq') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">FAQ</a>
            <a href="{{ route('api_documentation') }}" class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50">API Docs</a>
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50 text-center font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-lg px-3 py-2.5 text-slate-700 hover:bg-slate-50 text-center font-medium">Log in</a>
                    <a href="{{ route('register') }}"
                        class="rounded-full bg-emerald-500 text-white px-4 py-2.5 text-center font-semibold hover:bg-emerald-600">Sign up</a>
                @endauth
            </div>
        </nav>
    </div>
</header>

<script>
    (function() {
        var btn = document.getElementById('mobileMenuBtn');
        var closeBtn = document.getElementById('mobileMenuClose');
        var overlay = document.getElementById('mobileNavOverlay');
        var panel = document.getElementById('mobileNavPanel');

        function openNav() {
            if (overlay) {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                overlay.setAttribute('aria-hidden', 'false');
            }
            if (panel) {
                panel.classList.remove('mobile-nav-closed');
                panel.classList.add('mobile-nav-open');
            }
            document.body.style.overflow = 'hidden';
        }

        function closeNav() {
            if (overlay) {
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100');
                overlay.setAttribute('aria-hidden', 'true');
            }
            if (panel) {
                panel.classList.add('mobile-nav-closed');
                panel.classList.remove('mobile-nav-open');
            }
            document.body.style.overflow = '';
        }

        if (btn) btn.addEventListener('click', openNav);
        if (closeBtn) closeBtn.addEventListener('click', closeNav);
        if (overlay) overlay.addEventListener('click', closeNav);
    })();
</script>