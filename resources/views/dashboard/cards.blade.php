<x-app-layout>

    <section class="flex-1 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 font-semibold">My cards</p>
                    <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Manage all your virtual cards</h2>
                    <p class="text-xs text-slate-500 max-w-xl">
                        View every one‑time and reloadable card in one place. Quickly search, filter, freeze or top‑up
                        cards.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2 text-[11px]">
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 border border-emerald-200 text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active · {{
                        $mycards->where('state', 1)->count() }}
                    </span>
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 border border-amber-200 text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Frozen · {{ $mycards->where('state',
                        2)->count() }}
                    </span>
                </div>
            </div>

            <div class="grid lg:grid-cols-[1.6fr,1.2fr] gap-5 items-start">
                <!-- Left: search + filters + list -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 space-y-4 shadow-sm">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="relative w-full sm:max-w-xs">
                            {{-- Search icon --}}
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 15.75 19.5 19.5M5.25 11.25a6 6 0 1112 0 6 6 0 01-12 0z" />
                                </svg>
                            </span>
                            <input id="cardSearchInput" type="text" placeholder="Search by card name, last 4 digits..."
                                class="w-full rounded-full border border-slate-200 bg-slate-50 pl-9 pr-3 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white" />
                        </div>

                        <div class="flex flex-wrap gap-2 text-[11px]">
                            <button data-filter="all"
                                class="mycards-filter px-3 py-1.5 rounded-full border border-emerald-300 bg-emerald-50 text-emerald-700 font-medium">
                                All cards
                            </button>
                            <button data-filter="onetime"
                                class="mycards-filter px-3 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700">
                                One‑time
                            </button>
                            <button data-filter="reloadable"
                                class="mycards-filter px-3 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700">
                                Reloadable
                            </button>
                        </div>
                    </div>

                    <div class="text-[11px] text-slate-500 flex items-center justify-between">
                        <span id="cardsShowingCount">Showing {{ $mycards->count() }} cards</span>
                        <button
                            class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                            Sort by latest
                        </button>
                    </div>

                    <div class="space-y-3 max-h-[360px] overflow-y-auto pr-1">
                        <!-- Sample card rows (same style as dashboard list) -->

                        @forelse ($mycards as $card)
                        <div class="card-row group @if($card->state == 2) grayscale @endif rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-700/50 px-3 py-3 flex flex-col gap-2 cursor-pointer hover:border-emerald-300 dark:hover:border-emerald-600 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20"
                            data-cardNumber="{{ $card->number }}" data-expiry="{{ $card->expiryDate }}"
                            data-cvv="{{ $card->cvv }}" data-holder="{{ Auth::user()->name }}"
                            data-balance="{{ number_format($card->cardBalance,2) }}" data-type="{{ $card->type }}"
                            data-status="{{ $card->state }}"
                            data-totalconsume="{{ number_format($card->totalConsume, 2) }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-9 w-14 rounded-lg bg-gradient-to-br from-sky-400 to-violet-400 flex items-center justify-center text-[10px] font-semibold text-white shadow-sm">
                                        {{ ucfirst($card->type) }}
                                    </div>
                                    <div class="space-y-0.5 ">
                                        <p class="text-xs font-semibold text-slate-900">{{ ucfirst($card->type) }} · {{
                                            $card->organization }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $card->hiddenNum }}</p>
                                    </div>
                                </div>
                                <div class="text-right text-sm flex items-center ">

                                    <div class="orga mr-2">
                                        <div
                                            class="h-12 w-16 flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-600 bg-gradient-to-br from-emerald-50 via-white to-emerald-50 dark:from-emerald-900/20 dark:via-slate-800 dark:to-emerald-900/20 shadow-sm">

                                            @if ($card->organization == "VISA")
                                            <img class="h-5 object-contain" src="{{ asset('images/visa-a.png') }}"
                                                alt="Visa">
                                            @elseif ($card->organization == "MASTERCARD")
                                            <img class="h-6 object-contain" src="{{ asset('images/mastercard.png') }}"
                                                alt="Mastercard">
                                            @else
                                            <img class="h-6 object-contain" src="{{ asset('images/mastercard-a.png') }}"
                                                alt="Card">
                                            @endif

                                        </div>
                                    </div>

                                    <div class="">
                                        <p class="font-semibold mr-1 text-emerald-700">${{
                                            number_format($card->cardBalance, 2) }}</p>
                                        <button
                                            class="inline-flex px-2 text-xs rounded-full border border-emerald-300 bg-emerald-50 p-1 text-emerald-700 hover:bg-emerald-100">
                                            Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                    <span>Last top‑up · $100 (2d ago)</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-[11px]">
                                    
                                    <button type="button"
                                        class="btn-card-details inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-slate-700 hover:border-slate-400/80">
                                        Details
                                    </button>

                                </div>
                            </div>
                        </div>
                        @empty
                        <div id="cardListEmptyState"
                            class="rounded-2xl border border-dashed border-slate-200 dark:border-slate-600 bg-slate-50/80 dark:bg-slate-800/70 px-5 py-7 flex flex-col items-center justify-center text-center gap-3">
                            <div
                                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-900/40 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8.25A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25v7.5A2.25 2.25 0 0118.75 18H5.25A2.25 2.25 0 013 15.75v-7.5z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.25h6M7 14.25h3.5">
                                    </path>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">You don’t have any
                                    virtual cards yet</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 max-w-xs mx-auto">
                                    Create your first one‑time or reloadable card to start making secure online
                                    payments. Your cards will appear here in a simple list.
                                </p>
                            </div>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">
                                Tip: You can close cards anytime, and only active cards can be charged.
                            </p>
                        </div>
                        @endforelse

                    </div>
                </div>

                <!-- Right: selected card summary -->
                {{-- Flag-3 --}}
                <div id="details_pan"
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 sm:p-4 space-y-3 shadow-sm">
                    <div>
                        <p
                            class="text-[11px] uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400 font-semibold">
                            Selected card</p>
                        <h3 id="selectedCardTitle" class="text-sm font-semibold text-slate-900">
                            Reload · Online Shopping
                        </h3>
                    </div>

                    <div id="selectedCardBox"
                        class="virtualpay-card px-3.5 py-3.5 space-y-2.5 relative overflow-hidden">
                        <div class="card-frozen-lock">
                            <span class="flex flex-col items-center gap-1 rounded-full bg-slate-600/95 p-3 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span
                                    class="text-[10px] font-semibold text-white uppercase tracking-wider">Locked</span>
                            </span>
                        </div>
                        <div
                            class="card-frozen-badge h-6 min-w-[4.5rem] rounded px-1.5 flex items-center justify-center gap-1 text-[8px] font-bold text-white bg-slate-600/95 absolute top-2.5 right-2.5">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            FROZEN
                        </div>
                        <div class="flex items-start justify-between gap-2">
                            <div class="virtualpay-chip flex-shrink-0"></div>
                            <span class="text-[10px] font-bold tracking-wide text-white uppercase">Entrocard</span>
                        </div>
                        <p id="selectedCardNumber" class="font-mono text-white text-xs sm:text-sm tracking-[0.15em]">
                            •••• •••• •••• ••••
                        </p>
                        <div class="flex items-center justify-between text-[12px] text-white/80">
                            <span id="selectedCardExpiry" class="font-medium text-white/90">••/••</span>
                            <span id="selectedCardCvv" class="font-medium text-white/90">•••</span>
                        </div>
                        <div class="flex items-center justify-between text-[12px] text-white/80">
                            <span>Cardholder: <span class="font-medium text-white/90">{{ Auth::user()->name
                                    }}</span></span>
                            <span class="flex items-center gap-1">
                                Balance: <span id="selectedCardBalance"
                                    class="font-semibold text-[15px] text-emerald-300">$0.00</span>

                                {{-- refresh btn --}}
                                <button type="button" id="btnRefreshSelectedBalance"
                                    class="p-0.5 rounded text-white/70 hover:text-white hover:bg-white/10 transition"
                                    title="Refresh balance">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="flex items-end justify-between pt-1 border-t border-white/10">
                            <span class="text-[9px] font-semibold tracking-wider text-white/90">VIRTUALPAY</span>
                            <span class="text-[9px] font-medium tracking-wider text-white/70">VIRTUAL</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 space-y-1">
                            <p class="text-[11px] font-medium text-slate-600">Status</p>
                            <p id="selectedCardStatus"
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 border border-emerald-200 text-[11px] text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                            </p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 space-y-1">
                            <p class="text-[11px] font-medium text-slate-600 dark:text-slate-400">Total spent</p>
                            <p id="selectedCardSpent" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                $0.00 </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">With this card</p>
                        </div>
                    </div>

                    <!-- Billing address for the selected card (demo) -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-3 space-y-1 text-[11px]">
                        <p class="font-medium text-slate-700 dark:text-slate-300">Billing address</p>
                        <p class="text-slate-700 dark:text-slate-200 leading-relaxed">
                            2148 Market Street, Apt 5B<br>
                            San Francisco, CA 94114<br>
                            United States
                        </p>
                        <p class="text-[10px] text-slate-400 mt-1">
                            Use this address when a merchant asks for the card billing address.
                        </p>
                    </div>

                    <div class="space-y-2 text-[11px]">
                        <p class="font-medium text-slate-700">Quick actions</p>
                        <div class="flex flex-wrap gap-2">
                            <button id="btnFreezeSelectedCard"
                                class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[11px] text-slate-700 hover:border-amber-400/80 hover:text-amber-600">
                                Freeze card
                            </button>
                            <button id="btnTopupSelectedCard"
                                class="inline-flex items-center gap-1 rounded-full border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-[11px] text-emerald-700 hover:bg-emerald-100">
                                Top‑up from balance <span class="text-[10px] opacity-80">(10% fee)</span>
                            </button>
                            <button id="btnCashoutSelectedCard"
                                class="inline-flex items-center gap-1 rounded-full border border-sky-300 bg-sky-50 px-3 py-1.5 text-[11px] text-sky-700 hover:bg-sky-100">
                                Cash out balance
                            </button>
                        </div>
                    </div>

                    {{-- transactions --}}
                    <div class="space-y-2 text-[11px]">
                        <p class="font-medium text-slate-700 dark:text-slate-300">Recent activity (demo)</p>
                        <div id="selectedCardRecentActivity"
                            class="space-y-1.5 max-h-64 overflow-y-auto pr-1 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30 px-3 py-2">
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Amazon marketplace</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $45.20</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>02 Mar · Online purchase</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Top‑up from main balance</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">+ $100.00</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>28 Feb · Manual top‑up</span>
                                    <span>Completed</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Netflix subscription</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $12.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>01 Mar · Recurring</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Spotify</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $9.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>01 Mar · Subscription</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Top‑up from main balance</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">+ $50.00</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>27 Feb · Manual top‑up</span>
                                    <span>Completed</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Google Play</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $4.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>26 Feb · Online purchase</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Uber</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $18.40</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>25 Feb · Transport</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Steam</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $29.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>24 Feb · Online purchase</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Top‑up from main balance</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">+ $80.00</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>23 Feb · Manual top‑up</span>
                                    <span>Completed</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Adobe Creative Cloud</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $54.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>22 Feb · Subscription</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Microsoft 365</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $6.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>21 Feb · Subscription</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Apple iCloud</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $2.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>20 Feb · Storage</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">YouTube Premium</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $11.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>19 Feb · Subscription</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                            <div
                                class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Top‑up from main balance</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">+ $200.00</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>18 Feb · Manual top‑up</span>
                                    <span>Completed</span>
                                </div>
                            </div>
                            <div class="recent-activity-item flex flex-col gap-0.5 py-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-slate-700 dark:text-slate-300">Dropbox Plus</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">- $9.99</span>
                                </div>
                                <div
                                    class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                    <span>17 Feb · Subscription</span>
                                    <span>Approved</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const selectedNumber = document.getElementById('selectedCardNumber');
            const selectedBalance = document.getElementById('selectedCardBalance');
            const selectedExpiry = document.getElementById('selectedCardExpiry');
            const selectedCvv = document.getElementById('selectedCardCvv');
            const selectedHolder = document.getElementById('selectedCardHolder');
            const selectedSpent = document.getElementById('selectedCardSpent');
            const selectedTitle = document.getElementById('selectedCardTitle');
            const selectedStatus = document.getElementById('selectedCardStatus');
            const detailsPanel = document.getElementById('details_pan');
            const searchInput = document.getElementById('cardSearchInput');
            const filterButtons = document.querySelectorAll('.mycards-filter');
            const showingCount = document.getElementById('cardsShowingCount');
            const cardRows = document.querySelectorAll('.card-row');

            let activeTypeFilter = 'all';

            const normalizeType = (value) => {
                return String(value || '').toLowerCase().replace(/[^a-z0-9]/g, '');
            };

            const updateActiveFilterStyles = () => {
                filterButtons.forEach((button) => {
                    const isActive = button.dataset.filter === activeTypeFilter;

                    button.classList.toggle('border-emerald-300', isActive);
                    button.classList.toggle('bg-emerald-50', isActive);
                    button.classList.toggle('text-emerald-700', isActive);
                    button.classList.toggle('font-medium', isActive);

                    button.classList.toggle('border-slate-200', !isActive);
                    button.classList.toggle('bg-white', !isActive);
                    button.classList.toggle('text-slate-600', !isActive);
                });
            };

            const applyCardFilters = () => {
                const query = (searchInput?.value || '').toLowerCase().trim();
                let visibleCount = 0;

                cardRows.forEach((card) => {
                    const cardType = normalizeType(card.dataset.type);
                    const cardText = card.textContent.toLowerCase();
                    const matchesType = activeTypeFilter === 'all' || cardType === activeTypeFilter;
                    const matchesSearch = query === '' || cardText.includes(query);
                    const isVisible = matchesType && matchesSearch;

                    card.classList.toggle('hidden', !isVisible);

                    if (isVisible) {
                        visibleCount++;
                    }
                });

                if (showingCount) {
                    showingCount.textContent = `Showing ${visibleCount} cards`;
                }
            };

            filterButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    activeTypeFilter = button.dataset.filter || 'all';
                    updateActiveFilterStyles();
                    applyCardFilters();
                });
            });

            searchInput?.addEventListener('input', applyCardFilters);

            const updateSelectedCardFromRow = (cardRow) => {
                if (!cardRow) return;

                const number = cardRow.dataset.cardnumber || '•••• •••• •••• 0000';
                const expiry = cardRow.dataset.expiry || '--/--';
                const cvv = cardRow.dataset.cvv || '000';
                const holder = cardRow.dataset.holder || 'USER';
                const balance = cardRow.dataset.balance || '0.00';
                const type = cardRow.dataset.type || 'Card';
                const status = cardRow.dataset.status || '0';
                const totalconsume = cardRow.dataset.totalconsume || '0.00';

                if (selectedNumber) selectedNumber.innerText = number;
                if (selectedBalance) selectedBalance.innerText = '$' + balance;
                if (selectedExpiry) selectedExpiry.innerText = expiry;
                if (selectedCvv) selectedCvv.innerText = cvv;
                if (selectedHolder) selectedHolder.innerText = holder;
                if (selectedSpent) selectedSpent.innerText = '$' + totalconsume;
                if (selectedTitle) selectedTitle.innerText = type.charAt(0).toUpperCase() + type.slice(1) + ' Card';

                if (selectedStatus) {
                    selectedStatus.innerHTML = status == 1
                        ? `<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active`
                        : `<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Frozen`;
                }
            };

            if (detailsPanel) {
                detailsPanel.classList.add('hidden');
            }

            cardRows.forEach((card) => {
                card.addEventListener('click', () => {
                    updateSelectedCardFromRow(card);
                });

                const detailsButton = card.querySelector('.btn-card-details');
                detailsButton?.addEventListener('click', (event) => {
                    event.stopPropagation();
                    updateSelectedCardFromRow(card);

                    if (detailsPanel) {
                        detailsPanel.classList.remove('hidden');
                        detailsPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            updateActiveFilterStyles();
            applyCardFilters();

        });
    </script>
</x-app-layout>