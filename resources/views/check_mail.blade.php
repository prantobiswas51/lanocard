<x-guest-layout>
    <div class="max-w-lg w-full mx-auto py-12 slide-up">

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden max-w-md mx-auto">

            {{-- site logo --}}
            {{-- <div class="flex items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Lanocard" class="w-150 h-16">
            </div> --}}

            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-8 text-center">
                <div
                    class="flex items-center justify-center h-14 w-14 rounded-full bg-white/20 text-white mx-auto mb-3">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-white mb-1">Email Sent!</h1>
                <p class="text-emerald-100 text-sm">Please check your inbox</p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8">

                <div class="space-y-4 mb-6">

                    <!-- Step 1 -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Open Your Email</p>
                            <p class="text-slate-500 text-xs mt-1">Check your inbox for the verification message.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Check Spam Folder</p>
                            <p class="text-slate-500 text-xs mt-1">If you don’t see it, check your spam or junk folder.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Click Verification Link</p>
                            <p class="text-slate-500 text-xs mt-1">Click the link inside the email to activate your
                                account.</p>
                        </div>
                    </div>

                </div>

                <!-- Login Button -->
                <a href="/login"
                    class="block w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600 text-center">
                    Go to log in →
                </a>

            </div>



        </div>

    </div>
</x-guest-layout>