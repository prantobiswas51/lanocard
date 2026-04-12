<x-guest-layout>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
        <section class="max-w-4xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">Pricing &amp; fees</h1>
            <p class="text-lg text-slate-600">Transparent costs for LanoCard virtual cards. One-time and reloadable card
                fees, top-up fee, and API plans. No hidden charges.</p>
        </section>
        <!-- Fees table -->
        <section class="max-w-4xl mx-auto" id="api">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Fee table</h2>
            <p class="text-slate-600 mb-6">Card and transaction fees. API plan users get reduced card creation and
                top‑up fees.</p>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Fee table</h2>

            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold text-slate-800">Fee type</th>
                                <th class="text-left px-4 py-3 font-semibold text-slate-800">Amount / rule</th>
                                <th class="text-left px-4 py-3 font-semibold text-slate-800">Note</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">One-time card issue fee</td>
                                <td class="px-4 py-3 text-slate-700">$3 per card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">Charged when you create a one-time card.
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Reloadable card cost</td>
                                <td class="px-4 py-3 text-slate-700">$5 per card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">Charged when you create a reloadable card.
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Card top-up fee</td>
                                <td class="px-4 py-3 text-slate-700">10% of top-up amount, deducted from main balance.
                                </td>
                                <td class="px-4 py-3 text-slate-600 text-xs">When you add balance from main balance to a
                                    card.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Non-payment fee</td>
                                <td class="px-4 py-3 text-slate-700">First 3 failed transactions in the month are free;
                                    from the 4th, $0.30 per chargeback (per card).</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">If the card balance is overdrawn due to
                                    non-payment, the system will delete the card.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Cancellation fee</td>
                                <td class="px-4 py-3 text-slate-700">$1 per authorization cancellation, deducted from
                                    the card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">Verification authorization revocation: fee
                                    waiver applies.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Refund fee</td>
                                <td class="px-4 py-3 text-slate-700">2% of purchase amount per refund, deducted from the
                                    card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">—</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Cross-border transaction fee</td>
                                <td class="px-4 py-3 text-slate-700">1.5% of transaction, deducted from the card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">Applies to non-US merchant and/or non-USD
                                    currency transactions.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">Transaction verification fee</td>
                                <td class="px-4 py-3 text-slate-700">Domestic (US): $0.10 per binding verification;
                                    International: $0.50 per binding verification, deducted from the card.</td>
                                <td class="px-4 py-3 text-slate-600 text-xs">—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- API plan: reduced fees -->
            <div class="mt-10 rounded-2xl border-2 border-violet-200 bg-violet-50/50 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">API plan: lower card fees</h3>
                <p class="text-slate-600 text-sm mb-4">If you purchase API access, you get reduced fees on card creation
                    and top‑up so you can offer better rates or build your own business on top.</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-slate-200">
                            <tr>
                                <th class="text-left py-2 font-medium text-slate-700">Item</th>
                                <th class="text-left py-2 font-medium text-slate-700">Standard</th>
                                <th class="text-left py-2 font-medium text-emerald-700">With API plan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <tr>
                                <td class="py-2 font-medium text-slate-800">Card creation (e.g. $10 card)</td>
                                <td class="py-2">$10</td>
                                <td class="py-2 text-emerald-700 font-medium">$5</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium text-slate-800">Top-up fee</td>
                                <td class="py-2">10%</td>
                                <td class="py-2 text-emerald-700 font-medium">5%</td>
                            </tr>
                            <tr>
                                <td class="py-2 font-medium text-slate-800">Other transaction fees</td>
                                <td class="py-2">As in table above</td>
                                <td class="py-2 text-emerald-700 font-medium">Same or reduced (see terms)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-xs text-slate-500">Exact API benefits may vary. Check your dashboard after
                    purchasing API access.</p>
            </div>
        </section>

        <p class="mt-12 text-center text-sm text-slate-500">All plans include Privacy Policy and Terms compliance. Fees
            are deducted from card or balance as stated.</p>
    </main>


</x-guest-layout>