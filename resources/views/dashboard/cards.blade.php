<x-app-layout>
    <style>
        /* Custom styles that can't be easily replaced with Tailwind */
        .card-3d {
            transform-style: preserve-3d;
        }

        .large-cloud {
            position: absolute;
            top: -20px;
            right: -30px;
            width: 120px;
            height: 80px;
            border-radius: 60px 60px 60px 60px / 40px 40px 40px 40px;
            opacity: 0.8;
        }

        .tap-text {
            background: linear-gradient(90deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <section class="flex-1 w-full">
        <div class="max-w-6xl grid lg:grid-cols-[1.6fr,1.2fr] mx-auto px-4 sm:px-6 space-y-5">



            <div class=" gap-5 items-start scroll-smooth mt-6">
                <!-- Left: search + filters + list -->

                <div class="flex flex-col  w-max sm:flex-row sm:items-center sm:justify-between gap-3 ">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 font-semibold">My cards</p>
                        <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Manage all your virtual cards</h2>
                        <p class="text-xs text-slate-500 max-w-xl">
                            View every one‑time and reloadable card in one place. Quickly search, filter, freeze or
                            top‑up
                            cards.
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 space-y-4 my-4 shadow-sm">


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

                    <div class="text-[11px] text-slate-500 flex items-center gap-2 justify-between">
                        <span id="cardsShowingCount">Showing {{ $mycards->count() }} cards</span>
                        <div class="gap-2 flex items-center">
                            <button
                                class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                                Sort by latest
                            </button>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 border border-emerald-200 text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active · {{
                                $mycards->where('state', 1)->count() }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 border border-amber-200 text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Frozen · {{
                                $mycards->where('state',
                                2)->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 max-h-[360px] overflow-y-auto pr-1">
                        <!-- Sample card rows (same style as dashboard list) -->

                        @forelse ($mycards as $card)
                        <div class="card-row group @if($card->state == 2) grayscale @endif rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-700/50 px-3 py-3 flex flex-col gap-2 cursor-pointer hover:border-emerald-300 dark:hover:border-emerald-600 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20"
                            data-cardNumber="{{ $card->number }}" data-expiry="{{ $card->expiryDate }}"
                            data-cvv="{{ $card->cvv }}" data-holder="{{ Auth::user()->name }}"
                            data-balance="{{ number_format($card->cardBalance,2) }}" data-type="{{ $card->type }}"
                            data-status="{{ $card->state }}" data-cardid="{{ $card->id }}"
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

                                    <div class="orga">
                                        <div
                                            class="h-12 w-16 flex items-center justify-center rounded-xl border border-slate-200
                                             dark:border-slate-600 bg-gradient-to-br from-emerald-50 via-white to-emerald-50
                                              dark:from-emerald-900/20 dark:via-slate-800 dark:to-emerald-900/20 shadow-sm">

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
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        @if ($card->state == 1)
                                        Active
                                        @elseif ($card->state == 2)
                                        Frozen
                                        @else
                                        Pending
                                        @endif
                                    </span>
                                    <span>Last top‑up · $(FLAG-4) (2d ago)</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-[11px]">

                                    @if ($card->state == 4)
                                    <div
                                        class="bg-yellow-600 text-white text-sm font-medium border border-yellow-600 px-3 py-1 rounded-lg flex items-center space-x-2 cursor-not-allowed">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4">
                                            </circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span>Processing</span>
                                    </div>
                                    @endif

                                    @if ($card->state != 4)
                                    <button type="button"
                                        class="btn-card-details inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-2.5 py-1 text-slate-700 hover:border-slate-400/80">
                                        Details
                                    </button>
                                    @endif


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


            </div>

            <div class="ml-3">
                <!-- Right: selected card summary -->
                {{-- Flag-3 --}}
                <div id="details_pan"
                    class="bg-white border-slate-200 rounded-2xl p-3 sm:p-4 flex gap-3 flex-col shadow-sm max-h-[calc(93vh-4rem)] overflow-y-auto overscroll-contain lg:sticky ">

                    {{-- header details --}}
                    <div class="space-y-0.5  flex justify-between rounded-lg p-2  items-center">
                        <div class="">
                            <p
                                class="text-[11px] uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400 font-semibold">
                                Selected card</p>
                            <h3 id="selectedCardTitle" class="text-sm font-semibold text-slate-900">
                                Reload · Online Shopping
                            </h3>
                        </div>
                        <span id="hideSelectedCard" class="p-2 text-md cursor-pointer rounded-md">X</span>
                    </div>

                    {{-- card design flag-8--}}
                        <div id="selectedCardBox" class="w-full max-w-[340px] mx-auto min-h-[200px] p-4 rounded-2xl relative overflow-hidden
                    bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900
                    shadow-xl text-white">

                        <!-- Frozen Overlay -->
                        <div
                            class="card-frozen-lock invisible opacity-0 pointer-events-none absolute inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm transition">
                            <div class="flex flex-col items-center gap-1">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="text-xs font-semibold uppercase tracking-widest">Locked</span>
                            </div>
                        </div>

                        <!-- Frozen Badge -->
                        <div
                            class="card-frozen-badge hidden absolute top-3 right-3 text-[10px] px-2 py-0.5 rounded-full bg-white/20 backdrop-blur">
                            FROZEN
                        </div>

                        <!-- Top -->
                        <div class="flex justify-between items-start">
                            <div class="virtualpay-chip w-10 h-7 bg-yellow-400 rounded-md"></div>
                            <span class="text-xs font-semibold tracking-wider uppercase text-white/80">Lanocard</span>
                        </div>

                        <!-- Card Number -->
                        <p id="selectedCardNumber" class="mt-6 font-mono text-lg tracking-[0.2em]">
                            4549 2416 3941 1859
                        </p>

                        <!-- Expiry + CVV -->
                        <div class="flex justify-between mt-3 text-sm text-white/80">
                            <span id="selectedCardExpiry">03/29</span>
                            <span id="selectedCardCvv">703</span>
                        </div>

                        <!-- Bottom -->
                        <div class="absolute bottom-3 left-4 right-4 flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-white/60">CARDHOLDER</p>
                                <p id="selectedCardHolder" class="text-sm font-medium truncate max-w-[10rem]">{{ Auth::user()->name }}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-[10px] text-white/60">BALANCE</p>
                                <div class="flex items-center gap-1 justify-end">
                                    <span id="selectedCardBalance"
                                        class="text-emerald-300 font-semibold text-sm">$0.35</span>

                                    <a id="selectedCardUpdateBalanceBtn" href="#"
                                        class="p-1 rounded-full hover:bg-white/10 transition" data-cardid="" aria-disabled="true">

                                        <svg id="selectedCardUpdateBalanceIcon" class="w-4 h-4" fill="none"
                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </a>
                                </div>
                                <span id="selectedCardUpdateBalanceFeedback" class="text-[10px] text-white/60"></span>
                            </div>
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


                            <form id="selectedCardFreezeForm"
                                class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[11px] text-slate-700 hover:border-amber-400/80 hover:text-amber-600"
                                action="{{ route('freeze_card') }}" method="post">
                                @csrf
                                <input id="selectedCardFreezeFormCardId" type="hidden" name="card_id" value="">
                                <button id="selectedCardFreezeButton" type="submit">Freeze</button>
                            </form>

                            {{-- flag-7 --}}
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

                    {{-- transactions FLAG-5 --}}
                    <div class="space-y-2 text-[11px] ">
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

    <div id="rechargeModal" class="fixed inset-0 bg-slate-900/50 hidden z-50 p-4">
        <div class="relative top-12 mx-auto p-5 border border-slate-200 w-full max-w-md shadow-xl rounded-2xl bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-slate-900">Top-up selected card</h3>
                <button id="closeRechargeModal" type="button"
                    class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none">
                    &times;
                </button>
            </div>

            <form id="rechargeForm" action="{{ route('card_recharge') }}" method="post" class="space-y-4">
                @csrf

                <div>
                    <label for="recharge_amount" class="block text-sm font-medium text-slate-700 mb-2">
                        Recharge amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                        <input type="number" name="amount" min="1" step="0.01" value="10" required id="recharge_amount"
                            class="w-full pl-8 pr-3 py-2 rounded-lg border border-slate-300 bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <p class="text-sm text-slate-700 mt-1">
                        <span class="text-emerald-600">Available: ${{ number_format(Auth::user()->balance ?? 0, 2)
                            }}</span>
                        | Total: <span class="text-rose-500" id="total_amount">$11.00 (Fee 10%)</span>
                    </p>
                </div>

                <input id="rechargeCardId" type="hidden" name="card_id" value="">

                <div class="flex space-x-3 pt-2">
                    <button type="button" id="cancelRechargeModal"
                        class="flex-1 px-4 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors shadow-sm">
                        Recharge
                    </button>
                </div>
            </form>
        </div>
    </div>

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
            const selectedCardUpdateBalanceBtn = document.getElementById('selectedCardUpdateBalanceBtn');
            const selectedCardUpdateBalanceIcon = document.getElementById('selectedCardUpdateBalanceIcon');
            const selectedCardUpdateBalanceFeedback = document.getElementById('selectedCardUpdateBalanceFeedback');
            const selectedCardFrozenLock = document.querySelector('#selectedCardBox .card-frozen-lock');
            const selectedCardFrozenBadge = document.querySelector('#selectedCardBox .card-frozen-badge');
            const selectedCardFreezeForm = document.getElementById('selectedCardFreezeForm');
            const selectedCardFreezeFormCardId = document.getElementById('selectedCardFreezeFormCardId');
            const selectedCardFreezeButton = document.getElementById('selectedCardFreezeButton');
            const btnTopupSelectedCard = document.getElementById('btnTopupSelectedCard');
            const detailsPanel = document.getElementById('details_pan');
            const searchInput = document.getElementById('cardSearchInput');
            const filterButtons = document.querySelectorAll('.mycards-filter');
            const showingCount = document.getElementById('cardsShowingCount');
            const cardRows = document.querySelectorAll('.card-row');
            const rechargeModal = document.getElementById('rechargeModal');
            const rechargeAmountInput = document.getElementById('recharge_amount');
            const rechargeTotalText = document.getElementById('total_amount');
            const rechargeCardIdInput = document.getElementById('rechargeCardId');
            const closeRechargeModalBtn = document.getElementById('closeRechargeModal');
            const cancelRechargeModalBtn = document.getElementById('cancelRechargeModal');
            const updateBalanceRouteTemplate = @json(route('update_balance', ['id' => '__CARD_ID__']));
            const freezeCardRoute = @json(route('freeze_card'));
            const unfreezeCardRoute = @json(route('unfreeze_card'));

            let activeTypeFilter = 'all';
            let selectedCardId = '';
            let isBalanceRefreshLoading = false;

            const closeRechargeModal = () => {
                if (!rechargeModal) return;
                rechargeModal.classList.add('hidden');
                rechargeModal.classList.remove('flex');
            };

            const updateRechargeTotal = () => {
                if (!rechargeAmountInput || !rechargeTotalText) return;

                const amount = Number.parseFloat(rechargeAmountInput.value || '0');
                const validAmount = Number.isFinite(amount) && amount > 0 ? amount : 0;
                const totalAmount = validAmount + (validAmount * 0.10);
                rechargeTotalText.innerText = `$${totalAmount.toFixed(2)} (Fee 10%)`;
            };

            const setBalanceRefreshFeedback = (message = '') => {
                if (selectedCardUpdateBalanceFeedback) {
                    selectedCardUpdateBalanceFeedback.innerText = message;
                }
            };

            const setBalanceRefreshLoading = (isLoading) => {
                isBalanceRefreshLoading = isLoading;

                if (selectedCardUpdateBalanceIcon) {
                    selectedCardUpdateBalanceIcon.classList.toggle('animate-spin', isLoading);
                    selectedCardUpdateBalanceIcon.classList.toggle('opacity-70', isLoading);
                }

                if (selectedCardUpdateBalanceBtn) {
                    selectedCardUpdateBalanceBtn.classList.toggle('pointer-events-none', isLoading);
                    selectedCardUpdateBalanceBtn.classList.toggle('opacity-60', isLoading);
                    selectedCardUpdateBalanceBtn.setAttribute('aria-busy', isLoading ? 'true' : 'false');
                    selectedCardUpdateBalanceBtn.setAttribute('title', isLoading ? '' : '');
                }
            };

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
                const statusNumber = Number.parseInt(status, 10);
                const cardId = cardRow.dataset.cardid || '';
                const totalconsume = cardRow.dataset.totalconsume || '0.00';
                selectedCardId = cardId;

                if (selectedNumber) selectedNumber.innerText = number;
                if (selectedBalance) selectedBalance.innerText = '$' + balance;
                if (selectedExpiry) selectedExpiry.innerText = expiry;
                if (selectedCvv) selectedCvv.innerText = cvv;
                if (selectedHolder) selectedHolder.innerText = holder;
                if (selectedSpent) selectedSpent.innerText = '$' + totalconsume;
                if (selectedTitle) selectedTitle.innerText = type.charAt(0).toUpperCase() + type.slice(1) + ' Card';

                if (selectedStatus) {
                    if (statusNumber === 1) {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active`;
                    } else if (statusNumber === 2) {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Frozen`;
                    } else {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Pending`;
                    }
                }

                if (selectedCardFrozenLock) {
                    const isFrozen = statusNumber === 2;
                    selectedCardFrozenLock.classList.toggle('invisible', !isFrozen);
                    selectedCardFrozenLock.classList.toggle('opacity-0', !isFrozen);
                    selectedCardFrozenLock.classList.toggle('pointer-events-none', !isFrozen);
                }

                if (selectedCardFrozenBadge) {
                    selectedCardFrozenBadge.classList.toggle('hidden', statusNumber !== 2);
                }

                if (selectedCardUpdateBalanceBtn) {
                    if (cardId) {
                        selectedCardUpdateBalanceBtn.href = updateBalanceRouteTemplate.replace('__CARD_ID__', cardId);
                        selectedCardUpdateBalanceBtn.setAttribute('aria-disabled', 'false');
                        selectedCardUpdateBalanceBtn.dataset.cardid = cardId;
                    } else {
                        selectedCardUpdateBalanceBtn.href = '#';
                        selectedCardUpdateBalanceBtn.setAttribute('aria-disabled', 'true');
                        selectedCardUpdateBalanceBtn.dataset.cardid = '';
                    }
                }

                setBalanceRefreshFeedback('');

                if (selectedCardFreezeForm) {
                    selectedCardFreezeForm.action = status == 2 ? unfreezeCardRoute : freezeCardRoute;
                }

                if (selectedCardFreezeButton) {
                    selectedCardFreezeButton.innerText = status == 2 ? 'Unfreeze' : 'Freeze';
                }

                if (selectedCardFreezeFormCardId) {
                    selectedCardFreezeFormCardId.value = cardId;
                }

                if (rechargeCardIdInput) {
                    rechargeCardIdInput.value = cardId;
                }

                if (btnTopupSelectedCard) {
                    const hasCard = Boolean(cardId);
                    btnTopupSelectedCard.classList.toggle('pointer-events-none', !hasCard);
                    btnTopupSelectedCard.classList.toggle('opacity-60', !hasCard);
                }
            };

            if (detailsPanel) {
                detailsPanel.classList.add('hidden');
            }

            selectedCardUpdateBalanceBtn?.addEventListener('click', async (event) => {
                event.preventDefault();

                const isDisabled = selectedCardUpdateBalanceBtn.getAttribute('aria-disabled') === 'true';
                if (isDisabled || isBalanceRefreshLoading || !selectedCardId) {
                    return;
                }

                setBalanceRefreshFeedback('');
                setBalanceRefreshLoading(true);

                try {
                    const refreshUrl = updateBalanceRouteTemplate.replace('__CARD_ID__', selectedCardId);
                    const response = await fetch(refreshUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    const data = await response.json();

                    if (!response.ok || !data?.success) {
                        throw new Error(data?.message || 'Failed to refresh card balance.');
                    }

                    const latestBalance = Number.parseFloat(data?.card?.cardBalance ?? 0);
                    const latestTotalConsume = Number.parseFloat(data?.card?.totalConsume ?? 0);
                    const formattedBalance = Number.isFinite(latestBalance) ? latestBalance.toFixed(2) : '0.00';
                    const formattedTotalConsume = Number.isFinite(latestTotalConsume) ? latestTotalConsume.toFixed(2) : '0.00';

                    if (selectedBalance) {
                        selectedBalance.innerText = `$${formattedBalance}`;
                    }

                    if (selectedSpent) {
                        selectedSpent.innerText = `$${formattedTotalConsume}`;
                    }

                    cardRows.forEach((row) => {
                        if ((row.dataset.cardid || '') === selectedCardId) {
                            row.dataset.balance = formattedBalance;
                            row.dataset.totalconsume = formattedTotalConsume;
                        }
                    });

                    setBalanceRefreshFeedback('Updated');
                } catch (error) {
                    setBalanceRefreshFeedback('Failed');
                    alert(error.message || 'Failed to refresh card balance.');
                } finally {
                    setBalanceRefreshLoading(false);
                    setTimeout(() => {
                        setBalanceRefreshFeedback('');
                    }, 2000);
                }
            });

            var hideSelectedCard = document.getElementById('hideSelectedCard');
            hideSelectedCard.addEventListener('click', () => {
                if (detailsPanel) {
                    detailsPanel.classList.add('hidden');
                }
            });

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

            btnTopupSelectedCard?.addEventListener('click', () => {
                if (!selectedCardId || !rechargeModal || !rechargeCardIdInput) {
                    alert('Select a card first.');
                    return;
                }

                rechargeCardIdInput.value = selectedCardId;
                updateRechargeTotal();
                rechargeModal.classList.remove('hidden');
                rechargeModal.classList.add('flex');
                rechargeAmountInput?.focus();
            });

            closeRechargeModalBtn?.addEventListener('click', closeRechargeModal);
            cancelRechargeModalBtn?.addEventListener('click', closeRechargeModal);

            rechargeModal?.addEventListener('click', (event) => {
                if (event.target === rechargeModal) {
                    closeRechargeModal();
                }
            });

            rechargeAmountInput?.addEventListener('input', updateRechargeTotal);

            updateActiveFilterStyles();
            applyCardFilters();
            updateRechargeTotal();

        });

        // Previous js
        function copyCard() {
            const cardNumber = document.getElementById('card_number').value;
            navigator.clipboard.writeText(cardNumber)
                .then(() => alert('Card number copied!'))
                .catch(err => alert('Failed to copy'));
        }

        // Cashout Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cashoutModal');
            const openButton = document.getElementById('openCashoutModal');
            const closeButton = document.getElementById('closeCashoutModal');
            const cancelButton = document.getElementById('cancelCashout');

            if (!modal || !openButton || !closeButton || !cancelButton) {
                return;
            }

            openButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            closeButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            cancelButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });

    </script>
</x-app-layout>