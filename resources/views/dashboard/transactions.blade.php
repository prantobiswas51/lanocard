<x-app-layout>

    <section id="viewTransactions" class="flex-1 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">

            <!-- Header -->
            <div
                class="bg-gradient-to-br from-emerald-50 via-white to-sky-50 dark:from-slate-800 dark:via-slate-800 dark:to-slate-800 border border-emerald-100 dark:border-emerald-900/40 rounded-2xl p-5 flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                        Transactions
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        View and manage your transaction history
                    </p>
                </div>

                <div
                    class="h-10 w-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m4 0h1M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                    </svg>
                </div>
            </div>


            <!-- Transactions table -->
            <div
                class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">

                <!-- Table header -->
                <div
                    class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 font-semibold">
                        Recent transactions
                    </p>
                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead
                            class="bg-slate-50 dark:bg-slate-700/50 text-[11px] uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3 text-left">Merchant</th>
                                <th class="px-5 py-3 text-left">Date</th>
                                <th class="px-5 py-3 text-left">Amount</th>
                                <th class="px-5 py-3 text-left">Status</th>
                                <th class="px-5 py-3 text-left">Transaction ID</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">

                            @if($transactions->isEmpty())

                            <tr>
                                <td colspan="5" class="py-10 text-center">

                                    <div class="flex flex-col items-center gap-3">

                                        <div
                                            class="h-12 w-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 14l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>

                                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                            No transactions found
                                        </p>

                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            Your recent transactions will appear here.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                            @else

                            @foreach ($transactions as $transaction)

                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">

                                <!-- Merchant -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="h-9 w-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-xs font-semibold text-emerald-600">
                                            {{ strtoupper(substr($transaction->merchantName,0,1)) }}
                                        </div>

                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-slate-200 text-sm">
                                                {{ $transaction->merchantName }}
                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $transaction->type }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400 text-xs">
                                    {{ \Carbon\Carbon::parse($transaction->recordTime)->format('Y-m-d h:i A') }}
                                </td>

                                <!-- Amount -->
                                <td class="px-5 py-4 font-semibold text-slate-900 dark:text-slate-200">
                                    ${{ number_format($transaction->amount, 2) }}
                                </td>

                                <!-- Status -->
                                <td class="px-5 py-4">

                                    @if($transaction->status == 'Finish')

                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-0.5 text-[11px] font-medium text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Completed
                                    </span>

                                    @else

                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-50 dark:bg-red-900/30 px-2.5 py-0.5 text-[11px] font-medium text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        {{ $transaction->status }}
                                    </span>

                                    @endif

                                </td>

                                <!-- Transaction ID -->
                                <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400 font-mono">
                                    {{ $transaction->vcc_id }}
                                </td>

                            </tr>

                            @endforeach

                            {{-- pagination --}}
                            <tr>
                                <td colspan="5" class="px-5 py-4">
                                    {{ $transactions->links() }}
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>

</x-app-layout>