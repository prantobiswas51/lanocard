<x-guest-layout>
    <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">

            @if(session('status'))
                <!-- Step 2: Email Sent -->
                <div class="text-center space-y-4">
                    <div class="flex items-center justify-center h-14 w-14 rounded-full bg-emerald-100 text-emerald-600 mx-auto">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Check your email</h2>
                    <p class="text-sm text-slate-600">
                        We've sent a password reset link to
                        <strong class="text-slate-900">{{ old('email') }}</strong>.
                        Click the link in that email to set a new password.
                    </p>
                    <p class="text-xs text-slate-500">
                        The link usually expires in 1 hour. If you don't see the email, check your spam folder.
                    </p>
                    <div class="space-y-2 pt-2">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ old('email') }}">
                            <button type="submit"
                                class="w-full rounded-lg border border-slate-200 py-2.5 text-sm font-medium text-slate-700 hover:border-emerald-300 hover:text-emerald-600">
                                Resend link
                            </button>
                        </form>
                        <a href="{{ route('login') }}"
                            class="block w-full rounded-lg bg-slate-100 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-200 text-center">
                            Back to log in
                        </a>
                    </div>
                </div>

            @else
                <!-- Step 1: Enter Email -->
                <div class="space-y-4">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 text-emerald-600 mb-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-slate-900 text-center">Reset password</h1>
                    <p class="text-sm text-slate-500 text-center">
                        Enter the email address linked to your account. We'll send you a link to reset your password.
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="block text-xs font-medium text-slate-700 mb-1.5">
                                Email address
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autofocus
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white @error('email') border-red-400 @enderror"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">
                            Send reset link
                        </button>
                    </form>
                </div>
            @endif

        </div>

        <p class="mt-4 text-center text-sm text-slate-500">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:underline">Log in</a>
        </p>
    </div>
</main>
</x-guest-layout>