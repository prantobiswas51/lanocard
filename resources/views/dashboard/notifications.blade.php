<x-app-layout>


    <section id="viewDashboard" class="flex-1 w-full ">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 font-semibold">
                        Notifications
                    </p>
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                        Recent activity
                    </h2>
                </div>

                <span class="text-[11px] text-slate-500">
                    {{ $unreadNotificationsCount }} unread
                </span>
            </div>


            <!-- Notification list -->
            <div
                class="divide-y divide-slate-200 dark:divide-slate-700 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">

                <!-- Notification -->
                @forelse ($notifications as $notification)
                <div
                    class="flex items-start justify-between px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">

                    <div class="space-y-0.5">
                        <p class="text-[12px] text-slate-500 dark:text-slate-400">
                            {{ $notification->message }}
                        </p>
                    </div>

                    <div class=" flex">
                        <span class="text-[12px] mr-2 text-slate-400 whitespace-nowrap">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>

                        @if (!$notification->is_read)
                        <form class="text-emerald-600 text-[13px] hover:text-emerald-700"
                            action="{{ route('mark_as_read', $notification->id) }}" method="post">
                            @csrf
                            @method('POST')
                            <button>Mark As Read</button>
                        </form>
                        @endif
                    </div>

                </div>
                @empty
                <div id="notificationHistoryEmptyState"
                    class="px-6 py-10 flex flex-col items-center justify-center text-center gap-3">
                    <div
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75a4.5 4.5 0 00-4.5 4.5v.75m9 0v-.75a4.5 4.5 0 00-4.5-4.5m-7.5 9.75h15a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 16.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-semibold text-slate-900">You’re all caught up</p>
                        <p class="text-[11px] text-slate-500 max-w-xs mx-auto">
                            There are no notifications yet. New card payments, top‑ups and security alerts will appear
                            here in real time.
                        </p>
                    </div>
                    <p class="text-[10px] text-slate-400">
                        Tip: You can manage notification preferences from Settings.
                    </p>
                </div>
                @endforelse

            </div>


            <!-- Empty state -->
            <div class="hidden text-center py-16">

                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                    No notifications
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    Important activity will appear here.
                </p>

            </div>

        </div>
    </section>

</x-app-layout>