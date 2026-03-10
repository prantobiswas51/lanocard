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
                <p class="text-sm text-slate-500 p-2 dark:text-slate-400">
                    No notifications found. Check back later for updates.
                </p>
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