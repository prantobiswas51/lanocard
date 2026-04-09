<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lano Gift Card</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
        <span class="hidden text-[11px] text-slate-500 sm:inline">Rewards Card</span>
      </div>
    </div>
  </header>
  <main class="mx-auto w-full max-w-6xl flex-1 px-3 py-5 sm:px-4 sm:py-8">
    <div class="grid gap-6 lg:grid-cols-12">
      <section class="lg:col-span-4">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <div class="relative bg-gradient-to-br from-blue-700 via-indigo-600 to-cyan-500 p-4 text-white sm:p-5">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_45%)]"></div>
            <div class="mb-4 flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-blue-100">
              <span>Lano Virtual Card</span>
              <span class="rounded-full bg-white/20 px-2.5 py-1">Active</span>
            </div>
            <p class="text-sm font-medium text-blue-100">Mahim Khan</p>
            <p class="card-digits mt-2 whitespace-nowrap text-[0.98rem] font-semibold leading-tight tracking-[0.08em] sm:text-[1.12rem] sm:tracking-[0.1em] lg:text-[1.2rem]">4403 9303 2452 1544</p>
            <div class="mt-4 grid grid-cols-2 gap-2 text-[11px] sm:gap-3 sm:text-xs">
              <div>
                <p class="text-blue-100">CVV</p>
                <p class="mt-1 font-semibold text-white">363</p>
              </div>
              <div>
                <p class="text-blue-100">Expiration Date</p>
                <p class="mt-1 font-semibold text-white">06/25</p>
              </div>
              <div>
                <div class="flex items-center gap-2">
                  <p class="text-blue-100">Balance</p>
                  <button
                    id="reloadBalanceBtn"
                    type="button"
                    class="rounded-full border border-white/40 bg-white/15 px-1.5 py-0.5 text-[10px] font-bold text-white transition hover:bg-white/25"
                    title="Reload balance"
                    aria-label="Reload balance"
                  >
                    ↻
                  </button>
                </div>
                <p id="balanceValue" class="card-digits mt-1 text-[1.6rem] font-bold leading-none tracking-tight text-white sm:text-[1.9rem]">$0.28</p>
              </div>
              <div>
                <p class="text-blue-100">Card Type</p>
                <p class="mt-1 font-semibold text-white">Visa Reloadable</p>
              </div>
            </div>
            <p class="mt-4 text-right text-xl font-extrabold italic tracking-wide sm:mt-5 sm:text-2xl">VISA</p>
          </div>
          <div class="space-y-1 p-4">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Billing Address</p>
            <p class="text-sm text-slate-700">Use your own address if prompted</p>
          </div>
        </div>
      </section>

      <section class="lg:col-span-8 space-y-4">
        <div class="rounded-xl border border-blue-100 bg-blue-50 px-3 py-3 sm:px-4">
          <p class="text-sm font-semibold text-slate-800">Things to keep in mind</p>
          <ul class="mt-2 list-disc space-y-1 pl-4 text-[11px] text-slate-600 sm:pl-5 sm:text-xs">
            <li><span class="font-semibold">Applicable platforms:</span> Google Wallet, Facebook, Amazon, GoDaddy, OpenAI, Twitter, Shopify, TikTok, Starlink, and other supported merchants.</li>
            <li><span class="font-semibold">Verification support:</span> 3DS and AVS verification are supported where required by the merchant.</li>
            <li><span class="font-semibold">Formal use policy:</span> For formal use only. Strictly control both the chargeback rate and consumer refund rate.</li>
            <li><span class="font-semibold">Annual transaction limit:</span> Up to $1,000,000 total transaction volume per year.</li>
            <li><span class="font-semibold">Card validity:</span> Valid for 3 years from activation.</li>
            <li><span class="font-semibold">Risk control reminder:</span> This card BIN prohibits malicious chargebacks. Multiple chargebacks or repeated payment failures may trigger risk control, including penalties or card cancellation.</li>
            <li><span class="font-semibold">Subscription reminder:</span> If you subscribed to any services, log in to the merchant account and complete unbinding or cancellation to avoid future charges.</li>
            <li><span class="font-semibold">Non-payment fee:</span> The first 3 failed transactions each month are exempt. From the 4th failed transaction, a chargeback fee of $0.30 is deducted per failed transaction. If a chargeback causes the balance to drop below $1, the card is automatically deleted.</li>
            <li><span class="font-semibold">Cancellation fee:</span> A 2% authorization reversal fee is charged per transaction and deducted from the card balance.</li>
            <li><span class="font-semibold">Refund fee:</span> A 10% refund fee per purchase is deducted from the card.</li>
            <li><span class="font-semibold">Cross-border transaction fees:</span> Not applicable.</li>
            <li><span class="font-semibold">Monthly service fee:</span> Not applicable.</li>
          </ul>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
          <div class="flex items-center justify-between border-b border-slate-200 px-3 py-3 sm:px-4">
            <h2 class="text-sm font-semibold text-slate-800">Recent transactions</h2>
            <span class="text-xs text-slate-500">10 shown</span>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-[720px] text-left text-xs sm:min-w-full sm:text-sm">
              <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                <tr>
                  <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Date</th>
                  <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Merchant</th>
                  <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Amount</th>
                  <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Balance</th>
                  <th class="px-3 py-2.5 font-semibold sm:px-4 sm:py-3">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-slate-700">
                <tr>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">Apr 17</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">BULLDOG YOGA ONLINE</td>
                  <td class="px-3 py-2.5 font-medium sm:px-4 sm:py-3">-$6.99</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">$0.60</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3"><span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-medium text-rose-700">Failed</span></td>
                </tr>
                <tr>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">Apr 10</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">BULLDOG YOGA ONLINE</td>
                  <td class="px-3 py-2.5 font-medium sm:px-4 sm:py-3">-$6.99</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">$0.60</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3"><span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-medium text-rose-700">Failed</span></td>
                </tr>
                <tr>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">Apr 05</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">SHOPIFY*3511512852</td>
                  <td class="px-3 py-2.5 font-medium sm:px-4 sm:py-3">-$5.00</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">$0.60</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3"><span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-medium text-rose-700">Failed</span></td>
                </tr>
                <tr>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">Jan 30</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">MEDIA365 LIMITED</td>
                  <td class="px-3 py-2.5 font-medium sm:px-4 sm:py-3">-$0.44</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">$0.60</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Refunded</span></td>
                </tr>
                <tr>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">Jan 26</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">MEDIA365 LIMITED</td>
                  <td class="px-3 py-2.5 font-medium sm:px-4 sm:py-3">-$0.44</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3">$1.16</td>
                  <td class="px-3 py-2.5 sm:px-4 sm:py-3"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Complete</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </main>
  <footer class="mt-8 border-t border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-5 text-[10px] text-slate-500 md:flex-row md:items-end md:justify-between">
      <div class="space-y-0.5">
        <p>FAQs</p>
        <p>help@lanogiftcard.com</p>
        <p>Reward ID: VGIRAM1TCX04</p>
      </div>
      <div class="space-y-0.5">
        <p>Privacy</p>
        <p>Terms &amp; Conditions</p>
      </div>
      <div class="space-y-0.5 md:text-right">
        <p>&copy; 2026 Tremendous</p>
        <p>The Tremendous Rewards Visa Incentive Card is issued by Sutton Bank.</p>
        <p>Visa is a registered trademark of Visa, U.S.A. Inc.</p>
      </div>
    </div>
    <div class="mx-auto flex max-w-6xl justify-start px-4 pb-4 md:justify-end">
      <button type="button" class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm">
        Need help?
      </button>
    </div>
  </footer>
  <script>
    (function () {
      var reloadBtn = document.getElementById("reloadBalanceBtn");
      if (!reloadBtn) return;

      reloadBtn.addEventListener("click", function () {
        window.location.reload();
      });
    })();
  </script>
</body>
</html>