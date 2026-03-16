<x-guest-layout>
    <section class="min-h-screen flex items-center justify-center pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">

            {{-- <div class="flex items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Tappayz" class="w-150 h-16">
            </div> --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 mb-1">Log in</h1>
                <p class="text-sm text-slate-500 mb-6">Enter your email and password to access your account.</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-700 mb-1.5">Email</label>
                        <input id="email" name="email" type="email" required placeholder="you@example.com"
                            value="{{ old('email') }}" autofocus autocomplete="username"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-medium text-slate-700">Password</label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[11px] font-medium text-emerald-600 hover:underline">Forgot password?</a>
                            @endif
                        </div>
                        <input id="password" name="password" type="password" required placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600" for="remember_me">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500" {{ old('remember')
                            ? 'checked' : '' }}>
                        Remember me
                    </label>

                    <button type="submit"
                        class="w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">
                        Log in
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-slate-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:underline">Sign up</a>
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>