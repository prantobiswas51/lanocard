<header
    class="fixed z-50 top-0 left-0 right-0 md:static w-full border-b border-slate-200 dark:border-slate-700  dark:bg-slate-800/80 backdrop-blur bg-white dark:md:bg-slate-800/80">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">

        {{-- left side --}}
        <div class="flex items-center gap-3">

            {{-- three dot on header --}}
            <button id="icon_btn"
                class="md:hidden p-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 bg-white dark:bg-slate-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- user panel txt --}}
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 dark:text-emerald-400 font-semibold">
                    User Panel</p>
                <h1 class="text-lg sm:text-xl font-semibold text-slate-900 dark:text-slate-100">Virtual Card
                    Dashboard</h1>
            </div>
        </div>

        {{-- right side --}}
        <div class="flex items-center gap-2 sm:gap-4">

            {{-- main balance --}}
            <div class="hidden sm:flex flex-col items-end">
                <span class="text-[11px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Main
                    Balance</span>
                <span id="mainBalance" class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">${{
                    number_format(Auth::user()->balance, 2) }}</span>
            </div>

            {{-- dark mode toggle --}}
            {{-- <button id="themeToggle" type="button" aria-label="Toggle dark mode"
                class="h-9 w-9 rounded-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                <span id="themeIconLight" class="hidden dark:block" title="Light mode">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1.5M12 20.25v1.5M4.22 4.22l1.06 1.06M18.72 18.72l1.06 1.06M3 12h1.5M19.5 12H21M4.22 19.78l1.06-1.06M18.72 5.28l1.06-1.06" />
                    </svg>
                </span>
                <span id="themeIconDark" class="block dark:hidden" title="Dark mode">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.502.2-2.957.574-4.322A9.716 9.716 0 003 10.5h1.5a8.25 8.25 0 008.25 8.25 8.25 8.25 0 008.002-5.498z" />
                    </svg>
                </span>
            </button> --}}

            {{-- notifications --}}
            <div class="relative z-[9999]">
                <button id="btnNotifications"
                    class="relative h-9 w-9 rounded-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    @if ($unreadNotificationsCount > 0)
                    <span id="notifBadge"
                        class="absolute -top-0.5 -right-0.5 h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center min-w-[1rem]">
                        {{ $unreadNotificationsCount ?? 0 }}
                    </span>
                    @endif

                </button>
                <div id="notificationPanel"
                    class="hidden fixed top-14 right-4 w-80 sm:w-96 rounded-xl border border-slate-200 bg-white shadow-xl z-[9999] overflow-hidden">
                    <div
                        class="px-4 py-3 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between bg-slate-50/80 dark:bg-slate-700/50">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Notifications </h3>

                    </div>
                    <div id="notificationList" class="max-h-80 overflow-y-auto">


                        @forelse ($notifications as $notification)
                        <div 
                            class=" flex gap-3 px-4 py-3 border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50/80 dark:hover:bg-slate-700/50 transition">
                            <span
                                class="flex-shrink-0 h-9 w-9 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-slate-900 dark:text-slate-200">{{
                                    $notification->message }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{
                                    $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <form class="text-emerald-600 text-[13px] hover:text-emerald-700"
                                action="{{ route('mark_as_read', $notification->id) }}" method="post">
                                @csrf
                                @method('POST')
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">

                                        <path d="M3 8l9 6 9-6"></path>
                                        <path d="M21 8v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8"></path>
                                        <path d="M3 8l9-6 9 6"></path>

                                    </svg>
                                </button>
                            </form>
                            @if (!$notification->is_read)
                            <span
                                class="notif-unread-dot flex-shrink-0 h-2 w-2 rounded-full bg-emerald-500 mt-1.5"></span>
                            @endif
                        </div>
                        @empty
                        <p
                            class="gap-3 px-4 py-3 border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50/80 dark:hover:bg-slate-700/50">
                            No Notifications</p>
                        @endforelse

                        <div class="px-4 py-2 text-center">
                            <a href="{{ route('notifications') }}"
                                class="text-[11px] font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">
                                View all notifications
                            </a>
                        </div>
                    </div>

                    <div
                        class="px-4 py-2 border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30 text-center">
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Card payment &amp; top‑up
                            alerts
                        </p>
                    </div>
                </div>
            </div>

            {{-- logout --}}
            <button id="btnLogout"
                class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-3 text-[11px] font-medium text-slate-600 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-slate-200 transition">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>

            {{-- user --}}
            <div
                class="h-9 w-9 rounded-full bg-gradient-to-br from-sky-400 via-emerald-400 to-violet-500 p-[1px] shadow flex-shrink-0">
                <div
                    class="h-full w-full rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-xs font-semibold text-slate-800 dark:text-slate-200">
                    U
                </div>
            </div>
        </div>
    </div>
</header>