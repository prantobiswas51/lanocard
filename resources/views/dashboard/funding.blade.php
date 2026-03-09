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
                        <span id="addMoneyCurrentBalance" class="font-semibold text-emerald-700">$1,200.00</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Updates automatically after a successful top‑up (demo).</p>
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
                                    <button
                                        class="w-full px-3 py-2 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-700 font-medium flex items-center justify-between">
                                        <span class="flex items-center gap-1.5">
                                            <span
                                                class="h-4 w-4 rounded-full bg-slate-900 text-[9px] flex items-center justify-center text-yellow-300 font-semibold">₿</span>
                                            BTC
                                        </span>
                                        <span class="text-[10px] text-emerald-700/80">Popular</span>
                                    </button>
                                    <button
                                        class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:border-emerald-300 flex items-center justify-between">
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
                                <select
                                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                                    <option>BTC (Bitcoin mainnet)</option>
                                    <option>USDT · TRC20 (Tron)</option>
                                    <option>USDT · ERC20 (Ethereum)</option>
                                    <option>USDT · BEP20 (BSC)</option>
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
                                    class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                                    <span class="text-slate-400 text-xs">$</span>
                                    <input id="addMoneyAmount" type="number" min="20" step="1" placeholder="e.g. 200"
                                        class="w-full bg-transparent border-none text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    <button
                                        class="px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">50</button>
                                    <button
                                        class="px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">100</button>
                                    <button
                                        class="px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 text-slate-600 bg-white hover:border-emerald-400/70 hover:text-emerald-600">250</button>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-medium text-slate-800">Estimated crypto amount</label>
                                <div
                                    class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs space-y-1.5">
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>Rate (demo)</span>
                                        <span class="font-medium text-slate-900">1 BTC ≈ $60,000</span>
                                    </div>
                                    <div class="flex items-center justify-between text-slate-600">
                                        <span>You will send</span>
                                        <span class="font-semibold text-emerald-700">~0.0033 BTC</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500">
                                        Final amount depends on network fee &amp; real‑time rate.
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
                                            <span class="text-slate-500">BTC · Mainnet address</span>
                                            <button
                                                class="rounded-full border border-slate-200 bg-white px-2 py-0.5 text-[10px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                                                Copy
                                            </button>
                                        </div>
                                        <p class="font-mono text-[11px] text-slate-800 break-all">
                                            bc1q2x3y4z5a6b7c8d9e0f1g2h3i4j5k6l7m8n9p0
                                        </p>
                                    </div>
                                    <p
                                        class="text-[10px] text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-2 py-1">
                                        Send only BTC on Bitcoin mainnet to this address. Any other asset may be lost.
                                    </p>
                                </div>
                                <div class="space-y-1.5">
                                    <div
                                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs flex flex-col items-center justify-center">
                                        <div
                                            class="h-20 w-20 rounded-lg bg-slate-200 flex items-center justify-center text-[10px] text-slate-500 mb-1">
                                            QR PREVIEW
                                        </div>
                                        <p class="text-[10px] text-slate-500 text-center">
                                            Scan this address with your crypto wallet to send funds.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="pt-1 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-[11px]">
                            <p class="text-slate-500 max-w-md">
                                After sending crypto, your deposit will appear as “Pending” and will be credited
                                to your main balance after required confirmations.
                            </p>
                            <button id="btnGenerateCryptoDeposit"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2.5 text-xs font-semibold text-white shadow-md hover:bg-emerald-600">
                                <span>Generate new deposit request</span>
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0-5-5m5 5-5 5" />
                                </svg>
                            </button>
                        </div>
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
                                        number. Rate: $1 = 126 BDT</p>
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
                                <strong>virtualpay@payoneer.com</strong>. Use your registered email as reference.
                                Minimum $20.</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">After sending, contact support
                                with your transaction ID to credit your balance.</p>
                        </div>
                        <!-- Bkash instructions and form (shown when Bkash selected) -->
                        <div id="manualInstructionsBkash"
                            class="hidden rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/30 px-4 py-4 text-xs space-y-4">
                            <p class="font-medium text-slate-800 dark:text-slate-200">Bkash deposit</p>
                            <div class="space-y-1">
                                <p class="text-slate-600 dark:text-slate-400">Send BDT to this number:</p>
                                <p class="font-mono font-semibold text-slate-900 dark:text-slate-100 text-sm">01712
                                    345678</p>
                            </div>
                            <div
                                class="flex items-center gap-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 px-3 py-2">
                                <span class="text-slate-500 dark:text-slate-400">Rate:</span>
                                <span class="font-semibold text-emerald-600 dark:text-emerald-400">$1 = 126 BDT</span>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-slate-700 dark:text-slate-300 font-medium">Amount
                                        (BDT)</label>
                                    <input id="bkashAmountBdt" type="number" min="252" step="1" placeholder="e.g. 1500"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Min 252 BDT (≈ $2)</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-slate-700 dark:text-slate-300 font-medium">You will receive
                                        (USD)</label>
                                    <div
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 px-3 py-2.5 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                        <span id="bkashReceivedUsd">$0.00</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Equivalent <span
                                            id="bkashEquivalentUsd">$0.00</span> − <span id="bkashFeeText">$1.00</span>
                                        deposit fee</p>
                                </div>
                            </div>
                            <div id="bkashFormAfterAmount" class="space-y-3">
                                <div class="space-y-1.5">
                                    <label class="block text-slate-700 dark:text-slate-300 font-medium">Transaction
                                        ID</label>
                                    <input id="bkashTransactionId" type="text"
                                        placeholder="Enter transaction ID after sending"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                                </div>
                                <button type="button" id="bkashSubmitBtn"
                                    class="w-full rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 text-sm transition">
                                    Submit deposit
                                </button>
                            </div>
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
                            <h3 class="text-sm font-semibold text-slate-900">Crypto funding history</h3>
                        </div>
                        <button
                            class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                            View all
                        </button>
                    </div>

                    <div class="space-y-2 text-[11px]">
                        <div
                            class="flex items-center justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-6 w-6 rounded-full bg-slate-900 text-[10px] flex items-center justify-center text-yellow-300 font-semibold">₿</span>
                                <div class="space-y-0.5">
                                    <p class="text-slate-800 font-medium">0.0025 BTC · $150</p>
                                    <p class="text-[10px] text-slate-500">BTC · Mainnet · 2/3 confirmations</p>
                                </div>
                            </div>
                            <span
                                class="rounded-full bg-amber-50 border border-amber-200 px-2 py-0.5 text-[10px] text-amber-700 font-medium">
                                Pending
                            </span>
                        </div>

                        <div
                            class="flex items-center justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-6 w-6 rounded-full bg-emerald-500 text-[10px] flex items-center justify-center text-white font-semibold">₮</span>
                                <div class="space-y-0.5">
                                    <p class="text-slate-800 font-medium">120 USDT · $120</p>
                                    <p class="text-[10px] text-slate-500">USDT · TRC20 · Confirmed</p>
                                </div>
                            </div>
                            <span
                                class="rounded-full bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[10px] text-emerald-700 font-medium">
                                Credited
                            </span>
                        </div>

                        <div
                            class="flex items-center justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 opacity-80">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-6 w-6 rounded-full bg-emerald-500 text-[10px] flex items-center justify-center text-white font-semibold">₮</span>
                                <div class="space-y-0.5">
                                    <p class="text-slate-800 font-medium">300 USDT · $300</p>
                                    <p class="text-[10px] text-slate-500">USDT · ERC20 · Credited 3d ago</p>
                                </div>
                            </div>
                            <span
                                class="rounded-full bg-slate-50 border border-slate-200 px-2 py-0.5 text-[10px] text-slate-500 font-medium">
                                Completed
                            </span>
                        </div>
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
            const copyBtn = document.querySelector(".copy-btn");
            const depositInput = document.getElementById("deposit_address");

            copyBtn.addEventListener("click", function () {
                navigator.clipboard.writeText(depositInput.value)
                    .then(() => {
                        copyBtn.textContent = "Copied!";
                        setTimeout(() => copyBtn.textContent = "Copy", 1500);
                    })
                    .catch(() => alert("Failed to copy"));
            });
        });

        const paymentSelect = document.getElementById('payment-method');
        const msgDiv = document.getElementById('show_msg');
        const copyBtn = document.getElementById('copy_btn');

        paymentSelect.addEventListener('change', function() {
            let message = '';

            @php

            $payoneer_email = \App\Models\Setting::value('payoneer_email');
            $paypal_email = \App\Models\Setting::value('paypal_email');
            $skrill_email = \App\Models\Setting::value('skrill_email');

            @endphp

            switch (this.value) {
            case 'payoneer':
                message = '{{ $payoneer_email }}';
                break;
            case 'paypal':
                message = '{{ $paypal_email }}';
                break;
            case 'skrill':
                message = '{{ $skrill_email }}';
                break;
            default:
                message = '';
            }

            msgDiv.textContent = message;
            copyBtn.style.display = message ? 'inline' : 'none';
        });

        copyBtn.addEventListener('click', () => {
            if (msgDiv.textContent.trim() !== '') {
            navigator.clipboard.writeText(msgDiv.textContent.trim());
            copyBtn.textContent = 'Copied!';
            setTimeout(() => copyBtn.textContent = 'Copy', 1500);
            }
        });
    </script>


</x-app-layout>