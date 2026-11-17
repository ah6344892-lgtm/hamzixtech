<section class="admin-page space-y-7">
    <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-electric-blue">Workspace</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Overview</h1>
            <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">A live snapshot of content and activity across
                your site.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs text-muted-text dark:text-soft-slate">Updated {{ $refreshedAt }}</span>
            <flux:button wire:click="refreshDashboard" wire:loading.attr="disabled" variant="outline" size="sm"
                icon="arrow-path">
                <span wire:loading.remove wire:target="refreshDashboard">Refresh</span>
                <span wire:loading wire:target="refreshDashboard">Refreshing...</span>
            </flux:button>
            <flux:button href="{{ route('home') }}" variant="primary" color="blue" icon:trailing="arrow-up-right">
                Visit site</flux:button>
        </div>
    </header>

    @if ($stats->isNotEmpty())
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <a href="{{ route($stat['route']) }}" class="admin-stat-card group">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-muted-text dark:text-soft-slate">{{ $stat['label'] }}</p>
                            <p class="mt-3 text-3xl font-semibold tracking-tight tabular-nums">
                                {{ number_format($stat['value']) }}</p>
                        </div>
                        <span class="admin-stat-icon admin-stat-{{ $stat['color'] }}">
                            <flux:icon :icon="$stat['icon']" variant="mini" />
                        </span>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-electric-blue">Open
                        section <span class="transition-transform group-hover:translate-x-1"
                            aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-[1.05fr_.95fr]">
        <section class="admin-panel">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-electric-blue">Shortcuts</p>
                    <h2 class="mt-1 text-lg font-semibold">Quick actions</h2>
                </div>
                <span class="admin-panel-mark">
                    <flux:icon icon="bolt" variant="mini" />
                </span>
            </div>
            <div class="mt-5 grid gap-2 sm:grid-cols-2">
                @foreach ([['Write a post', 'admin.posts.create', 'create posts', 'pencil-square'], ['Add a service', 'admin.services.create', 'create services', 'squares-2x2'], ['Add a project', 'admin.projects.create', 'create projects', 'briefcase'], ['Manage messages', 'admin.contact-messages.index', 'view contact messages', 'envelope'], ['Manage staff', 'admin.users.index', 'view users', 'users'], ['Edit site settings', 'admin.settings.edit', 'manage settings', 'cog-6-tooth']] as [$label, $url, $permission, $icon])
                    @if (auth()->user()->can($permission))
                        <a href="{{ route($url) }}" class="admin-action group">
                            <span class="admin-action-icon">
                                <flux:icon :icon="$icon" variant="mini" />
                            </span>
                            <span>{{ $label }}</span>
                            <span
                                class="ml-auto text-muted-text transition group-hover:translate-x-1 group-hover:text-electric-blue"
                                aria-hidden="true">→</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </section>

        @if (auth()->user()->can('view activity logs'))
            <section class="admin-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-electric-blue">Audit trail</p>
                        <h2 class="mt-1 text-lg font-semibold">Recent activity</h2>
                    </div>
                    <flux:button href="{{ route('admin.activity-logs.index') }}" variant="subtle" size="sm"
                        icon:trailing="arrow-up-right">View all</flux:button>
                </div>
                @if ($activity->isEmpty())
                    <div class="admin-empty-state mt-5">
                        <span class="admin-empty-icon">
                            <flux:icon icon="clock" variant="mini" />
                        </span>
                        <p class="mt-3 text-sm font-medium">No activity entries yet</p>
                        <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">Recent management actions will
                            appear here.</p>
                    </div>
                @else
                    <ul class="mt-4 divide-y divide-soft-border dark:divide-white/10">
                        @foreach ($activity as $entry)
                            <li class="flex gap-3 py-3.5">
                                <span
                                    class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-full bg-electric-blue/10 text-electric-blue">
                                    <flux:icon icon="bolt" variant="micro" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="break-words text-sm font-medium">
                                        {{ $entry->description ?: $entry->event }}</p>
                                    <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">
                                        {{ $entry->user?->name ?: 'System' }} <span class="px-1">·</span>
                                        {{ $entry->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif
    </div>
</section>
