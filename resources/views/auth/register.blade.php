<x-guest-layout>
    <section class="min-h-screen flex items-center justify-center pt-12 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">

                {{-- <div class="flex items-center mb-6 justify-center w-full">
                    <img src="{{ asset('images/logo.png') }}" alt="Tappayz" class="w-150 h-16">
                </div> --}}
                
                <div id="stepForm">
                    <h1 class="text-xl font-bold text-slate-900 mb-1">Create account</h1>
                    <p class="text-sm text-slate-500 mb-6">Sign up to create virtual cards and manage your balance.</p>

                    <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-xs font-medium text-slate-700 mb-1.5">Full name</label>
                            <input id="name" name="name" type="text" required placeholder="Your name"
                                value="{{ old('name') }}" autofocus autocomplete="name"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-medium text-slate-700 mb-1.5">Email</label>
                            <input id="email" name="email" type="email" required placeholder="you@example.com"
                                value="{{ old('email') }}" autocomplete="username"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="country" class="block text-xs font-medium text-slate-700 mb-1.5">Country</label>
                            <select id="country" name="country" required
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                                <option value="">Select country</option>
                                <option value="US" {{ old('country')==='US' ? 'selected' : '' }}>United States</option>
                                <option value="CA" {{ old('country')==='CA' ? 'selected' : '' }}>Canada</option>
                                <option value="GB" {{ old('country')==='GB' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="AU" {{ old('country')==='AU' ? 'selected' : '' }}>Australia</option>
                                <option value="DE" {{ old('country')==='DE' ? 'selected' : '' }}>Germany</option>
                                <option value="FR" {{ old('country')==='FR' ? 'selected' : '' }}>France</option>
                                <option value="IT" {{ old('country')==='IT' ? 'selected' : '' }}>Italy</option>
                                <option value="ES" {{ old('country')==='ES' ? 'selected' : '' }}>Spain</option>
                                <option value="BD" {{ old('country')==='BD' ? 'selected' : '' }}>Bangladesh</option>
                                <option value="IN" {{ old('country')==='IN' ? 'selected' : '' }}>India</option>
                                <option value="PK" {{ old('country')==='PK' ? 'selected' : '' }}>Pakistan</option>
                                <option value="other" {{ old('country')==='other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-medium text-slate-700 mb-1.5">Phone
                                number</label>
                            <div
                                class="flex rounded-lg border border-slate-200 bg-slate-50 overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:bg-white">
                                <select title="Country / area code"
                                    class="w-32 flex-shrink-0 rounded-none border-0 border-r border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-0">
                                    <option value="">Code</option>
                                    <option value="+1">United States +1</option>
                                    <option value="+44">United Kingdom +44</option>
                                    <option value="+880">Bangladesh +880</option>
                                    <option value="+91">India +91</option>
                                    <option value="+92">Pakistan +92</option>
                                </select>
                                <input id="phone" name="phone" type="tel" required placeholder="Phone number"
                                    value="{{ old('phone') }}"
                                    class="flex-1 min-w-0 bg-transparent border-0 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0">
                            </div>
                            <p class="mt-1 text-[11px] text-slate-500">Select country code then enter your number.</p>
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password"
                                class="block text-xs font-medium text-slate-700 mb-1.5">Password</label>
                            <input id="password" name="password" type="password" required placeholder="Min 6 characters"
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-medium text-slate-700 mb-1.5">Confirm password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                placeholder="Repeat password" autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:bg-white">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <label class="flex items-start gap-2 text-sm text-slate-600" for="terms">
                            <input id="terms" name="terms" type="checkbox" required value="1"
                                class="mt-0.5 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500" {{
                                old('terms') ? 'checked' : '' }}>
                            <span>
                                I agree to the
                                <a href="#" class="text-emerald-600 hover:underline">Terms & Conditions</a>
                                and
                                <a href="#" class="text-emerald-600 hover:underline">Privacy Policy</a>.
                            </span>
                        </label>
                        <x-input-error :messages="$errors->get('terms')" class="mt-2" />

                        <button type="submit"
                            class="w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600">
                            Sign up
                        </button>
                    </form>

                    <p class="mt-4 text-center text-sm text-slate-500">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:underline">Log in</a>
                    </p>
                </div>

                <div id="stepNext" class="hidden text-center">
                    <div
                        class="flex items-center justify-center h-14 w-14 rounded-full bg-emerald-100 text-emerald-600 mx-auto mb-4">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Account created successfully</h2>
                    <p class="text-sm text-slate-600 mb-4">Welcome to VirtualPay. Your account has been created.</p>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-left mb-6">
                        <p class="text-xs font-medium text-slate-700 mb-1">Next step: verify your email</p>
                        <p class="text-sm text-slate-600">We have sent a verification link to <strong id="nextStepEmail"
                                class="text-slate-900"></strong>. Please check your inbox and click
                            the link to verify your email.</p>
                    </div>
                    <a href="{{ route('login') }}"
                        class="block w-full rounded-lg bg-emerald-500 py-2.5 text-sm font-semibold text-white hover:bg-emerald-600 text-center">
                        Go to log in
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>