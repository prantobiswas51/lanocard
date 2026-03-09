<div
  class="px-6 py-4  border-b border-slate-200 dark:border-slate-700 flex items-center dark:bg-slate-800/80 backdrop-blur text-slate-800 dark:text-slate-100">

  {{-- card icon --}}
  <svg class="h-8 w-10  flex-shrink-0" viewBox="0 0 36 28" fill="none" xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true">
    <rect x="1" y="1" width="34" height="26" rx="4" stroke="currentColor" stroke-width="2" />
    <rect x="5" y="5" width="8" height="6" rx="1" fill="currentColor" />
  </svg>
  <div class="ml-3">
    <p class="text-sm font-bold tracking-wide">Entrocard</p>
    <p class="text-[11px] text-slate-500 dark:text-slate-400">User Control Panel</p>
  </div>
</div>

<nav class="flex-1 px-3 py-4 space-y-1 text-sm bg-white dark:bg-slate-800">

  <a href="{{ route('dashboard') }}"
    @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
    , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800'=>
    request()->routeIs('dashboard'),
    'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
    dark:hover:text-slate-200 border-transparent' => !request()->routeIs('dashboard'),
    ])>
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-800/50 text-emerald-600 dark:text-emerald-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M3.75 5.25h16.5M3.75 9.75h7.5m-7.5 4.5h16.5M3.75 18.75h7.5" />
      </svg>
    </span>
    Dashboard
  </a>

  <a href="{{ route('cards') }}"
    @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
    , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800'=>
    request()->routeIs('cards'),
    'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
    dark:hover:text-slate-200 border-transparent' => !request()->routeIs('cards'),
    ])>
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
      </svg>
    </span>
    My Cards
  </a>

  <a href="{{ route('fundings') }}"
    @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition'
    , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800'=>
    request()->routeIs('fundings'),
    'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
    dark:hover:text-slate-200 border-transparent' => !request()->routeIs('fundings'),
    ])>
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
      </svg>
    </span>
    Add Balance
  </a>

  <button id="navApiDocs"
    class="w-full flex items-center gap-3 rounded-lg px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-200 transition">
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
    </span>
    API Docs
  </button>

  <button id="navGetApi"
    class="w-full flex items-center gap-3 rounded-lg px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-200 transition">
    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
    </span>
    Get API Access
  </button>

  <a href="{{ route('notifications') }}"
    @class([ 'w-full flex items-center gap-3 rounded-lg px-3 py-2 font-medium border transition' , 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-100 
    dark:border-emerald-800'=>request()->routeIs('notifications'),
    'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700
    dark:hover:text-slate-200 border-transparent' => !request()->routeIs('notifications'),
    ])>
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
    </span>
    Notification History
  </a>

  <button id="navSettings"
    class="w-full flex items-center gap-3 rounded-lg px-3 py-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-200 transition">
    <span
      class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </span>
    Account Settings
  </button>
</nav>

<div
  class="px-4 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 text-xs text-slate-500 dark:text-slate-400">
  <p class="font-medium text-slate-700 dark:text-slate-300 mb-1">Support</p>
  <p>Need help with your cards? Contact 24/7 live chat.</p>
</div>