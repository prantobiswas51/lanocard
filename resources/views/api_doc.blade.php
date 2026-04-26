<x-guest-layout>
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-12">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">API Documentation DEMO PAGE</h1>
        <p class="text-slate-600 mb-8">Integrate virtual card creation and management into your application. API access
            requires a paid plan.</p>

        <div class="space-y-8">
            <section>
                <h2 class="text-xl font-semibold text-slate-900 mb-3">Base URL</h2>
                <pre
                    class="rounded-xl bg-slate-800 text-slate-100 px-4 py-3 text-sm overflow-x-auto"><code>https://api.virtualpay.example.com/v1</code></pre>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-slate-900 mb-3">Authentication</h2>
                <p class="text-slate-600 text-sm mb-3">Include your API key in the request header:</p>
                <pre
                    class="rounded-xl bg-slate-800 text-slate-100 px-4 py-3 text-sm overflow-x-auto"><code>Authorization: Bearer YOUR_API_KEY</code></pre>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-slate-900 mb-3">Endpoints</h2>
                <div class="rounded-xl border border-slate-200 bg-white overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-4 py-3 font-medium text-slate-700">Method</th>
                                <th class="text-left px-4 py-3 font-medium text-slate-700">Endpoint</th>
                                <th class="text-left px-4 py-3 font-medium text-slate-700">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-4 py-3 font-mono text-emerald-600">GET</td>
                                <td class="px-4 py-3 font-mono">/cards</td>
                                <td class="px-4 py-3 text-slate-600">List your cards</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-mono text-blue-600">POST</td>
                                <td class="px-4 py-3 font-mono">/cards</td>
                                <td class="px-4 py-3 text-slate-600">Create a card</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-mono text-emerald-600">GET</td>
                                <td class="px-4 py-3 font-mono">/cards/:id</td>
                                <td class="px-4 py-3 text-slate-600">Get card details</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-mono text-amber-600">PATCH</td>
                                <td class="px-4 py-3 font-mono">/cards/:id</td>
                                <td class="px-4 py-3 text-slate-600">Freeze / unfreeze</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-mono text-blue-600">POST</td>
                                <td class="px-4 py-3 font-mono">/cards/:id/topup</td>
                                <td class="px-4 py-3 text-slate-600">Top-up card</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-slate-900 mb-3">Example: Create card</h2>
                <pre class="rounded-xl bg-slate-800 text-slate-100 px-4 py-3 text-sm overflow-x-auto"><code>curl -X POST https://api.virtualpay.example.com/v1/cards \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"type":"onetime","bin":"537100","amount":50}'</code></pre>
            </section>
        </div>

        <p class="mt-8 text-sm text-slate-500">For full API access, subscribe to the API plan from <a
                href="pricing.html" class="text-emerald-600 hover:underline">Pricing</a> or your user panel.</p>
    </main>
</x-guest-layout>