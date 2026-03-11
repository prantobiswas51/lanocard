<x-app-layout>

    <section id="viewAddMoney" class="flex-1 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 font-semibold">Add money</p>
                    <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Top‑up your main balance</h2>
                    <p class="text-xs text-slate-500 max-w-xl">
                        Instantly fund your account using crypto deposits. Once confirmed on‑chain,
                        the amount will appear in your main balance and can be used to create cards.
                    </p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-600">Current balance</span>
                        <span class="font-semibold text-emerald-700">${{ number_format(Auth::user()->balance, 2)
                            }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Updates automatically after a successful top‑up.</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-[1.5fr,1.1fr] gap-5 items-start">
                <!-- Left: methods & crypto form -->
                <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 space-y-5 shadow-sm">
                    <!-- Method tabs -->
                    <div class="flex rounded-full bg-slate-50 border border-slate-200 p-1 text-[11px]">
                        <button id="tabAddCrypto"
                            class="flex-1 px-3 py-1.5 rounded-full bg-emerald-500 text-white font-medium shadow-sm">
                            Crypto
                        </button>
                        <button id="tabAddManual"
                            class="flex-1 px-3 py-1.5 rounded-full text-slate-500 hover:text-slate-900 hover:bg-white transition">
                            Manual
                        </button>
                    </div>

                    <!-- Crypto form -->
                    <div id="panelAddCrypto" class="space-y-4 text-sm">
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="text-xs font-medium text-slate-800">Select coin</label>
                                <div class="grid grid-cols-2 gap-2 text-[11px]">
                                    <button type="button" data-coin="TRX"
                                        class="crypto-coin-option w-full px-3 py-2 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-700 font-medium flex items-center justify-between">
                                        <span class="flex items-center gap-1.5">
                                            <span
                                                class="h-4 px-1 rounded-full bg-slate-900 text-[8px] flex items-center justify-center text-yellow-300 font-semibold">TRX</span>
                                            TRX
                                        </span>
                                        <span class="text-[10px] text-emerald-700/80">Popular</span>
                                    </button>
                                    <button type="button" data-coin="USDT"
                                        class="crypto-coin-option w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:border-emerald-300 flex items-center justify-between">
                                        <span class="flex items-center gap-1.5">
                                            <span
                                                class="h-4 w-4 rounded-full bg-emerald-500 text-[9px] flex items-center justify-center text-white font-semibold">₮</span>
                                            USDT
                                        </span>
                                        <span class="text-[10px] text-slate-500">Stable</span>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-medium text-slate-800">Network</label>
                                <select id="addMoneyNetwork"
                                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                                    <option value="TRX_TRC20">TRX · TRC20 (Tron)</option>
                                    <option value="USDT_TRC20">USDT · TRC20 (Tron)</option>
                                </select>
                                <p class="text-[10px] text-slate-500">
                                    Only send selected coin on the chosen network or funds will be lost.
                                </p>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-[1.2fr,1.1fr] gap-3">
                            <div class="space-y-1.5">
                                <label class="text-xs font-medium text-slate-800">Amount to add (USD)</label>
                                <div
                                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50  pl-3">
                                    <span class="text-slate-400 text-xs">$</span>
                                    <input id="addMoneyAmount" type="number" min="20" step="1" placeholder="e.g. 200"
                                        class="w-full bg-transparent border-none text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    <button type="button"
                                        class="quick-amount-add-money px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">50</button>
                                    <button type="button"
                                        class="quick-amount-add-money px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">100</button>
                                    <button type="button"
                                        class="quick-amount-add-money px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">250</button>
                                </div>
                            </div>

                            {{-- FLAG-1 --}}
                            <div class="space-y-1.5">
                                <label class="text-xs font-medium text-slate-800">Estimated crypto amount</label>
                                <div
                                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs space-y-1.5">
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Rate</span>
                                        <span id="estimatedRateText" class="font-medium text-slate-900">1 TRX ≈
                                            $0.00001667</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>You will send</span>
                                        <span id="estimatedSendText" class="font-semibold text-emerald-700">~0
                                            TRX</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Fee</span>
                                        <span id="estimatedFeeText" class="font-semibold text-emerald-700">$1 USD</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Final Deposit Amount</span>
                                        <span id="estimatedFinalText" class="font-semibold text-emerald-700"> </span>
                                    </div>
                                    <p class="text-[10px] text-slate-500">
                                        Final amount depends on network fee &amp; real-time rate.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-medium text-slate-800">Your deposit address</label>
                            <div class="grid sm:grid-cols-[1.4fr,1fr] gap-3">

                                <div class="space-y-1.5">
                                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs">
                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <span class="text-slate-500">TRX · Mainnet address</span>
                                            <button
                                                class="rounded-full border border-slate-200 bg-white px-2 py-0.5 text-[10px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                                                Copy
                                            </button>
                                        </div>
                                        <p class="font-mono text-[11px] text-slate-800 break-all">
                                            {{ $trx_address }}
                                        </p>
                                    </div>
                                    <p
                                        class="text-[10px] text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-2 py-1">
                                        Send only TRX on Tron mainnet to this address. Any other asset may be lost.
                                    </p>
                                </div>

                                <div class="space-y-1.5">
                                    <div
                                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs flex flex-col items-center justify-center">
                                        <div
                                            class="h-20 w-20 rounded-lg bg-slate-200 flex items-center justify-center text-[10px] text-slate-500 mb-1">
                                            @if($trx_address)
                                            {!! QrCode::size(150)->generate($trx_address); !!}
                                            @endif
                                        </div>
                                        <p class="text-[10px] text-slate-500 text-center">
                                            Scan this address with your crypto wallet to send funds.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Auto Deposit Form --}}

                            <form action="{{ route('check_deposit') }}" method="post">
                                @csrf
                                <div
                                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50  pl-3">
                                    <span class="text-slate-400 text-xs">$</span>
                                    <input type="text" placeholder="Enter your transaction ID after sending" required
                                        name="tx_id"
                                        class="w-full bg-transparent border-none text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                                </div>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}" required />

                        </div>

                        <div
                            class="pt-1 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-[11px]">
                            <p class="text-slate-500 max-w-md">
                                After sending crypto, your deposit will appear as “Pending” and will be credited
                                to your main balance after required confirmations.
                            </p>
                            <button type="submit"
                                class="inline-flex items-center min-w-10 justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2.5 text-xs font-semibold text-white shadow-md hover:bg-emerald-600">
                                <span>Submit Request</span>
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0-5-5m5 5-5 5" />
                                </svg>
                            </button>
                        </div>

                        </form>
                    </div>

                    <!-- Manual form (Bkash, Payoneer) -->
                    <div id="panelAddManual" class="hidden space-y-4 text-sm">
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Choose a manual payment method. You
                            will receive instructions to complete the transfer.</p>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <button type="button"
                                class="add-manual-option rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-4 text-left hover:border-emerald-300 dark:hover:border-emerald-500 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20 transition flex items-center gap-3"
                                data-method="bkash">
                                <span class="h-12 w-12 rounded-xl bg-[#e2136e]/10 flex items-center justify-center">
                                    <span class="text-[#e2136e] font-bold text-lg">b</span>
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Bkash</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Send BDT to our Bkash
                                        number. Rate: $1 = {{ $bkash_rate }} BDT</p>
                                </div>
                            </button>
                            <button type="button"
                                class="add-manual-option rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-4 text-left hover:border-emerald-300 dark:hover:border-emerald-500 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20 transition flex items-center gap-3"
                                data-method="payoneer">
                                <span class="h-12 w-12 rounded-xl bg-[#ff5000]/10 flex items-center justify-center">
                                    <span class="text-[#ff5000] font-bold text-lg">P</span>
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">Payoneer</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Send via Payoneer to our
                                        registered email</p>
                                </div>
                            </button>
                        </div>

                        <!-- Payoneer instructions (shown when Payoneer selected) -->
                        <div id="manualInstructionsPayoneer"
                            class="hidden rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30 px-4 py-3 text-xs space-y-2">
                            <p class="font-medium text-slate-800 dark:text-slate-200">Instructions</p>
                            <p class="text-slate-600 dark:text-slate-400">Send payment via Payoneer to:
                                <strong>payoneer@lanocard.com</strong>. Use your registered email as reference. Minimum
                                $20.
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">After sending, contact support
                                with your transaction ID to credit your balance.</p>
                        </div>

                        <!-- Bkash instructions and form (shown when Bkash selected) -->
                        {{-- Flag-2 --}}
                        <div id="manualInstructionsBkash" data-bkash-rate="{{ $bkash_rate ?? 126 }}" data-bkash-fee="1"
                            class="hidden rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30 px-4 py-4 text-xs space-y-4">
                            <form id="bkashDepositForm" action="{{ route('bkash_manual_deposit') }}" method="post"
                                class="space-y-4">
                                @csrf
                                <input type="hidden" name="payment_method" value="bkash" />
                                <input type="hidden" name="currency" value="USD" />
                                <input type="hidden" name="amount_bdt" id="bkashAmountBdtHidden" value="0" />
                                <input type="hidden" name="equivalent_usd" id="bkashEquivalentUsdHidden" value="0" />
                                <input type="hidden" name="deposit_fee" id="bkashFeeHidden" value="1" />
                                <input type="hidden" name="amount" id="bkashReceivedUsdHidden" value="0" />

                                <p class="font-medium text-slate-800 dark:text-slate-200">Bkash deposit</p>
                                <div class="space-y-1">
                                    <p class="text-slate-600 dark:text-slate-400">Send BDT to this number:</p>
                                    <p class="font-mono font-semibold text-slate-900 dark:text-slate-100 text-sm">{{
                                        $bkash_number ?? 'Not set' }}</p>
                                </div>
                                <div
                                    class="flex items-center gap-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 px-3 py-2">
                                    <span class="text-slate-500 dark:text-slate-400">Rate:</span>
                                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">$1 = {{
                                        $bkash_rate ?? 0 }} BDT</span>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    <div class="space-y-1.5">
                                        <label class="block text-slate-700 dark:text-slate-300 font-medium">Amount
                                            (BDT)</label>
                                        <input id="bkashAmountBdt" name="amount_bdt_input" type="number" min="1500"
                                            step="1" placeholder="e.g. 1500"
                                            class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Min 1500 BDT</p>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="block text-slate-700 dark:text-slate-300 font-medium">You will
                                            receive
                                            (USD)</label>
                                        <div
                                            class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 px-3 py-2.5 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                            <span id="bkashReceivedUsd">$0.00</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Equivalent <span
                                                id="bkashEquivalentUsd"></span> − <span id="bkashFeeText">$1.00</span>
                                            deposit fee</p>
                                    </div>
                                </div>
                                <div id="bkashFormAfterAmount" class="space-y-3">
                                    <div class="space-y-1.5">
                                        <label class="block text-slate-700 dark:text-slate-300 font-medium">Transaction
                                            ID</label>
                                        <input id="bkashTransactionId" name="tx_id" type="text"
                                            placeholder="Enter transaction ID after sending"
                                            class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                                    </div>
                                    <button type="submit" id="bkashSubmitBtn"
                                        class="w-full rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 text-sm transition">
                                        Submit deposit
                                    </button>
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::id() }}" required />
                            </form>
                            <div id="bkashProcessingStatus"
                                class="hidden rounded-lg border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 px-3 py-3 space-y-1">
                                <p class="font-semibold text-amber-800 dark:text-amber-200">Deposit processing</p>
                                <p class="text-[11px] text-amber-700 dark:text-amber-300">Admin will verify and credit
                                    your balance. You will be notified once approved.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: recent deposits -->
                <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 space-y-4 shadow-sm text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500 font-semibold">Recent deposits
                            </p>
                            <h3 class="text-sm font-semibold text-slate-900">Funding history</h3>
                        </div>
                    </div>

                    <div class="space-y-2 text-[11px]">

                        @forelse ($deposits as $deposit)
                        <div
                            class="flex items-center justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-6 w-6 rounded-full bg-slate-900 text-[10px] flex items-center justify-center text-yellow-300 font-semibold">
                                    @if($deposit->method === 'Bkash')
                                    B
                                    @elseif($deposit->method === 'Payoneer')
                                    P
                                    @else
                                    !!
                                    @endif
                                </span>
                                <div class="space-y-0.5">
                                    <p class="text-slate-800 font-medium">${{$deposit->amount}} {{$deposit->currency}} |
                                        @if($deposit->bdt_amount) {{ number_format($deposit->bdt_amount, 2) }} BDT
                                        @elseif($deposit->trx_amount) {{ number_format($deposit->trx_amount, 2) }} TRX
                                        @else
                                        
                                        @endif
                                    </p>
                                    <p class="text-[10px] text-slate-500">{{$deposit->created_at->format('M j, Y g:i
                                        A')}}</p>
                                </div>
                            </div>
                            <span
                                class="rounded-full bg-amber-50 border border-amber-200 px-2 py-0.5 text-[10px] text-amber-700 font-medium">
                                {{$deposit->status}}
                            </span>
                        </div>
                        @empty
                        <div class="p-2 border rounded-xl text-center">
                            No transactions
                        </div>
                        @endforelse

                    </div>

                    <p class="text-[10px] text-slate-500">
                        All crypto deposits are converted to USD balance for your account. This section is demo‑only and
                        does not
                        connect to a real blockchain.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let trxUsdCache = null;
            let trxUsdCacheTime = 0;

            async function trxUsdPrice() {
                const cacheDuration = 60 * 1000;

                if (trxUsdCache && (Date.now() - trxUsdCacheTime) < cacheDuration) {
                    return trxUsdCache;
                }

                const res = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=tron&vs_currencies=usd');
                const data = await res.json();

                trxUsdCache = parseFloat(data?.tron?.usd ?? 0);
                trxUsdCacheTime = Date.now();

                return trxUsdCache;
            }

            const tabAddCrypto = document.getElementById('tabAddCrypto');
            const tabAddManual = document.getElementById('tabAddManual');
            const panelAddCrypto = document.getElementById('panelAddCrypto');
            const panelAddManual = document.getElementById('panelAddManual');

            if (tabAddCrypto && tabAddManual) {
                tabAddCrypto.addEventListener('click', () => {
                    tabAddCrypto.classList.add('bg-emerald-500', 'text-white', 'font-medium', 'shadow-sm');
                    tabAddCrypto.classList.remove('text-slate-500');
                    tabAddManual.classList.remove('bg-emerald-500', 'text-white', 'font-medium', 'shadow-sm');
                    tabAddManual.classList.add('text-slate-500');
                    panelAddCrypto?.classList.remove('hidden');
                    panelAddManual?.classList.add('hidden');
                });

                tabAddManual.addEventListener('click', () => {
                    tabAddManual.classList.add('bg-emerald-500', 'text-white', 'font-medium', 'shadow-sm');
                    tabAddManual.classList.remove('text-slate-500');
                    tabAddCrypto.classList.remove('bg-emerald-500', 'text-white', 'font-medium', 'shadow-sm');
                    tabAddCrypto.classList.add('text-slate-500');
                    panelAddManual?.classList.remove('hidden');
                    panelAddCrypto?.classList.add('hidden');
                });
            }

            const addMoneyAmountInput = document.getElementById('addMoneyAmount');
            const addMoneyNetworkSelect = document.getElementById('addMoneyNetwork');
            const estimatedRateText = document.getElementById('estimatedRateText');
            const estimatedSendText = document.getElementById('estimatedSendText');
            const estimatedFinalText = document.getElementById('estimatedFinalText');
            const addMoneyCoinOptions = document.querySelectorAll('.crypto-coin-option');
            const ADD_MONEY_FIXED_FEE_USD = 1;

            function setActiveAddMoneyCoin(targetCoin) {
                addMoneyCoinOptions.forEach((btn) => {
                    const isActive = (btn.dataset.coin || '').toUpperCase() === targetCoin;
                    btn.classList.toggle('border-emerald-300', isActive);
                    btn.classList.toggle('bg-emerald-50', isActive);
                    btn.classList.toggle('text-emerald-700', isActive);
                    btn.classList.toggle('font-medium', isActive);
                    btn.classList.toggle('border-slate-200', !isActive);
                    btn.classList.toggle('bg-white', !isActive);
                    btn.classList.toggle('text-slate-700', !isActive);
                });
            }

            function getSelectedAddMoneyCoin() {
                const activeBtn = Array.from(addMoneyCoinOptions).find((btn) => btn.classList.contains('bg-emerald-50'));
                if (activeBtn?.dataset.coin) return activeBtn.dataset.coin.toUpperCase();
                const coinFromNetwork = (addMoneyNetworkSelect?.value || '').split('_')[0];
                return (coinFromNetwork || 'TRX').toUpperCase();
            }

            async function updateAddMoneyEstimate() {
                if (!addMoneyAmountInput || !estimatedRateText || !estimatedSendText) return;

                const selectedCoin = getSelectedAddMoneyCoin();
                const amountUsd = parseFloat(addMoneyAmountInput.value || '0') || 0;
                const finalUsd = Math.max(0, amountUsd - ADD_MONEY_FIXED_FEE_USD);
                if (estimatedFinalText) estimatedFinalText.textContent = `$${finalUsd.toFixed(2)} USD`;

                let usdPerCoin = 0;
                if (selectedCoin === 'USDT') {
                    usdPerCoin = 1;
                } else {
                    try {
                        usdPerCoin = await trxUsdPrice();
                    } catch (e) {
                        usdPerCoin = 0;
                    }
                }

                if (usdPerCoin > 0) {
                    estimatedRateText.textContent = `1 ${selectedCoin} ≈ $${usdPerCoin.toFixed(selectedCoin === 'USDT' ? 2 : 8)}`;
                    const coinAmount = amountUsd > 0 ? amountUsd / usdPerCoin : 0;
                    estimatedSendText.textContent = `~${coinAmount.toLocaleString(undefined, { maximumFractionDigits: 4 })} ${selectedCoin}`;
                } else {
                    estimatedRateText.textContent = `1 ${selectedCoin} ≈ Unavailable`;
                    estimatedSendText.textContent = `~0 ${selectedCoin}`;
                }
            }

            if (addMoneyAmountInput && estimatedRateText && estimatedSendText) {
                addMoneyCoinOptions.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const coin = (btn.dataset.coin || 'TRX').toUpperCase();
                        setActiveAddMoneyCoin(coin);
                        if (addMoneyNetworkSelect) addMoneyNetworkSelect.value = `${coin}_TRC20`;
                        updateAddMoneyEstimate();
                    });
                });

                addMoneyNetworkSelect?.addEventListener('change', () => {
                    const coin = (addMoneyNetworkSelect.value || 'TRX_TRC20').split('_')[0].toUpperCase();
                    setActiveAddMoneyCoin(coin);
                    updateAddMoneyEstimate();
                });

                addMoneyAmountInput.addEventListener('input', updateAddMoneyEstimate);

                document.querySelectorAll('.quick-amount-add-money').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        addMoneyAmountInput.value = btn.textContent.trim();
                        updateAddMoneyEstimate();
                    });
                });

                setActiveAddMoneyCoin(getSelectedAddMoneyCoin());
                updateAddMoneyEstimate();
            }

            const bkashPanel = document.getElementById('manualInstructionsBkash');
            const BKASH_RATE = parseFloat(bkashPanel?.dataset?.bkashRate || '126') || 126;
            const BKASH_DEPOSIT_FEE = parseFloat(bkashPanel?.dataset?.bkashFee || '1') || 1;

            document.querySelectorAll('.add-manual-option').forEach((btn) => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.add-manual-option').forEach((b) => b.classList.remove('border-emerald-400', 'bg-emerald-50', 'dark:bg-emerald-900/20'));
                    btn.classList.add('border-emerald-400', 'bg-emerald-50', 'dark:bg-emerald-900/20');
                    const method = btn.dataset.method || '';
                    const panelPayoneer = document.getElementById('manualInstructionsPayoneer');
                    const panelBkash = document.getElementById('manualInstructionsBkash');

                    if (method === 'bkash') {
                        panelPayoneer?.classList.add('hidden');
                        panelBkash?.classList.remove('hidden');
                    } else {
                        panelBkash?.classList.add('hidden');
                        panelPayoneer?.classList.remove('hidden');
                    }
                });
            });

            const bkashAmountBdt = document.getElementById('bkashAmountBdt');
            const bkashEquivalentUsd = document.getElementById('bkashEquivalentUsd');
            const bkashReceivedUsd = document.getElementById('bkashReceivedUsd');
            const bkashFeeText = document.getElementById('bkashFeeText');
            const bkashAmountBdtHidden = document.getElementById('bkashAmountBdtHidden');
            const bkashEquivalentUsdHidden = document.getElementById('bkashEquivalentUsdHidden');
            const bkashReceivedUsdHidden = document.getElementById('bkashReceivedUsdHidden');
            const bkashFeeHidden = document.getElementById('bkashFeeHidden');

            function updateBkashReceived() {
                if (!bkashAmountBdt) return;
                const bdt = parseFloat(bkashAmountBdt.value || '0') || 0;
                const equivalentUsd = bdt / BKASH_RATE;
                const received = Math.max(0, equivalentUsd - BKASH_DEPOSIT_FEE);

                if (bkashEquivalentUsd) bkashEquivalentUsd.textContent = '$' + equivalentUsd.toFixed(2);
                if (bkashReceivedUsd) bkashReceivedUsd.textContent = '$' + received.toFixed(2);
                if (bkashFeeText) bkashFeeText.textContent = '$' + BKASH_DEPOSIT_FEE.toFixed(2);

                if (bkashAmountBdtHidden) bkashAmountBdtHidden.value = String(bdt.toFixed(2));
                if (bkashEquivalentUsdHidden) bkashEquivalentUsdHidden.value = String(equivalentUsd.toFixed(2));
                if (bkashReceivedUsdHidden) bkashReceivedUsdHidden.value = String(received.toFixed(2));
                if (bkashFeeHidden) bkashFeeHidden.value = String(BKASH_DEPOSIT_FEE.toFixed(2));
            }

            if (bkashAmountBdt) {
                bkashAmountBdt.addEventListener('input', updateBkashReceived);
            }

            document.getElementById('bkashDepositForm')?.addEventListener('submit', function (e) {
                const minBdt = parseFloat(bkashAmountBdt?.getAttribute('min') || '252') || 252;
                const bdt = parseFloat(bkashAmountBdt?.value || '0') || 0;
                const txId = (document.getElementById('bkashTransactionId')?.value || '').trim();

                if (bdt < minBdt) {
                    e.preventDefault();
                    alert('Minimum amount is ' + minBdt + ' BDT.');
                    return;
                }

                if (!txId) {
                    e.preventDefault();
                    alert('Please enter your Bkash transaction ID.');
                    return;
                }

                updateBkashReceived();
            });

            updateBkashReceived();
        });
    </script>


</x-app-layout>