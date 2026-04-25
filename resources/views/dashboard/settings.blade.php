<x-app-layout>
    <section id="viewAccount" class="flex-1 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-5">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-500 font-semibold">My account</p>
                    <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Manage your profile and API access</h2>
                    <p class="text-xs text-slate-500 max-w-2xl">
                        Update your account details, rotate your password, and keep API credentials secure for server integrations.
                    </p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-xs space-y-1 min-w-[220px]">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-600">API serial</span>
                        <span class="font-semibold text-slate-900 font-mono">{{ $user->api_num }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-600">Account status</span>
                        <span class="font-semibold text-emerald-700">{{ $user->email_verified_at ? 'Verified' : 'Pending verification' }}</span>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-[1.5fr,1fr] gap-5 items-start">
                <div class="space-y-5">
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="mb-4">
                            <p class="text-xs uppercase tracking-[0.18em] text-emerald-500 font-semibold">Profile</p>
                            <h3 class="text-base font-semibold text-slate-900">Account information</h3>
                            <p class="text-[11px] text-slate-500">These details are used for account communication and verification.</p>
                        </div>

                        <form method="POST" action="{{ route('account.profile.update') }}" class="space-y-4 text-sm">
                            @csrf
                            @method('PATCH')

                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label for="name" class="text-xs font-medium text-slate-800">Full name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:ring-emerald-500" />
                                    @error('name')
                                        <p class="text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="email" class="text-xs font-medium text-slate-800">Email address</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:ring-emerald-500" />
                                    @error('email')
                                        <p class="text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-4 py-2.5 text-xs font-semibold text-white hover:bg-emerald-600">
                                    Save profile
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="mb-4">
                            <p class="text-xs uppercase tracking-[0.18em] text-emerald-500 font-semibold">Security</p>
                            <h3 class="text-base font-semibold text-slate-900">Change password</h3>
                            <p class="text-[11px] text-slate-500">Use a strong password with at least 8 characters.</p>
                        </div>

                        <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4 text-sm">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-1.5">
                                <label for="current_password" class="text-xs font-medium text-slate-800">Current password</label>
                                <input id="current_password" name="current_password" type="password" required
                                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:ring-emerald-500" />
                                @error('current_password')
                                    <p class="text-[11px] text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label for="password" class="text-xs font-medium text-slate-800">New password</label>
                                    <input id="password" name="password" type="password" required
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:ring-emerald-500" />
                                    @error('password')
                                        <p class="text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label for="password_confirmation" class="text-xs font-medium text-slate-800">Confirm password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required
                                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:ring-emerald-500" />
                                </div>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white hover:bg-slate-800">
                                    Update password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-sm space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.18em] text-emerald-500 font-semibold">Developer API</p>
                        <h3 class="text-base font-semibold text-slate-900">Serial and secret key</h3>
                        <p class="text-[11px] text-slate-500">
                            Use these credentials in your backend requests. Never expose your secret key in browser code.
                        </p>
                    </div>

                    <div class="space-y-1.5 text-sm">
                        <label class="text-xs font-medium text-slate-800">API serial</label>
                        <div class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                            <input id="apiSerial" type="text" readonly value="{{ $user->api_num }}"
                                class="w-full bg-transparent border-none text-sm text-slate-900 font-mono focus:ring-0" />
                            <button type="button" data-copy-target="apiSerial"
                                class="copy-btn rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                                Copy
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-sm">
                        <div class="flex items-center justify-between gap-2">
                            <label class="text-xs font-medium text-slate-800">API key</label>
                            <button id="toggleApiKeyBtn" type="button" class="text-[11px] text-emerald-600 hover:text-emerald-700 font-medium">Show key</button>
                        </div>
                        <div class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                            <input id="apiKey" type="password" readonly value="{{ $user->api_key }}"
                                class="w-full bg-transparent border-none text-sm text-slate-900 font-mono focus:ring-0" />
                            <button type="button" data-copy-target="apiKey"
                                class="copy-btn rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] text-slate-700 hover:border-emerald-300 hover:text-emerald-700">
                                Copy
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('account.api.regenerate') }}" class="space-y-3"
                        onsubmit="return confirm('Regenerating your API key will revoke the old key immediately. Continue?');">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-4 py-2.5 text-xs font-semibold text-amber-700 hover:bg-amber-100">
                            Regenerate API key
                        </button>
                    </form>

                    <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-3 text-[11px] text-emerald-700 space-y-1">
                        <p class="font-semibold">Security note</p>
                        <p>
                            If you rotate the API key, update your server environment variables right away to avoid failed requests.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.copy-btn').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const targetId = btn.getAttribute('data-copy-target');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(input.value || '');
                    const initialText = btn.textContent;
                    btn.textContent = 'Copied';
                    setTimeout(() => {
                        btn.textContent = initialText;
                    }, 1200);
                } catch (e) {
                    console.error('Copy failed', e);
                }
            });
        });

        const apiKeyInput = document.getElementById('apiKey');
        const toggleApiKeyBtn = document.getElementById('toggleApiKeyBtn');

        if (apiKeyInput && toggleApiKeyBtn) {
            toggleApiKeyBtn.addEventListener('click', () => {
                const hidden = apiKeyInput.type === 'password';
                apiKeyInput.type = hidden ? 'text' : 'password';
                toggleApiKeyBtn.textContent = hidden ? 'Hide key' : 'Show key';
            });
        }
    </script>
</x-app-layout>