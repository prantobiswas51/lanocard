<x-app-layout>

    <section id="viewDashboard" class="flex-1 w-full ">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">

            <!-- welcome back Top cards / stats -->
            <div class="grid md:grid-cols-3 gap-4">
                <div
                    class="col-span-2 bg-gradient-to-br from-emerald-50 via-white to-sky-50 dark:from-slate-800 dark:via-slate-800 dark:to-slate-800 border border-emerald-100 dark:border-emerald-900/50 rounded-2xl p-4 sm:p-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 overflow-hidden relative">
                    <div
                        class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-emerald-200/60 dark:bg-emerald-500/20 blur-3xl pointer-events-none">
                    </div>
                    <div>
                        <p
                            class="text-xs uppercase tracking-[0.2em] text-emerald-500 dark:text-emerald-400 font-semibold mb-1">
                            Welcome back</p>
                        <h2 class="text-lg sm:text-xl font-semibold mb-1 text-slate-900 dark:text-slate-100">Manage your
                            virtual cards</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-md">
                            Create one‑time and reloadable virtual cards for secure online payments.
                            Instantly freeze, unfreeze or top‑up from your main balance.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div
                            class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white/80 dark:bg-slate-700/50 px-3 py-2.5 shadow-sm">
                            <p
                                class="text-[11px] uppercase tracking-[0.18em] text-emerald-500 dark:text-emerald-400 font-semibold">
                                Active cards</p>
                            <p class="mt-1 text-base font-semibold text-emerald-700 dark:text-emerald-400"><span
                                    id="activeCardCount">{{ $myActiveCards->count() }}</span></p>
                        </div>
                        <div
                            class="rounded-xl border border-slate-200 dark:border-slate-600 bg-white/80 dark:bg-slate-700/50 px-3 py-2.5 shadow-sm">
                            <p
                                class="text-[11px] uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 font-semibold">
                                Spent this month</p>
                            <p class="mt-1 text-base font-semibold text-slate-800 dark:text-slate-200">${{
                                number_format($amountSpentThisMonth, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-xs space-y-3 shadow-sm">
                    <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 font-semibold">
                        Quick summary</p>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400">One‑time cards</span>
                        <span class="font-semibold text-slate-900 dark:text-slate-200">{{ $oneTimeCardsCount }}
                            active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400">Reloadable cards</span>
                        <span class="font-semibold text-slate-900 dark:text-slate-200">{{ $reloadableCardsCount }}
                            active</span>
                    </div>
                    <div
                        class="h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-600 to-transparent my-1">
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400">Last transaction</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            ${{ number_format($lastTransactionAmount, 2) }} · {{
                            optional($lastTransactionTime)->diffForHumans() ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Purchase + Card list -->
            <div class="grid lg:grid-cols-2 gap-5 items-start">
                <!-- Purchase panel -->

                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm">

                    <!-- Tabs -->
                    <div class="flex bg-slate-50/80 dark:bg-slate-700/50">
                        <button id="tabOnetime"
                            class="flex-1 px-4 py-3 text-xs sm:text-sm font-medium border-b-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-white dark:bg-slate-800">
                            One-time Card
                        </button>

                        <button id="tabReloadable"
                            class="flex-1 px-4 py-3 text-xs sm:text-sm font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            Reloadable Card
                        </button>
                    </div>


                    <!-- ===================== -->
                    <!-- ONETIME CARD PANEL -->
                    <!-- ===================== -->
                    <form id="panelOnetime" class="p-4 sm:p-5 space-y-4 text-sm" method="POST"
                        action="{{ route('open_card') }}">
                        @csrf
                        <input type="hidden" name="type" id="onetimeType" value="onetime">
                        <input type="hidden" name="bin" id="onetimeBin" value="">

                        <div class="space-y-2">
                            <label class="text-xs font-medium text-slate-800 dark:text-slate-300">
                                Choose card BIN
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($bins->where('bin', '!=', '45492416') as $bin)
                                <button type="button" data-onetime-card="classic" data-onetime-bin="{{ $bin->bin }}"
                                    class="card-option-onetime group relative rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 via-white to-emerald-50 dark:from-emerald-900/20 dark:via-slate-800 dark:to-emerald-900/20 p-3 text-left shadow-sm">

                                    <p class="text-xs font-semibold text-slate-900 dark:text-slate-200 mb-1.5">
                                        {{ $bin->organization }}
                                    </p>

                                    <p class="text-[11px] text-slate-600 dark:text-slate-400 font-mono">
                                        BIN: {{ $bin->bin }}
                                    </p>

                                </button>
                                @endforeach
                            </div>
                        </div>


                        <div class="grid sm:grid-cols-2 gap-3">

                            <!-- Amount -->
                            <div class="space-y-1.5">

                                <label class="text-xs font-medium text-slate-800">
                                    Custom amount (USD)
                                </label>

                                <div
                                    class="flex items-center rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-2">
                                    <span class="text-slate-400 text-xs">$</span>

                                    <input id="onetimeAmount" name="amount" type="number" min="10" step="1"
                                        placeholder="Min $10" required
                                        class="w-full bg-transparent border-none text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none" />
                                </div>

                                <div class="flex gap-2 flex-wrap">

                                    <button type="button"
                                        class="quick-amount-onetime px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        10
                                    </button>

                                    <button type="button"
                                        class="quick-amount-onetime px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        50
                                    </button>

                                    <button type="button"
                                        class="quick-amount-onetime px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        100
                                    </button>

                                </div>

                            </div>


                            <!-- Summary -->
                            <div class="space-y-1.5">

                                <label class="text-xs font-medium text-slate-800 dark:text-slate-300">
                                    Summary
                                </label>

                                <div
                                    class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-xs space-y-1.5">

                                    <div class="flex justify-between">
                                        <span>Card type</span>
                                        <span class="font-medium">One-time</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Card BIN</span>
                                        <span id="onetimeSummaryBin" class="font-mono">000000</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Load amount</span>
                                        <span id="onetimeSummaryAmount">$0.00</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Processing charge</span>
                                        <span id="onetimeSummaryFee">$0.00</span>
                                    </div>

                                    <div class="flex justify-between border-t pt-1">
                                        <span>Total to pay</span>
                                        <span id="onetimeSummaryTotal" class="font-semibold">$0.00</span>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <!-- Email -->
                        <div class="space-y-1.5">

                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-medium text-slate-800 dark:text-slate-300">Card
                                        holder</label>
                                    <input name="card_holder" type="text" required placeholder="John Doe"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:ring-emerald-500" />
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-medium text-slate-800 dark:text-slate-300">Remark
                                        (optional)</label>
                                    <input name="remark" type="text" maxlength="50" placeholder="Optional note"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:ring-emerald-500" />
                                </div>
                            </div>


                            <p class="text-[11px] text-slate-500">
                                OTP will be sent to this email during payment verification.
                            </p>

                        </div>


                        <div class="pt-2 flex justify-end">
                            <button id="btnOrderOnetime" type="submit"
                                class="rounded-full bg-emerald-500 px-4 py-2.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                Order one-time card
                            </button>
                        </div>

                    </form>



                    <!-- ===================== -->
                    <!-- RELOADABLE PANEL -->
                    <!-- ===================== -->
                    <form id="panelReloadable" class="p-4 sm:p-5 space-y-4 text-sm hidden" method="POST"
                        action="{{ route('open_card') }}">
                        @csrf
                        <input type="hidden" name="type" id="reloadType" value="reloadable">
                        <input type="hidden" name="bin" id="reloadBin" value="">

                        <div class="space-y-2">
                            <label class="text-xs font-medium text-slate-800 dark:text-slate-300">
                                Choose card BIN
                            </label>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($bins->where('bin', '45492416') as $bin)
                                <button type="button" data-reload-card="classic" data-reload-bin="{{ $bin->bin }}"
                                    class="card-option-reload group relative rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 via-white to-emerald-50 dark:from-emerald-900/20 dark:via-slate-800 dark:to-emerald-900/20 p-3 text-left shadow-sm">

                                    <p class="text-xs font-semibold text-slate-900 dark:text-slate-200 mb-1.5">
                                        {{ $bin->organization }}
                                    </p>

                                    <p class="text-[11px] text-slate-600 dark:text-slate-400 font-mono">
                                        BIN: {{ $bin->bin }}
                                    </p>

                                </button>
                                @endforeach
                            </div>
                        </div>


                        <div class="grid sm:grid-cols-2 gap-3">

                            <div class="space-y-1.5">

                                <label class="text-xs font-medium text-slate-800">
                                    Custom amount (USD)
                                </label>

                                <div
                                    class="flex items-center rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-2">
                                    <span class="text-slate-400 text-xs">$</span>

                                    <input id="reloadAmount" name="amount" type="number" min="10" step="1"
                                        placeholder="Min $10" required
                                        class="w-full bg-transparent border-none text-sm text-slate-900 dark:text-slate-200 placeholder:text-slate-400 focus:outline-none" />
                                </div>

                                <div class="flex gap-2 flex-wrap">

                                    <button type="button"
                                        class="quick-amount-reload px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        10
                                    </button>

                                    <button type="button"
                                        class="quick-amount-reload px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        50
                                    </button>

                                    <button type="button"
                                        class="quick-amount-reload px-2.5 py-1.5 rounded-full text-[11px] border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700">
                                        100
                                    </button>

                                </div>

                            </div>


                            <div class="space-y-1.5">

                                <label class="text-xs font-medium text-slate-800 dark:text-slate-300">
                                    Summary
                                </label>

                                <div
                                    class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-xs space-y-1.5">

                                    <div class="flex justify-between">
                                        <span>Card type</span>
                                        <span class="font-medium">Reloadable</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Card BIN</span>
                                        <span id="reloadSummaryBin" class="font-mono">000000</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Load amount</span>
                                        <span id="reloadSummaryAmount">$0.00</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span>Processing charge</span>
                                        <span id="reloadSummaryFee">$0.00</span>
                                    </div>

                                    <div class="flex justify-between border-t pt-1">
                                        <span>Total to pay</span>
                                        <span id="reloadSummaryTotal" class="font-semibold">$0.00</span>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="space-y-1.5">

                            <label class="text-xs font-medium text-slate-800 dark:text-slate-300">
                                Email for 3D Secure OTP
                            </label>

                            <input id="reloadEmail" name="email" type="email" placeholder="email@example.com" required
                                class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:ring-emerald-500" />
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-medium text-slate-800 dark:text-slate-300">Card
                                        holder</label>
                                    <input name="card_holder" type="text" required placeholder="John Doe"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:ring-emerald-500" />
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-medium text-slate-800 dark:text-slate-300">Remark
                                        (optional)</label>
                                    <input name="remark" type="text" maxlength="50" placeholder="Optional note"
                                        class="w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:ring-emerald-500" />
                                </div>
                            </div>


                            <p class="text-[11px] text-slate-500">
                                OTP will be sent to this email during payment verification.
                            </p>

                        </div>


                        <div class="pt-2 flex justify-end">

                            <button id="btnOrderReload" type="submit"
                                class="rounded-full bg-emerald-500 px-4 py-2.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                Order reloadable card
                            </button>

                        </div>

                    </form>

                </div>


                <!-- user Card list / details -->
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 space-y-4 text-sm shadow-sm">

                    {{-- header --}}
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <p
                                class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 font-semibold">
                                Your virtual cards</p>
                            <h3 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Card list &amp; actions
                            </h3>
                        </div>
                        <div class="flex gap-1.5 text-[11px]">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-slate-50 dark:bg-slate-700 px-2 py-0.5 border border-slate-200 dark:border-slate-600 text-slate-500 dark:text-slate-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Frozen
                            </span>
                        </div>
                    </div>


                    <div id="cardList" class="space-y-3 max-h-72 overflow-y-auto pr-1">

                        @forelse($myCards as $card)

                        <!-- One-time card 1 -->
                        <div
                            class="card-row group rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-3 flex flex-col gap-2">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-9 w-14 rounded-lg bg-gradient-to-br from-emerald-400 to-cyan-400 flex items-center justify-center text-[10px] font-semibold text-white shadow-sm">
                                        {{ $card->type }}
                                    </div>
                                    <div class="space-y-0.5">
                                        <p class="text-xs font-semibold text-slate-900 dark:text-slate-200">{{
                                            ucfirst($card->type) }}</p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $card->hiddenNum }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">${{
                                    number_format($card->cardBalance, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                    <span>{{ $card->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('cards') }}">
                                    <button
                                        class="btn-view-details inline-flex items-center gap-1 rounded-full border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 px-2.5 py-1 text-[11px] text-slate-700 dark:text-slate-300 hover:border-emerald-400/80 dark:hover:border-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-400">
                                        Details
                                    </button>
                                </a>
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

                    <p class="text-[11px] text-slate-500">
                        Tip: You can freeze a card instantly if you see any suspicious transaction.
                        For reloadable cards you can also top‑up anytime from your main balance.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <script>
        const tabOnetime = document.getElementById('tabOnetime');
        const tabReloadable = document.getElementById('tabReloadable');
        const panelOnetime = document.getElementById('panelOnetime');
        const panelReloadable = document.getElementById('panelReloadable');

        function openOnetimeTab() {
            tabOnetime.classList.add('border-emerald-500', 'text-emerald-600', 'bg-white');
            tabReloadable.classList.remove('border-emerald-500', 'text-emerald-600', 'bg-white');
            tabReloadable.classList.add('text-slate-500');
            panelOnetime.classList.remove('hidden');
            panelReloadable.classList.add('hidden');
        }

        function openReloadableTab() {
            tabReloadable.classList.add('border-emerald-500', 'text-emerald-600', 'bg-white');
            tabOnetime.classList.remove('border-emerald-500', 'text-emerald-600', 'bg-white');
            tabOnetime.classList.add('text-slate-500');
            panelReloadable.classList.remove('hidden');
            panelOnetime.classList.add('hidden');
        }

        function setupBinSelection(buttonSelector, hiddenBinId, summaryBinId) {
            const binButtons = document.querySelectorAll(buttonSelector);
            const hiddenBin = document.getElementById(hiddenBinId);
            const summaryBin = document.getElementById(summaryBinId);

            if (!binButtons.length || !hiddenBin) {
                return;
            }

            const setActive = (button) => {
                binButtons.forEach((btn) => {
                    btn.classList.remove('border-emerald-500', 'ring-1', 'ring-emerald-400');
                });

                button.classList.add('border-emerald-500', 'ring-1', 'ring-emerald-400');

                const selectedBin = button.dataset.onetimeBin || button.dataset.reloadBin || '';
                hiddenBin.value = selectedBin;

                if (summaryBin) {
                    summaryBin.textContent = selectedBin || '000000';
                }
            };

            binButtons.forEach((button) => {
                button.addEventListener('click', () => setActive(button));
            });

            setActive(binButtons[0]);
        }

        function setupQuickAmounts(selector, inputId, summaryAmountId, summaryFeeId, summaryTotalId, flatCharge) {
            const input = document.getElementById(inputId);
            const summaryAmount = document.getElementById(summaryAmountId);
            const summaryFee = document.getElementById(summaryFeeId);
            const summaryTotal = document.getElementById(summaryTotalId);

            if (!input) {
                return;
            }

            const updateSummary = () => {
                const amount = Number(input.value || 0);
                const charge = amount > 0 ? flatCharge : 0;
                const total = amount + charge;

                if (summaryAmount) {
                    summaryAmount.textContent = `$${amount.toFixed(2)}`;
                }

                if (summaryFee) {
                    summaryFee.textContent = `$${charge.toFixed(2)}`;
                }

                if (summaryTotal) {
                    summaryTotal.textContent = `$${total.toFixed(2)}`;
                }
            };

            document.querySelectorAll(selector).forEach((button) => {
                button.addEventListener('click', () => {
                    input.value = button.textContent.trim();
                    updateSummary();
                });
            });

            input.addEventListener('input', updateSummary);
            updateSummary();
        }

        function setupMinAmountValidation(formId, amountInputId) {
            const form = document.getElementById(formId);
            const amountInput = document.getElementById(amountInputId);

            if (!form || !amountInput) {
                return;
            }

            form.addEventListener('submit', (event) => {
                const amount = Number(amountInput.value || 0);

                if (amount < 10) {
                    event.preventDefault();
                    amountInput.setCustomValidity('Minimum amount is $10.');
                    amountInput.reportValidity();
                    return;
                }

                amountInput.setCustomValidity('');
            });

            amountInput.addEventListener('input', () => amountInput.setCustomValidity(''));
        }

        if (tabOnetime && tabReloadable && panelOnetime && panelReloadable) {
            tabOnetime.addEventListener('click', openOnetimeTab);
            tabReloadable.addEventListener('click', openReloadableTab);

            setupBinSelection('.card-option-onetime', 'onetimeBin', 'onetimeSummaryBin');
            setupBinSelection('.card-option-reload', 'reloadBin', 'reloadSummaryBin');

            setupQuickAmounts('.quick-amount-onetime', 'onetimeAmount', 'onetimeSummaryAmount', 'onetimeSummaryFee', 'onetimeSummaryTotal', 3);
            setupQuickAmounts('.quick-amount-reload', 'reloadAmount', 'reloadSummaryAmount', 'reloadSummaryFee', 'reloadSummaryTotal', 5);

            setupMinAmountValidation('panelOnetime', 'onetimeAmount');
            setupMinAmountValidation('panelReloadable', 'reloadAmount');
        }
    </script>

</x-app-layout>