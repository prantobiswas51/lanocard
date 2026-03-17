<x-guest-layout>
    <section class="min-h-screen flex items-center justify-center pt-12 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">

                {{-- <div class="flex items-center mb-6 justify-center w-full">
                    <img src="{{ asset('images/logo.png') }}" alt="Lanocard" class="w-150 h-16">
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
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-medium text-slate-700 mb-1.5">Phone
                                number</label>
                            <div
                                class="flex rounded-lg border border-slate-200 bg-slate-50 overflow-hidden focus-within:ring-1 focus-within:ring-emerald-500 focus-within:bg-white">
                                <select id="phoneCode" name="phoneCode" title="Country / area code"
                                    class="w-20 flex-shrink-0 rounded-none border-0 border-r border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-0">
                                    <option value="">Code</option>
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

    <script>
        var countries = [
      { name: "Afghanistan", code: "AF", dial: "+93" }, { name: "Albania", code: "AL", dial: "+355" }, { name: "Algeria", code: "DZ", dial: "+213" },
      { name: "Andorra", code: "AD", dial: "+376" }, { name: "Angola", code: "AO", dial: "+244" }, { name: "Argentina", code: "AR", dial: "+54" },
      { name: "Armenia", code: "AM", dial: "+374" }, { name: "Australia", code: "AU", dial: "+61" }, { name: "Austria", code: "AT", dial: "+43" },
      { name: "Azerbaijan", code: "AZ", dial: "+994" }, { name: "Bahrain", code: "BH", dial: "+973" }, { name: "Bangladesh", code: "BD", dial: "+880" },
      { name: "Belarus", code: "BY", dial: "+375" }, { name: "Belgium", code: "BE", dial: "+32" }, { name: "Belize", code: "BZ", dial: "+501" },
      { name: "Benin", code: "BJ", dial: "+229" }, { name: "Bhutan", code: "BT", dial: "+975" }, { name: "Bolivia", code: "BO", dial: "+591" },
      { name: "Bosnia and Herzegovina", code: "BA", dial: "+387" }, { name: "Botswana", code: "BW", dial: "+267" }, { name: "Brazil", code: "BR", dial: "+55" },
      { name: "Brunei", code: "BN", dial: "+673" }, { name: "Bulgaria", code: "BG", dial: "+359" }, { name: "Burkina Faso", code: "BF", dial: "+226" },
      { name: "Cambodia", code: "KH", dial: "+855" }, { name: "Cameroon", code: "CM", dial: "+237" }, { name: "Canada", code: "CA", dial: "+1" },
      { name: "Chile", code: "CL", dial: "+56" }, { name: "China", code: "CN", dial: "+86" }, { name: "Colombia", code: "CO", dial: "+57" },
      { name: "Costa Rica", code: "CR", dial: "+506" }, { name: "Croatia", code: "HR", dial: "+385" }, { name: "Cuba", code: "CU", dial: "+53" },
      { name: "Cyprus", code: "CY", dial: "+357" }, { name: "Czech Republic", code: "CZ", dial: "+420" }, { name: "Denmark", code: "DK", dial: "+45" },
      { name: "Dominican Republic", code: "DO", dial: "+1" }, { name: "Ecuador", code: "EC", dial: "+593" }, { name: "Egypt", code: "EG", dial: "+20" },
      { name: "Estonia", code: "EE", dial: "+372" }, { name: "Ethiopia", code: "ET", dial: "+251" }, { name: "Finland", code: "FI", dial: "+358" },
      { name: "France", code: "FR", dial: "+33" }, { name: "Georgia", code: "GE", dial: "+995" }, { name: "Germany", code: "DE", dial: "+49" },
      { name: "Ghana", code: "GH", dial: "+233" }, { name: "Greece", code: "GR", dial: "+30" }, { name: "Guatemala", code: "GT", dial: "+502" },
      { name: "Hong Kong", code: "HK", dial: "+852" }, { name: "Hungary", code: "HU", dial: "+36" }, { name: "Iceland", code: "IS", dial: "+354" },
      { name: "India", code: "IN", dial: "+91" }, { name: "Indonesia", code: "ID", dial: "+62" }, { name: "Iran", code: "IR", dial: "+98" },
      { name: "Iraq", code: "IQ", dial: "+964" }, { name: "Ireland", code: "IE", dial: "+353" }, { name: "Israel", code: "IL", dial: "+972" },
      { name: "Italy", code: "IT", dial: "+39" }, { name: "Jamaica", code: "JM", dial: "+1" }, { name: "Japan", code: "JP", dial: "+81" },
      { name: "Jordan", code: "JO", dial: "+962" }, { name: "Kazakhstan", code: "KZ", dial: "+7" }, { name: "Kenya", code: "KE", dial: "+254" },
      { name: "Kuwait", code: "KW", dial: "+965" }, { name: "Kyrgyzstan", code: "KG", dial: "+996" }, { name: "Laos", code: "LA", dial: "+856" },
      { name: "Latvia", code: "LV", dial: "+371" }, { name: "Lebanon", code: "LB", dial: "+961" }, { name: "Libya", code: "LY", dial: "+218" },
      { name: "Lithuania", code: "LT", dial: "+370" }, { name: "Luxembourg", code: "LU", dial: "+352" }, { name: "Macau", code: "MO", dial: "+853" },
      { name: "Malaysia", code: "MY", dial: "+60" }, { name: "Maldives", code: "MV", dial: "+960" }, { name: "Malta", code: "MT", dial: "+356" },
      { name: "Mexico", code: "MX", dial: "+52" }, { name: "Moldova", code: "MD", dial: "+373" }, { name: "Mongolia", code: "MN", dial: "+976" },
      { name: "Montenegro", code: "ME", dial: "+382" }, { name: "Morocco", code: "MA", dial: "+212" }, { name: "Myanmar", code: "MM", dial: "+95" },
      { name: "Nepal", code: "NP", dial: "+977" }, { name: "Netherlands", code: "NL", dial: "+31" }, { name: "New Zealand", code: "NZ", dial: "+64" },
      { name: "Nigeria", code: "NG", dial: "+234" }, { name: "North Macedonia", code: "MK", dial: "+389" }, { name: "Norway", code: "NO", dial: "+47" },
      { name: "Oman", code: "OM", dial: "+968" }, { name: "Pakistan", code: "PK", dial: "+92" }, { name: "Palestine", code: "PS", dial: "+970" },
      { name: "Panama", code: "PA", dial: "+507" }, { name: "Paraguay", code: "PY", dial: "+595" }, { name: "Peru", code: "PE", dial: "+51" },
      { name: "Philippines", code: "PH", dial: "+63" }, { name: "Poland", code: "PL", dial: "+48" }, { name: "Portugal", code: "PT", dial: "+351" },
      { name: "Qatar", code: "QA", dial: "+974" }, { name: "Romania", code: "RO", dial: "+40" }, { name: "Russia", code: "RU", dial: "+7" },
      { name: "Rwanda", code: "RW", dial: "+250" }, { name: "Saudi Arabia", code: "SA", dial: "+966" }, { name: "Senegal", code: "SN", dial: "+221" },
      { name: "Serbia", code: "RS", dial: "+381" }, { name: "Singapore", code: "SG", dial: "+65" }, { name: "Slovakia", code: "SK", dial: "+421" },
      { name: "Slovenia", code: "SI", dial: "+386" }, { name: "South Africa", code: "ZA", dial: "+27" }, { name: "South Korea", code: "KR", dial: "+82" },
      { name: "Spain", code: "ES", dial: "+34" }, { name: "Sri Lanka", code: "LK", dial: "+94" }, { name: "Sudan", code: "SD", dial: "+249" },
      { name: "Sweden", code: "SE", dial: "+46" }, { name: "Switzerland", code: "CH", dial: "+41" }, { name: "Syria", code: "SY", dial: "+963" },
      { name: "Taiwan", code: "TW", dial: "+886" }, { name: "Tajikistan", code: "TJ", dial: "+992" }, { name: "Tanzania", code: "TZ", dial: "+255" },
      { name: "Thailand", code: "TH", dial: "+66" }, { name: "Tunisia", code: "TN", dial: "+216" }, { name: "Turkey", code: "TR", dial: "+90" },
      { name: "Turkmenistan", code: "TM", dial: "+993" }, { name: "Uganda", code: "UG", dial: "+256" }, { name: "Ukraine", code: "UA", dial: "+380" },
      { name: "United Arab Emirates", code: "AE", dial: "+971" }, { name: "United Kingdom", code: "GB", dial: "+44" },
      { name: "United States", code: "US", dial: "+1" }, { name: "Uruguay", code: "UY", dial: "+598" }, { name: "Uzbekistan", code: "UZ", dial: "+998" },
      { name: "Venezuela", code: "VE", dial: "+58" }, { name: "Vietnam", code: "VN", dial: "+84" }, { name: "Yemen", code: "YE", dial: "+967" },
      { name: "Zambia", code: "ZM", dial: "+260" }, { name: "Zimbabwe", code: "ZW", dial: "+263" }
    ];

    var countrySelect = document.getElementById('country');
    var phoneCodeSelect = document.getElementById('phoneCode');
    countries.forEach(function(c) {
      var o1 = document.createElement('option');
      o1.value = c.code;
      o1.textContent = c.name;
      countrySelect.appendChild(o1);
      var o2 = document.createElement('option');
      o2.value = c.dial;
      o2.textContent = c.dial;
      phoneCodeSelect.appendChild(o2);
    });

    countrySelect.addEventListener('change', function() {
      var code = countrySelect.value;
      if (!code) return;
      var c = countries.find(function(x) { return x.code === code; });
      if (c) phoneCodeSelect.value = c.dial;
    });
    </script>

</x-guest-layout>