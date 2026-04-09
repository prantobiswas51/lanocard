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
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Lanocard</title>
</head>
<body>

    <div class="text-2xl text-center font-bold text-slate-900 pt-10 ">Gift Card</div>

    <div class="max-w-3xl mx-auto px-4 py-10 sm:py-14">
        <div class="mb-8 text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Shared card</p>
            <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">Virtual card details</h1>
            <p class="text-sm text-slate-600 max-w-xl mx-auto">
                This read-only page was shared with you. Do not share this link if you are not the intended recipient.
            </p>
        </div>

        <div
            class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden mb-8">
            <div
                class="relative px-6 py-6 sm:px-8 sm:py-8 text-white min-h-[200px]
                @if (strtoupper((string) $card->organization) === 'VISA')
                    bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-500
                @elseif (strtoupper((string) $card->organization) === 'MASTERCARD')
                    bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900
                @else
                    bg-gradient-to-br from-slate-800 to-slate-900
                @endif">
                <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/70">Virtual card</p>
                <p class="mt-4 text-lg sm:text-xl font-semibold tabular-nums tracking-[0.12em]">
                    {{ $displayNumber }}
                </p>

                <div class="mt-6 flex flex-wrap gap-6 text-[11px] uppercase tracking-[0.12em] text-white/65">
                    <div>
                        <p class="text-white/55">Balance</p>
                        <p class="mt-1 text-sm font-semibold tabular-nums text-white">${{ number_format((float) ($card->cardBalance ?? 0), 2) }}</p>
                        <div class="">Add reload button</div>
                    </div>
                    <div>
                        <p class="text-white/55">Expiry</p>
                        <p class="mt-1 text-sm font-medium text-white/95 tabular-nums">{{ $displayExpiry }}</p>
                    </div>
                    <div>
                        <p class="text-white/55">Type</p>
                        <p class="mt-1 text-sm font-medium text-white/95">{{ ucfirst((string) $card->type) }}</p>
                    </div>
                    <div>
                        <p class="text-white/55">CVV</p>
                        <p class="mt-1 text-sm font-medium text-white/95">{{ $card->cvv ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2 text-[11px]">
                    <span
                        class="inline-flex items-center rounded-full border border-white/25 bg-white/10 px-2.5 py-0.5">{{ $card->organization ?? '—' }}</span>
                    <span
                        class="inline-flex items-center rounded-full border border-white/25 bg-white/10 px-2.5 py-0.5">{{ $statusLabel }}</span>
                </div>
            </div>

            <div class="px-6 py-5 sm:px-8 border-t border-slate-100 bg-slate-50/80">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Summary</p>
                <dl class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2 sm:border-0 sm:pb-0">
                        <dt class="text-slate-500">Total spent</dt>
                        <dd class="font-medium text-slate-900 tabular-nums">
                            ${{ is_numeric($card->totalConsume) ? number_format((float) $card->totalConsume, 2) : ($card->totalConsume ?? '0.00') }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4 border-b border-slate-200/80 pb-2 sm:border-0 sm:pb-0">
                        <dt class="text-slate-500">Holder email</dt>
                        <dd class="font-medium text-slate-900 truncate max-w-[12rem]" title="{{ $card->email }}">
                            {{ $card->email ?? '—' }}
                        </dd>
                    </div>
                </dl>
                <p class="mt-4 text-[11px] text-slate-500">
                    Anyone with this link can see these card details—share it only with people you trust. Card security code (CVV) is not shown here.
                </p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-2">
                <h2 class="text-sm font-semibold text-slate-900">Recent transactions</h2>
                <span class="text-xs text-slate-500">{{ $transactions->count() }} shown</span>
            </div>
            @if ($transactions->isEmpty())
                <div class="px-5 py-12 text-center text-sm text-slate-500">
                    No transactions recorded for this card yet.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-medium text-slate-600 uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3">Date</th>
                                <th class="px-5 py-3">Merchant</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3 text-right">Amount</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
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
                                @endphp
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-5 py-3 text-slate-600 whitespace-nowrap">{{ $dateStr }}</td>
                                    <td class="px-5 py-3 text-slate-900">{{ $tx->merchantName ?? '—' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $tx->type ?? '—' }}</td>
                                    <td class="px-5 py-3 text-right font-medium tabular-nums text-slate-900">
                                        ${{ number_format(abs($amount), 2) }}
                                    </td>
                                    <td class="px-5 py-3 text-slate-600">{{ $tx->status ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <p class="mt-10 text-center text-xs text-slate-400">
            {{ config('app.name', 'Lanocard') }}
        </p>
    </div>
</body>
</html>

