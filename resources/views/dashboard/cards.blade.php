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

    {{-- topup modal flag-9 --}}
    <div id="topupModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/10 dark:bg-slate-900/50 backdrop-blur p-4">
        <div
            class="w-full max-w-sm rounded-2xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-5 py-5 space-y-4 shadow-xl">
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Top-up from balance</h3>
                <button id="closeTopupModal" type="button"
                    class="h-7 w-7 rounded-full border border-slate-200 dark:border-slate-600 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center justify-center text-xs">✕</button>
            </div>

            <p class="text-[11px] text-slate-500 dark:text-slate-300">
                10% fee applies. The fee is deducted from your main balance along with the top-up amount.
            </p>

            <form id="rechargeForm" action="{{ route('card_recharge') }}" method="post" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="topupAmountInput" class="text-xs font-medium text-slate-800 dark:text-slate-200">Amount
                        to add to card (USD)</label>
                    <input id="topupAmountInput" type="number" name="amount" min="1" step="1" placeholder="e.g. 100"
                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white dark:focus:bg-slate-700"
                        required>
                </div>

                <div
                    class="rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2.5 text-xs space-y-1.5">
                    <div class="flex justify-between text-slate-600 dark:text-slate-300"><span>Amount to
                            card</span><span id="topupToCard"
                            class="font-medium text-slate-900 dark:text-slate-100">$0.00</span></div>
                    <div class="flex justify-between text-slate-600 dark:text-slate-300"><span>Fee (10%)</span><span
                            id="topupFee" class="font-medium text-amber-600">$0.00</span></div>
                    <div
                        class="flex justify-between text-slate-700 dark:text-slate-200 pt-1 border-t border-slate-200 dark:border-slate-600">
                        <span>Total from balance</span><span id="topupTotal"
                            class="font-semibold text-slate-900 dark:text-slate-100">$0.00</span>
                    </div>
                </div>

                <input id="rechargeCardId" type="hidden" name="card_id" value="">

                <button id="confirmTopup" type="submit"
                    class="w-full rounded-lg bg-emerald-500 py-2.5 text-xs font-semibold text-white hover:bg-emerald-600">
                    Confirm top-up
                </button>
            </form>
        </div>
    </div>


    {{-- Flag-10 --}}
    <div id="cashoutModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-900/10 dark:bg-slate-900/50 backdrop-blur p-4">
        <div
            class="w-full max-w-sm rounded-2xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-5 py-5 space-y-4 shadow-xl">
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Cash out to balance</h3>
                <button id="closeCashoutModal" type="button"
                    class="h-7 w-7 rounded-full border border-slate-200 dark:border-slate-600 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center justify-center text-xs">✕</button>
            </div>

            <p class="text-[11px] text-slate-500 dark:text-slate-300">
                The selected amount will be moved from this card balance to your main balance.
            </p>

            <form id="cashoutForm" action="{{ route('card_cashout') }}" method="post" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="cashout_amount" class="text-xs font-medium text-slate-800 dark:text-slate-200">Amount to
                        cash out (USD)</label>
                    <input id="cashout_amount" type="number" name="amount" min="0.01" step="0.01" placeholder="e.g. 100"
                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-sky-500 focus:bg-white dark:focus:bg-slate-700"
                        required>
                </div>

                <div
                    class="rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2.5 text-xs space-y-1.5">
                    <div class="flex justify-between text-slate-600 dark:text-slate-300"><span>Card balance</span><span
                            id="cashout_card_balance"
                            class="font-medium text-slate-900 dark:text-slate-100">$0.00</span></div>
                    <div
                        class="flex justify-between text-slate-700 dark:text-slate-200 pt-1 border-t border-slate-200 dark:border-slate-600">
                        <span>You receive</span><span id="cashout_total_amount"
                            class="font-semibold text-emerald-600">$0.00</span>
                    </div>
                </div>

                <input id="cashoutCardId" type="hidden" name="card_id" value="">

                <button type="submit"
                    class="w-full rounded-lg bg-sky-600 py-2.5 text-xs font-semibold text-white hover:bg-sky-700">
                    Confirm cash out
                </button>
            </form>
        </div>
    </div>

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
                            data-totalconsume="{{ number_format($card->totalConsume, 2) }}"
                            data-organization="{{ $card->organization }}">
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
                    class="bg-white border-slate-200 rounded-2xl p-3 sm:p-4 flex gap-3 flex-col shadow-sm max-h-[calc(93vh-4rem)] min-h-[calc(90vh-4rem)] overflow-y-auto overscroll-contain lg:sticky ">

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
                    <div id="selectedCardBox"
                        class="w-full min-h-[200px] max-w-full mx-auto relative overflow-hidden rounded-[20px] border border-white/10 shadow-md text-white bg-slate-900">

                        <div id="selectedCardBoxContent" class="absolute inset-0 z-10">
                            <div id="selectedCardGradientLayer"
                                class="absolute inset-0 bg-[linear-gradient(90deg,#000_0%,#111_40%,#1a1a1c_70%,#141416_100%)]">
                            </div>
                            <div
                                class="absolute inset-0 opacity-[0.08] bg-[repeating-linear-gradient(90deg,transparent_0px,transparent_28px,rgba(255,255,255,0.08)_60px,transparent_100px)]">
                            </div>

                            <div class="absolute right-[-92px] top-[18%] w-[260px] h-[260px] opacity-[0.06]">
                                <div class="w-full h-full border-[34px] border-white rounded-[40px] rotate-45"></div>
                            </div>

                            <div class="relative z-10 h-full px-3.5 py-3">
                                <!-- Top -->
                                <div class="flex items-start justify-between ">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-white/75">
                                        Virtual Card</p>
                                </div>

                                <!-- Balance -->
                                <div class="mt-1.5 flex items-center justify-between">
                                    <div class="">
                                        <p class="text-[8px] uppercase tracking-[0.18em] text-white/60">Balance</p>
                                        <div class="mt-1 flex items-center gap-1">
                                            <span id="selectedCardBalance"
                                                class="text-lg font-semibold tabular-nums text-white">$0.35</span>
                                            <a id="selectedCardUpdateBalanceBtn" href="#"
                                                class="hidden p-0.5 rounded-full hover:bg-white/10 transition"
                                                data-cardid="" aria-disabled="true">
                                                <svg id="selectedCardUpdateBalanceIcon" class="w-3.5 h-3.5" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </a>
                                        </div>
                                        <span id="selectedCardUpdateBalanceFeedback" class="hidden"></span>
                                    </div>
                                    <div class="h-8 w-8">
                                        <svg class="w-full h-full" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <rect width="40" height="40" rx="8" fill="url(#lanocard-grad-header)">
                                            </rect>
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
                                </div>

                                <!-- Chip -->
                                <div
                                    class="virtualpay-chip mt-2 w-[44px] h-[33px] rounded-md bg-gradient-to-br from-zinc-200 via-zinc-300 to-zinc-400 border border-zinc-500/90 p-1">
                                    <div
                                        class="w-full h-full rounded-[5px] border border-zinc-500/70 flex items-center justify-center">
                                        <span class="block h-[1px] w-full bg-zinc-500/60"></span>
                                    </div>
                                </div>

                                <!-- Card Number -->
                                <p id="selectedCardNumber"
                                    class="mt-2.5 text-[15px] tracking-[0.16em] font-medium tabular-nums">
                                    4549 2416 3941 1859
                                </p>

                                <!-- Bottom -->
                                <div class="mt-2.5 flex items-end justify-between gap-2">

                                    <div class="grid grid-cols-3 gap-2 text-[8px] uppercase tracking-[0.11em]">

                                        <!-- Card Holder -->
                                        <div class="pr-4 border-r border-gray-100">
                                            <p class="text-white/55">Card Holder</p>
                                            <p id="selectedCardHolder"
                                                class="mt-0.5 text-[10px] font-medium tracking-[0.09em] text-white/90 max-w-[6rem] truncate">
                                                {{ Auth::user()->name }}
                                            </p>
                                        </div>

                                        <!-- Expiry -->
                                        <div class="border-r border-gray-100 ">
                                            <p class="text-white/55">Expiry</p>
                                            <p id="selectedCardExpiry"
                                                class="mt-0.5 text-[11px] font-medium tracking-[0.08em] text-white/90">
                                                03/29
                                            </p>
                                        </div>

                                        <!-- CVV -->
                                        <div>
                                            <p class="text-white/55">CVV</p>
                                            <p id="selectedCardCvv"
                                                class="mt-0.5 text-[11px] font-medium tracking-[0.08em] text-white/90">
                                                703
                                            </p>
                                        </div>

                                    </div>

                                    <div class="shrink-0 flex opacity-90">
                                        <div class="w-6 h-6 bg-white/90 rounded-full"></div>
                                        <div class="w-6 h-6 bg-white/70 rounded-full -ml-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Frozen overlay lock icon (state = 2) --}}
                        <div class="card-frozen-lock pointer-events-none absolute inset-0 flex items-center justify-center transition-opacity duration-200"
                            style="z-index: 9999;">
                            <div class="rounded-full bg-slate-900/50 border border-white/20 backdrop-blur-sm px-3 py-2">
                                <svg class="w-7 h-7 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M17 11V7a5 5 0 0 0-10 0v4" />
                                    <rect x="5" y="11" width="14" height="10" rx="2" ry="2" />
                                </svg>
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


                    <div class="space-y-2 text-[11px]">
                        <p class="font-medium text-slate-700">Quick actions</p>
                        <div class="flex flex-wrap gap-2">


                            <form id="selectedCardFreezeForm"
                                class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[11px] text-slate-700 hover:border-amber-400/80 hover:text-amber-600"
                                action="{{ route('freeze_card') }}" method="post">
                                @csrf
                                <input id="selectedCardFreezeFormCardId" type="hidden" name="card_id" value="">
                                <button id="selectedCardFreezeButton" type="submit"
                                    class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.9" aria-hidden="true" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 2v20" />
                                        <path d="M4.93 4.93 19.07 19.07" />
                                        <path d="M2 12h20" />
                                        <path d="M4.93 19.07 19.07 4.93" />
                                    </svg>
                                    <span id="selectedCardFreezeLabel">FREEZE</span>
                                </button>
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
                        <p class="font-medium text-slate-700 flex justify-between dark:text-slate-300">Recent activity
                            <span>
                                <a href="{{ route('transactions') }}"
                                    class="text-[11px] text-emerald-600 hover:text-emerald-700 border-gray-300 hover:border-emerald-300 rounded-full border px-2 py-1">
                                    View all
                                </a>
                            </span>
                        </p>

                        <div id="selectedCardRecentActivity"
                            class="space-y-1.5 max-h-64 overflow-y-auto pr-1 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30 px-3 py-2">
                            <div class="py-4 text-center text-slate-500 text-[11px]">
                                Select a card to see its last 5 transactions.
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
            const selectedCardBox = document.getElementById('selectedCardBox');
            const selectedCardGradientLayer = document.getElementById('selectedCardGradientLayer');
            const selectedCardBoxContent = document.getElementById('selectedCardBoxContent');
            const selectedCardUpdateBalanceBtn = document.getElementById('selectedCardUpdateBalanceBtn');
            const selectedCardUpdateBalanceIcon = document.getElementById('selectedCardUpdateBalanceIcon');
            const selectedCardUpdateBalanceFeedback = document.getElementById('selectedCardUpdateBalanceFeedback');
            const selectedCardFrozenLock = document.querySelector('#selectedCardBox .card-frozen-lock');
            const selectedCardFrozenBadge = document.querySelector('#selectedCardBox .card-frozen-badge');
            const selectedCardFreezeForm = document.getElementById('selectedCardFreezeForm');
            const selectedCardFreezeFormCardId = document.getElementById('selectedCardFreezeFormCardId');
            const selectedCardFreezeButton = document.getElementById('selectedCardFreezeButton');
            const selectedCardFreezeLabel = document.getElementById('selectedCardFreezeLabel');
            const btnTopupSelectedCard = document.getElementById('btnTopupSelectedCard');
            const selectedCardRecentActivity = document.getElementById('selectedCardRecentActivity');
            const detailsPanel = document.getElementById('details_pan');
            const searchInput = document.getElementById('cardSearchInput');
            const filterButtons = document.querySelectorAll('.mycards-filter');
            const showingCount = document.getElementById('cardsShowingCount');
            const cardRows = document.querySelectorAll('.card-row');
            const rechargeModal = document.getElementById('topupModal');
            const rechargeAmountInput = document.getElementById('topupAmountInput');
            const topupToCardText = document.getElementById('topupToCard');
            const topupFeeText = document.getElementById('topupFee');
            const topupTotalText = document.getElementById('topupTotal');
            const rechargeCardIdInput = document.getElementById('rechargeCardId');
            const closeRechargeModalBtn = document.getElementById('closeTopupModal');
            const cancelRechargeModalBtn = null;
            const btnCashoutSelectedCard = document.getElementById('btnCashoutSelectedCard');
            const cashoutModal = document.getElementById('cashoutModal');
            const cashoutAmountInput = document.getElementById('cashout_amount');
            const cashoutTotalText = document.getElementById('cashout_total_amount');
            const cashoutCardBalanceText = document.getElementById('cashout_card_balance');
            const cashoutCardIdInput = document.getElementById('cashoutCardId');
            const closeCashoutModalBtn = document.getElementById('closeCashoutModal');
            const cancelCashoutModalBtn = document.getElementById('cancelCashoutModal');
            const updateBalanceRouteTemplate = @json(route('update_balance', ['id' => '__CARD_ID__']));
            const getTransactionsRoute = @json(route('get_transactions'));
            const freezeCardRoute = @json(route('freeze_card'));
            const unfreezeCardRoute = @json(route('unfreeze_card'));

            let activeTypeFilter = 'all';
            let selectedCardId = '';
            let isBalanceRefreshLoading = false;
            let latestTransactionsRequestId = 0;

            const closeRechargeModal = () => {
                if (!rechargeModal) return;
                rechargeModal.classList.add('hidden');
                rechargeModal.classList.remove('flex');
            };

            const closeCashoutModal = () => {
                if (!cashoutModal) return;
                cashoutModal.classList.add('hidden');
                cashoutModal.classList.remove('flex');
            };

            const updateRechargeTotal = () => {
                if (!rechargeAmountInput || !topupToCardText || !topupFeeText || !topupTotalText) return;

                const amount = Number.parseFloat(rechargeAmountInput.value || '0');
                const validAmount = Number.isFinite(amount) && amount > 0 ? amount : 0;
                const feeAmount = validAmount * 0.10;
                const totalAmount = validAmount + feeAmount;

                topupToCardText.innerText = `$${validAmount.toFixed(2)}`;
                topupFeeText.innerText = `$${feeAmount.toFixed(2)}`;
                topupTotalText.innerText = `$${totalAmount.toFixed(2)}`;
            };

            const updateCashoutTotal = () => {
                if (!cashoutAmountInput || !cashoutTotalText) return;

                const amount = Number.parseFloat(cashoutAmountInput.value || '0');
                const validAmount = Number.isFinite(amount) && amount > 0 ? amount : 0;
                cashoutTotalText.innerText = `$${validAmount.toFixed(2)}`;
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

            const applySelectedCardTheme = (organization) => {
                if (!selectedCardBox || !selectedCardGradientLayer) return;

                const org = String(organization || '').toUpperCase();

                if (org === 'MASTERCARD') {
                    selectedCardBox.style.background = 'linear-gradient(135deg, #000000 0%, #111111 45%, #1a1a1c 100%)';
                    selectedCardGradientLayer.style.background = 'linear-gradient(90deg, #000 0%, #111 40%, #1a1a1c 70%, #141416 100%)';
                    return;
                }

                if (org === 'VISA') {
                    selectedCardBox.style.background = 'linear-gradient(135deg, #065f46 0%, #059669 52%, #34d399 100%)';
                    selectedCardGradientLayer.style.background = 'linear-gradient(90deg, rgba(2, 44, 34, 0.52) 0%, rgba(5, 150, 105, 0.24) 46%, rgba(52, 211, 153, 0.18) 100%)';
                    return;
                }

                selectedCardBox.style.background = 'linear-gradient(135deg, #0f172a 0%, #111827 60%, #1e293b 100%)';
                selectedCardGradientLayer.style.background = 'linear-gradient(90deg, #000 0%, #111 40%, #1a1a1c 70%, #141416 100%)';
            };

            const escapeHtml = (value = '') => {
                return String(value)
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            };

            const formatTransactionDate = (recordTime) => {
                if (!recordTime) return 'Unknown date';

                const parsedNumber = Number.parseInt(String(recordTime), 10);
                let date = null;

                if (Number.isFinite(parsedNumber) && String(parsedNumber).length >= 12) {
                    date = new Date(parsedNumber);
                } else {
                    date = new Date(recordTime);
                }

                if (Number.isNaN(date.getTime())) {
                    return 'Unknown date';
                }

                return date.toLocaleString(undefined, {
                    day: '2-digit',
                    month: 'short',
                    hour: '2-digit',
                    minute: '2-digit',
                });
            };

            const renderSelectedCardTransactions = (transactions = []) => {
                if (!selectedCardRecentActivity) return;

                if (!transactions.length) {
                    selectedCardRecentActivity.innerHTML = `
                        <div class="py-4 text-center text-slate-500 text-[11px]">
                            No transactions found for this card.
                        </div>
                    `;
                    return;
                }

                selectedCardRecentActivity.innerHTML = transactions.map((transaction) => {
                    const amountNumber = Number.parseFloat(transaction.amount ?? 0);
                    const amount = Number.isFinite(amountNumber) ? amountNumber : 0;
                    const isCredit = ['topup', 'recharge', 'refund'].includes(String(transaction.type || '').toLowerCase());
                    const amountPrefix = isCredit ? '+ ' : '- ';
                    const amountClass = isCredit
                        ? 'font-semibold text-emerald-700 dark:text-emerald-400'
                        : 'font-semibold text-slate-900 dark:text-slate-100';

                    const merchant = transaction.merchantName || 'Unknown merchant';
                    const type = transaction.type || 'Transaction';
                    const status = transaction.status || 'Unknown';
                    const dateText = formatTransactionDate(transaction.recordTime);

                    return `
                        <div class="recent-activity-item flex flex-col gap-0.5 py-2 border-b border-slate-200/80 dark:border-slate-600/80 last:border-0">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-slate-700 dark:text-slate-300">${escapeHtml(merchant)}</span>
                                <span class="${amountClass}">${amountPrefix}$${Math.abs(amount).toFixed(2)}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400">
                                <span>${escapeHtml(dateText)} · ${escapeHtml(type)}</span>
                                <span>${escapeHtml(status)}</span>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const loadSelectedCardTransactions = async (cardId) => {
                if (!selectedCardRecentActivity) return;

                const requestId = ++latestTransactionsRequestId;

                selectedCardRecentActivity.innerHTML = `
                    <div class="py-4 text-center text-slate-500 text-[11px]">
                        Loading transactions...
                    </div>
                `;

                try {
                    const endpoint = `${getTransactionsRoute}?card_id=${encodeURIComponent(cardId)}&limit=5`;
                    const response = await fetch(endpoint, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    const payload = await response.json();

                    if (requestId !== latestTransactionsRequestId) {
                        return;
                    }

                    if (!response.ok || !payload?.success) {
                        throw new Error(payload?.message || 'Failed to fetch transactions.');
                    }

                    renderSelectedCardTransactions(payload.transactions || []);
                } catch (error) {
                    if (requestId !== latestTransactionsRequestId) {
                        return;
                    }

                    selectedCardRecentActivity.innerHTML = `
                        <div class="py-4 text-center text-rose-500 text-[11px]">
                            Failed to load transactions.
                        </div>
                    `;
                }
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
                const organization = cardRow.dataset.organization || '';
                const status = cardRow.dataset.status || '0';
                const statusNumber = Number.parseInt(status, 10);
                const isFrozen = statusNumber === 2;
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

                applySelectedCardTheme(organization);

                if (selectedStatus) {
                    if (statusNumber === 1) {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active`;
                    } else if (statusNumber === 2) {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Frozen`;
                    } else {
                        selectedStatus.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Pending`;
                    }
                }

                if (selectedCardBox) {
                    // This class is required for app.css to show/hide the lock overlay.
                    selectedCardBox.classList.toggle('card-frozen', isFrozen);

                    if (selectedCardBoxContent) {
                        selectedCardBoxContent.classList.toggle('grayscale', isFrozen);
                        selectedCardBoxContent.classList.toggle('blur-sm', isFrozen);
                    } else {
                        // Fallback: keep previous behavior if content wrapper is missing.
                        selectedCardBox.classList.toggle('grayscale', isFrozen);
                        selectedCardBox.classList.toggle('blur-sm', isFrozen);
                    }
                }

                // Force-lock visibility so it behaves consistently across card themes.
                if (selectedCardFrozenLock) {
                    selectedCardFrozenLock.style.setProperty('display', isFrozen ? 'flex' : 'none', 'important');
                    selectedCardFrozenLock.style.setProperty('z-index', '9999', 'important');
                    selectedCardFrozenLock.style.setProperty('opacity', isFrozen ? '1' : '0', 'important');
                }

                if (selectedCardFrozenBadge) {
                    selectedCardFrozenBadge.classList.toggle('hidden', statusNumber !== 2);
                }

                if (selectedCardUpdateBalanceBtn) {
                    const isFrozen = statusNumber === 2;
                    const canRefreshBalance = Boolean(cardId) && !isFrozen;

                    selectedCardUpdateBalanceBtn.classList.toggle('hidden', !canRefreshBalance);

                    if (canRefreshBalance) {
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

                if (selectedCardFreezeLabel) {
                    selectedCardFreezeLabel.innerText = status == 2 ? 'UNFREEZE' : 'FREEZE';
                }

                if (selectedCardFreezeFormCardId) {
                    selectedCardFreezeFormCardId.value = cardId;
                }

                if (rechargeCardIdInput) {
                    rechargeCardIdInput.value = cardId;
                }

                if (cashoutCardIdInput) {
                    cashoutCardIdInput.value = cardId;
                }

                if (cashoutCardBalanceText) {
                    cashoutCardBalanceText.innerText = `$${balance}`;
                }

                if (btnTopupSelectedCard) {
                    const hasCard = Boolean(cardId);
                    btnTopupSelectedCard.classList.toggle('pointer-events-none', !hasCard);
                    btnTopupSelectedCard.classList.toggle('opacity-60', !hasCard);
                }

                if (btnCashoutSelectedCard) {
                    const hasCard = Boolean(cardId);
                    btnCashoutSelectedCard.classList.toggle('pointer-events-none', !hasCard);
                    btnCashoutSelectedCard.classList.toggle('opacity-60', !hasCard);
                }

                if (cardId) {
                    loadSelectedCardTransactions(cardId);
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

            btnCashoutSelectedCard?.addEventListener('click', () => {
                if (!selectedCardId || !cashoutModal || !cashoutCardIdInput) {
                    alert('Select a card first.');
                    return;
                }

                cashoutCardIdInput.value = selectedCardId;
                updateCashoutTotal();
                cashoutModal.classList.remove('hidden');
                cashoutModal.classList.add('flex');
                cashoutAmountInput?.focus();
            });

            closeCashoutModalBtn?.addEventListener('click', closeCashoutModal);
            cancelCashoutModalBtn?.addEventListener('click', closeCashoutModal);

            cashoutModal?.addEventListener('click', (event) => {
                if (event.target === cashoutModal) {
                    closeCashoutModal();
                }
            });

            rechargeAmountInput?.addEventListener('input', updateRechargeTotal);
            cashoutAmountInput?.addEventListener('input', updateCashoutTotal);

            updateActiveFilterStyles();
            applyCardFilters();
            updateRechargeTotal();
            updateCashoutTotal();
            applySelectedCardTheme('');

        });

        // Previous js
        function copyCard() {
            const cardNumber = document.getElementById('card_number').value;
            navigator.clipboard.writeText(cardNumber)
                .then(() => alert('Card number copied!'))
                .catch(err => alert('Failed to copy'));
        }

    </script>
</x-app-layout>