@php
$statusLabel = match ((string) $card->state) {
'1' => 'Active',
'2' => 'Frozen',
'0' => 'Canceled',
'4' => 'Pending',
default => 'Unknown',
};
$rawNumber = $card->number ?? null;
if ($rawNumber === null || $rawNumber === '') {
$displayNumber = '—';
} else {
$digits = preg_replace('/\D+/', '', (string) $rawNumber);
$displayNumber = $digits !== ''
? trim(implode(' ', str_split($digits, 4)))
: (string) $rawNumber;
}
$displayExpiry = $card->expiryDate ?? '—';
$organization = strtoupper((string) ($card->organization ?? ''));
$holderLabel = $card->name ?? ($card->holderName ?? ($card->email ?? 'Card holder'));
$cardTheme = match ($organization) {
'VISA' => 'from-blue-700 via-indigo-600 to-cyan-500',
'MASTERCARD' => 'from-neutral-900 via-neutral-800 to-slate-700',
default => 'from-slate-700 via-slate-800 to-slate-900',
};
$statusChipClass = match (strtolower($statusLabel)) {
'active' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
'frozen' => 'bg-amber-100 text-amber-700 border-amber-200',
'canceled' => 'bg-rose-100 text-rose-700 border-rose-200',
'pending' => 'bg-sky-100 text-sky-700 border-sky-200',
default => 'bg-slate-100 text-slate-700 border-slate-200',
};
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Lanocard') }} | Shared Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Roboto+Mono:wght@500;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=HRpsafNtjfJ2"></script>
    <style>
        body {
            font-family: "Manrope", "Segoe UI", Arial, sans-serif;
        }

        .card-digits {
            font-family: "Roboto Mono", ui-monospace, SFMono-Regular, Menlo, monospace;
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 flex flex-col">
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-6xl items-center px-4 py-3">
            <div class="flex items-baseline gap-1.5">
                <span class="text-lg font-extrabold tracking-tight text-sky-600 sm:text-2xl">Lano Gift Card</span>
                <span class="hidden text-[11px] text-slate-500 sm:inline">Shared View</span>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-3 py-5 sm:px-4 sm:py-8">
        <div class="grid gap-6 lg:grid-cols-12">

            <section class="lg:col-span-4">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="relative bg-gradient-to-br {{ $cardTheme }} p-4 text-white sm:p-5">
                        <div
                            class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_45%)]">
                        </div>
                        <div
                            class="mb-4 flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-blue-100">
                            <span>Lano Virtual Card</span>
                        </div>

                        <p
                            class="card-digits mt-2 whitespace-nowrap text-[0.98rem] font-semibold leading-tight tracking-[0.08em] sm:text-[1.12rem] sm:tracking-[0.1em] lg:text-[1.2rem]">
                            {{ $displayNumber }}
                        </p>

                        <div class="mt-4 grid grid-cols-2 gap-2 text-[11px] sm:gap-3 sm:text-xs">
                            <div>
                                <p class="text-blue-100">CVV</p>
                                <p class="mt-1 font-semibold text-white">{{ $card->cvv ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-blue-100">Expiration Date</p>
                                <p class="mt-1 font-semibold text-white">{{ $displayExpiry }}</p>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-blue-100">Balance</p>
                                    <button id="reloadBalanceBtn" type="button"
                                        class="rounded-full border border-white/40 bg-white/15 px-1.5 py-0.5 text-[10px] font-bold text-white transition hover:bg-white/25"
                                        title="Reload balance" aria-label="Reload balance">
                                        ↻
                                    </button>
                                </div>
                                <p id="balanceValue"
                                    class="card-digits mt-1 text-[1.6rem] font-bold leading-none tracking-tight text-white sm:text-[1.9rem]">
                                    ${{ number_format((float) ($card->cardBalance ?? 0), 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-blue-100">Card Type</p>
                                <p class="mt-1 font-semibold text-white">{{ ucfirst((string) ($card->type ?? '—')) }}
                                </p>
                            </div>
                        </div>

                        <p class="mt-4 text-right text-xl font-extrabold tracking-wide sm:mt-5 sm:text-2xl">{{
                            $organization !== '' ? $organization : 'CARD' }}</p>
                    </div>

                    <div class="space-y-2 p-4">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Summary</p>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="text-slate-500">Total spent</span>
                            <span class="font-semibold text-slate-900">
                                ${{ is_numeric($card->totalConsume) ? number_format((float) $card->totalConsume, 2) :
                                ($card->totalConsume ?? '0.00') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="text-slate-500">Holder email</span>
                            <span class="font-medium text-slate-900 truncate max-w-[11rem]"
                                title="{{ $card->email }}">{{ $card->email ?? '—' }}</span>
                        </div>
                        <div class="pt-1">
                            <span
                                class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold {{ $statusChipClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lg:col-span-8 space-y-4">


                <div class="rounded-xl border border-blue-100 bg-blue-50 px-3 py-3 sm:px-4">
                    <p class="text-sm font-semibold text-slate-800">Things to keep in mind</p>


                    <ul class="mt-2 list-disc space-y-1 pl-4 text-[11px] text-slate-600 sm:pl-5 sm:text-xs">
                        <li><span class="font-semibold">Shared access:</span> Anyone with this link can view card
                            details and recent activity.</li>
                        <li><span class="font-semibold">Card safety:</span> Only share this page with recipients you
                            trust.</li>
                        <li><span class="font-semibold">Status aware:</span> Card usage depends on current card status
                            and merchant acceptance.</li>
                        <li><span class="font-semibold">Data freshness:</span> Use the reload icon near balance to
                            refresh the latest values.</li>
                        <li><span class="font-semibold">Applicable platforms:</span> Google Wallet, Facebook, Amazon,
                            GoDaddy, OpenAI, Twitter, Shopify, TikTok, Starlink, and other supported merchants.</li>
                        <li><span class="font-semibold">Verification support:</span> 3DS and AVS verification are
                            supported where required by the merchant.</li>
                        <li><span class="font-semibold">Formal use policy:</span> For formal use only. Strictly control
                            both the chargeback rate and consumer refund rate.</li>
                        <li><span class="font-semibold">Annual transaction limit:</span> Up to $1,000,000 total
                            transaction volume per year.</li>
                        <li><span class="font-semibold">Card validity:</span> Valid for 3 years from activation.</li>
                        <li><span class="font-semibold">Risk control reminder:</span> This card BIN prohibits malicious
                            chargebacks. Multiple chargebacks or repeated payment failures may trigger risk control,
                            including penalties or card cancellation.</li>
                        <li><span class="font-semibold">Subscription reminder:</span> If you subscribed to any services,
                            log in to the merchant account and complete unbinding or cancellation to avoid future
                            charges.</li>
                        <li><span class="font-semibold">Non-payment fee:</span> The first 3 failed transactions each
                            month are exempt. From the 4th failed transaction, a chargeback fee of $0.30 is deducted per
                            failed transaction. If a chargeback causes the balance to drop below $1, the card is
                            automatically deleted.</li>
                        <li><span class="font-semibold">Cancellation fee:</span> A 2% authorization reversal fee is
                            charged per transaction and deducted from the card balance.</li>
                        <li><span class="font-semibold">Refund fee:</span> A 10% refund fee per purchase is deducted
                            from the card.</li>
                        <li><span class="font-semibold">Cross-border transaction fees:</span> Not applicable.</li>
                        <li><span class="font-semibold">Monthly service fee:</span> Not applicable.</li>



                    </ul>
                </div>



                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-3 py-3 sm:px-4">
                        <h2 class="text-sm font-semibold text-slate-800">Recent transactions</h2>
                        <span class="text-xs text-slate-500">{{ $transactions->count() }} shown</span>
                    </div>

                    @if ($transactions->isEmpty())
                    <div class="px-5 py-12 text-center text-sm text-slate-500">
                        No transactions recorded for this card yet.
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-[720px] text-left text-xs sm:min-w-full sm:text-sm">
                            <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                                <tr>
                                    <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Date</th>
                                    <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Merchant</th>
                                    <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Type</th>
                                    <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3 text-right">Amount</th>
                                    <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach ($transactions as $tx)
                                @php
                                $dt = null;
                                if ($tx->recordTime) {
                                $raw = $tx->recordTime;
                                $asInt = (int) $raw;
                                if ((string) $asInt === (string) $raw && strlen((string) $asInt) >= 12) {
                                $dt = \Carbon\Carbon::createFromTimestamp($asInt / 1000);
                                } else {
                                $dt = \Carbon\Carbon::parse($raw);
                                }
                                }

                                $dateStr = $dt && $dt->isValid() ? $dt->format('d M Y, H:i') : '—';
                                $amount = is_numeric($tx->amount) ? (float) $tx->amount : 0;
                                $txStatus = trim((string) ($tx->status ?? 'Unknown'));
                                $txStatusClass = match (strtolower($txStatus)) {
                                'complete', 'completed', 'success', 'successful', 'refunded' => 'bg-emerald-100
                                text-emerald-700',
                                'failed', 'declined', 'error' => 'bg-rose-100 text-rose-700',
                                'pending', 'processing' => 'bg-amber-100 text-amber-700',
                                default => 'bg-slate-100 text-slate-700',
                                };
                                @endphp
                                <tr>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3 whitespace-nowrap">{{ $dateStr }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">{{ $tx->merchantName ?? '—' }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">{{ $tx->type ?? '—' }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3 text-right card-digits">${{
                                        number_format(abs($amount), 2) }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $txStatusClass }}">{{
                                            $txStatus }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </main>

    <footer class="mt-8 border-t border-slate-200 bg-white">
        <div
            class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-5 text-[10px] text-slate-500 md:flex-row md:items-end md:justify-between">
            <div class="space-y-0.5">
                <p>{{ config('app.name', 'Lanocard') }}</p>
                <p>{{ 'support@lanocard.com' }}</p>
            </div>
            <div class="space-y-0.5 md:text-right">
                <p>&copy; {{ now()->year }} {{ config('app.name', 'Lanocard') }}</p>
                <p>Shared virtual card details page</p>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var reloadBtn = document.getElementById('reloadBalanceBtn');
            var balanceValue = document.getElementById('balanceValue');
            if (!reloadBtn) return;

            var updateBalanceUrl = @json(route('update_balance', ['id' => $card->id]));

            reloadBtn.addEventListener('click', async function () {
                if (reloadBtn.dataset.loading === '1') return;

                reloadBtn.dataset.loading = '1';
                reloadBtn.setAttribute('aria-busy', 'true');
                reloadBtn.textContent = '...';

                try {
                    var response = await fetch(updateBalanceUrl, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    var data = await response.json();

                    if (!response.ok || !data || data.success !== true || !data.card) {
                        throw new Error((data && (data.message || data.status)) || 'Failed to update balance.');
                    }

                    if (balanceValue) {
                        balanceValue.textContent = '$' + data.card.cardBalance;
                    }
                } catch (error) {
                    console.error('Balance update failed:', error);
                    alert(error.message || 'Could not update balance right now.');
                } finally {
                    reloadBtn.dataset.loading = '0';
                    reloadBtn.setAttribute('aria-busy', 'false');
                    reloadBtn.textContent = '↻';
                }
            });
        })();
    </script>
</body>

</html>