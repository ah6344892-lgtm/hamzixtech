<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Management') | HamzixTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @livewireStyles
</head>

<body class="min-h-screen bg-light-background text-dark-text antialiased dark:bg-deep-navy dark:text-white">
    @php
        $adminNavGroups = [
            'Workspace' => [['Overview', 'admin.dashboard', 'view dashboard', 'squares-2x2']],
            'Content' => [
                ['Posts', 'admin.posts.index', 'view posts', 'document-text'],
                ['Tutorials', 'admin.tutorials.index', 'view tutorials', 'academic-cap'],
                ['Templates', 'admin.templates.index', 'view templates', 'rectangle-stack'],
                ['Tools', 'admin.tools.index', 'view tools', 'wrench-screwdriver'],
                ['AI tools', 'admin.ai-tools.index', 'view AI tools', 'sparkles'],
                ['Services', 'admin.services.index', 'view services', 'squares-2x2'],
                ['Projects', 'admin.projects.index', 'view projects', 'briefcase'],
                ['Categories', 'admin.categories.index', 'view posts', 'tag'],
                ['Tags', 'admin.tags.index', 'view posts', 'hashtag'],
            ],
            'Operations' => [
                ['Contact messages', 'admin.contact-messages.index', 'view contact messages', 'envelope'],
                ['Media library', 'admin.media.index', 'view media', 'photo'],
            ],
            'Administration' => [
                ['Users', 'admin.users.index', 'view users', 'users'],
                ['Roles & permissions', 'admin.roles.index', 'manage roles', 'shield-check'],
                ['Site settings', 'admin.settings.edit', 'manage settings', 'cog-6-tooth'],
                ['Activity log', 'admin.activity-logs.index', 'view activity logs', 'clock'],
            ],
        ];
    @endphp
    <div class="min-h-screen lg:grid lg:grid-cols-[270px_minmax(0,1fr)]" x-data="{ sidebarOpen: false }"
        x-on:keydown.escape.window="sidebarOpen = false">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-950/55 backdrop-blur-[2px] lg:hidden" x-on:click="sidebarOpen = false"
            aria-hidden="true"></div>
        <aside
            class="admin-sidebar fixed inset-y-0 left-0 z-50 flex w-[min(84vw,290px)] -translate-x-full flex-col border-r border-soft-border bg-white transition-transform duration-300 dark:border-white/10 dark:bg-slate-navy lg:sticky lg:top-0 lg:h-screen lg:w-auto lg:translate-x-0"
            x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex items-center justify-between border-b border-soft-border px-5 py-4 dark:border-white/10">
                <a href="{{ route('admin.dashboard') }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                    class="flex min-w-0 items-center gap-3 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-electric-blue">
                    <img src="{{ asset('images/brand/hamzixtech-logo.png') }}"
                        class="size-10 rounded-xl bg-deep-navy p-1" alt="HamzixTech">
                    <span class="min-w-0"><span class="block truncate text-sm font-bold">HamzixTech</span><span
                            class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[.18em] text-muted-text dark:text-soft-slate">Management</span></span>
                </a>
                <flux:button class="lg:hidden" variant="subtle" square aria-label="Close navigation"
                    x-on:click="sidebarOpen = false">
                    <flux:icon icon="x-mark" variant="mini" />
                </flux:button>
            </div>

            <nav class="admin-sidebar-nav flex-1 space-y-5 overflow-y-auto px-3 py-5"
                aria-label="Management navigation">
                @foreach ($adminNavGroups as $group => $items)
                    @php($visibleItems = collect($items)->filter(fn($item) => auth()->user()->can($item[2]))->values())
                    @if ($visibleItems->isNotEmpty())
                        <section>
                            <h2
                                class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[.17em] text-slate-400 dark:text-slate-500">
                                {{ $group }}</h2>
                            <div class="space-y-1">
                                @foreach ($visibleItems as [$label, $routeName, $permission, $icon])
                                    @php($active = request()->routeIs($routeName === 'admin.dashboard' ? $routeName : str_replace('.index', '.*', $routeName)))
                                    <a href="{{ route($routeName) }}"
                                        @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                                        @if ($active) aria-current="page" @endif
                                        x-on:click="sidebarOpen = false"
                                        class="admin-sidebar-link {{ $active ? 'admin-sidebar-link-active' : '' }}">
                                        <flux:icon :icon="$icon" variant="mini" />
                                        <span>{{ $label }}</span>
                                        @if ($active)
                                            <span class="admin-sidebar-indicator" aria-hidden="true"></span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </nav>

            <div class="border-t border-soft-border p-3 dark:border-white/10">
                <a href="{{ route('home') }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                    class="admin-sidebar-link">
                    <flux:icon icon="arrow-top-right-on-square" variant="mini" /><span>View website</span>
                </a>
                <div class="mt-2 flex items-center gap-3 rounded-xl bg-light-background p-3 dark:bg-deep-navy">
                    <span
                        class="flex size-9 shrink-0 items-center justify-center rounded-full bg-electric-blue/10 text-xs font-bold text-electric-blue">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="min-w-0 flex-1"><span
                            class="block truncate text-xs font-semibold">{{ auth()->user()->name }}</span><span
                            class="mt-0.5 block truncate text-[10px] text-muted-text dark:text-soft-slate">{{ auth()->user()->getRoleNames()->join(', ') }}</span></span>
                    <form method="post" action="{{ route('logout') }}">@csrf<button type="submit"
                            class="rounded-lg p-2 text-muted-text transition hover:bg-white hover:text-red-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-electric-blue dark:text-soft-slate dark:hover:bg-white/10"
                            aria-label="Sign out">
                            <flux:icon icon="arrow-left-start-on-rectangle" variant="mini" />
                        </button></form>
                </div>
            </div>
        </aside>

        <div class="flex min-h-screen min-w-0 flex-col">
            <header
                class="admin-topbar sticky top-0 z-30 flex min-h-16 items-center justify-between border-b border-soft-border/80 bg-white/90 px-4 backdrop-blur-xl dark:border-white/10 dark:bg-deep-navy/90 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <flux:button variant="outline" square class="lg:hidden" aria-label="Open navigation"
                        x-on:click="sidebarOpen = true">
                        <flux:icon icon="bars-3" variant="mini" />
                    </flux:button>
                    <div class="min-w-0">
                        <p
                            class="truncate text-[10px] font-bold uppercase tracking-[.17em] text-muted-text dark:text-soft-slate">
                            Management</p>
                        <p class="mt-0.5 truncate text-sm font-semibold">@yield('title', 'Overview')</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3">
                    <span
                        class="hidden text-xs text-muted-text dark:text-soft-slate sm:inline">{{ auth()->user()->name }}</span>
                    <x-theme-toggle />
                </div>
            </header>

            <main class="admin-main mx-auto w-full max-w-[1600px] flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div role="status"
                        class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-500/25 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-200">
                        <flux:icon icon="check-circle" variant="mini" /><span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div role="alert"
                        class="mb-5 flex items-start gap-3 rounded-xl border border-red-500/25 bg-red-500/10 px-4 py-3 text-sm text-red-800 dark:text-red-200">
                        <flux:icon icon="exclamation-circle" variant="mini" /><span>{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div role="alert"
                        class="mb-5 flex items-start gap-3 rounded-xl border border-red-500/25 bg-red-500/10 px-4 py-3 text-sm text-red-800 dark:text-red-200">
                        <flux:icon icon="exclamation-triangle" variant="mini" /><span class="font-semibold">Please
                            correct the form errors below.</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
    @fluxScripts
</body>

</html>
