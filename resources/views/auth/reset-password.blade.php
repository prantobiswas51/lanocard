<x-guest-layout>
   <main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">

            <!-- Icon & Heading -->
            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1H9v-1c0-1.657 1.343-3 3-3zm-6 4h12v5a2 2 0 01-2 2H8a2 2 0 01-2-2v-5z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900 mb-1">Set new password</h1>
            <p class="text-sm text-slate-500 mb-6">
                Your new password must be different from your previous password.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
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
                        autocomplete="username"
                        value="{{ old('email', $request->email) }}"
                        placeholder="you@example.com"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white @error('email') border-red-400 @enderror"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium text-slate-700 mb-1.5">
                        New password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white @error('password') border-red-400 @enderror"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1.5">
                        Confirm new password
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white @error('password_confirmation') border-red-400 @enderror"
                    >
                    @error('password_confirmation')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600 mt-2">
                    Reset Password
                </button>
            </form>

        </div>

        <p class="mt-4 text-center text-sm text-slate-500">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:underline">Log in</a>
        </p>
    </div>
</main>
</x-guest-layout>
