<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'HamzixTech builds modern websites, software, and practical technology resources.')">
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <link rel="icon" type="image/png" href="{{ asset('images/brand/hamzixtech-logo.png') }}">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'HamzixTech')">
    <meta property="og:description" content="@yield('meta_description', 'HamzixTech builds modern websites, software, and practical technology resources.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/brand/hamzixtech-logo.png') }}">
    <meta name="twitter:card" content="summary">
    <title>@yield('title', 'HamzixTech')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @livewireStyles
    @stack('head')
</head>

<body class="public-site min-h-screen bg-light-background text-dark-text antialiased dark:bg-deep-navy dark:text-white">
    <div class="flex min-h-screen flex-col">
        <header
            class="sticky top-0 z-40 border-b border-soft-border/90 bg-white/95 backdrop-blur dark:border-white/10 dark:bg-deep-navy/95">
            <nav class="mx-auto flex w-full max-w-7xl items-center justify-between gap-3 px-5 py-3 sm:px-8"
                aria-label="Main navigation">
                <a href="{{ route('home') }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                    @if (request()->routeIs('home')) aria-current="page" @endif
                    class="group flex shrink-0 items-center gap-3 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-electric-blue {{ request()->routeIs('home') ? 'brand-active' : '' }}">
                    <span
                        class="brand-icon flex size-10 items-center justify-center overflow-hidden rounded-xl bg-deep-navy p-1 ring-1 ring-white/10 transition duration-300 group-hover:-rotate-6 group-hover:scale-105"><img
                            src="{{ asset('images/brand/hamzixtech-logo.png') }}" alt="HamzixTech logo"
                            class="size-full object-contain"></span>
                    <span><span class="block text-base font-bold tracking-tight">HamzixTech</span><span
                            class="brand-tagline hidden text-[10px] font-semibold uppercase tracking-[.18em] text-muted-text sm:block dark:text-soft-slate">Digital
                            studio</span></span>
                </a>
                <div
                    class="hidden items-center gap-1 rounded-full border border-soft-border/80 bg-white/80 p-1 shadow-sm shadow-slate-900/[.03] backdrop-blur-xl xl:flex dark:border-white/10 dark:bg-white/[.04]">
                    @foreach ([['Services', 'services.index', 'services.*'], ['Projects', 'projects.index', 'projects.*'], ['Blog', 'blog.index', 'blog.*'], ['Tutorials', 'tutorials.index', 'tutorials.*'], ['Templates', 'templates.index', 'templates.*'], ['Tools', 'tools.index', 'tools.*'], ['AI tools', 'ai-tools.index', 'ai-tools.*'], ['About', 'about', 'about']] as [$label, $routeName, $routePattern])
                        @php($activeNav = request()->routeIs($routePattern))
                        <a @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                            @if ($activeNav) aria-current="page" @endif
                            class="nav-link {{ $activeNav ? 'nav-link-active' : '' }}"
                            href="{{ route($routeName) }}">{{ $label }}</a>
                    @endforeach
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('search') }}" method="get" class="hidden xl:block">
                        <label class="sr-only" for="header-search">Search</label>
                        <input id="header-search" type="search" name="q"
                            value="{{ request()->routeIs('search') ? request('q') : '' }}"
                            placeholder="Search resources"
                            class="w-40 rounded-lg border border-soft-border px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-slate-navy {{ request()->routeIs('search') ? 'border-electric-blue/70 ring-2 ring-electric-blue/10' : 'bg-light-background' }}">
                    </form>
                    <x-theme-toggle />
                    @php($contactActive = request()->routeIs('contact'))
                    <a href="{{ route('contact') }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                        @if ($contactActive) aria-current="page" @endif
                        class="hidden rounded-full px-4 py-2 text-sm font-semibold transition sm:inline-flex {{ $contactActive ? 'bg-electric-blue text-white shadow-lg shadow-electric-blue/20' : 'bg-deep-navy text-white hover:bg-electric-blue dark:bg-white dark:text-deep-navy dark:hover:bg-electric-blue dark:hover:text-white' }}">Let's
                        talk <span class="ml-2" aria-hidden="true">↗</span></a>
                    <button type="button"
                        class="inline-flex items-center gap-2 rounded-full border border-soft-border bg-white px-3.5 py-2 text-sm font-semibold shadow-sm transition hover:border-electric-blue/40 xl:hidden dark:border-white/10 dark:bg-white/5"
                        aria-label="Open menu" aria-controls="mobile-nav" aria-expanded="false" data-nav-toggle><span
                            class="menu-icon"
                            aria-hidden="true"><span></span><span></span></span><span>Menu</span></button>
                </div>
            </nav>
            <nav id="mobile-nav" hidden
                class="mobile-nav border-t border-soft-border/80 px-5 py-4 dark:border-white/10 xl:hidden"
                aria-label="Mobile navigation">
                <div class="mx-auto grid max-w-7xl grid-cols-2 gap-2 sm:grid-cols-3">
                    @foreach ([['Home', 'home', 'home'], ['Services', 'services.index', 'services.*'], ['Projects', 'projects.index', 'projects.*'], ['Blog', 'blog.index', 'blog.*'], ['Tutorials', 'tutorials.index', 'tutorials.*'], ['Templates', 'templates.index', 'templates.*'], ['Tools', 'tools.index', 'tools.*'], ['AI tools', 'ai-tools.index', 'ai-tools.*'], ['About', 'about', 'about'], ['Contact', 'contact', 'contact'], ['Search', 'search', 'search']] as [$label, $routeName, $routePattern])
                        @php($activeNav = request()->routeIs($routePattern))
                        <a href="{{ route($routeName) }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                            @if ($activeNav) aria-current="page" @endif
                            class="mobile-nav-link {{ $activeNav ? 'mobile-nav-link-active' : '' }}">{{ $label }}
                            @if ($activeNav)
                                <span aria-hidden="true">●</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                <form action="{{ route('search') }}" method="get" class="mx-auto mt-4 max-w-7xl"><label
                        for="mobile-search" class="sr-only">Search resources</label><input id="mobile-search"
                        type="search" name="q" placeholder="Search resources"
                        class="w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 text-sm dark:border-white/10 dark:bg-slate-navy">
                </form>
            </nav>
        </header>

        <main class="flex-1">@yield('content')</main>

        <footer class="border-t border-soft-border bg-white dark:border-white/10 dark:bg-slate-navy">
            <div class="mx-auto grid w-full max-w-7xl gap-8 px-5 py-12 sm:px-8 md:grid-cols-[1.3fr_1fr_1fr]">
                <div>
                    <a href="{{ route('home') }}" @if (config('hamzixtech.ui_mode') === 'livewire') wire:navigate @endif
                        class="inline-flex items-center gap-3 font-bold"><img
                            src="{{ asset('images/brand/hamzixtech-logo.png') }}" alt=""
                            class="size-10 rounded-lg bg-deep-navy p-1">HamzixTech</a>
                    <p class="mt-3 max-w-sm text-sm leading-6 text-muted-text dark:text-soft-slate">Modern websites,
                        software, and practical technology resources.</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold">Explore</h2>
                    <div class="mt-3 grid grid-cols-2 gap-2 text-sm text-muted-text dark:text-soft-slate"><a
                            href="{{ route('services.index') }}">Services</a><a
                            href="{{ route('projects.index') }}">Projects</a><a
                            href="{{ route('blog.index') }}">Blog</a><a
                            href="{{ route('tutorials.index') }}">Tutorials</a><a
                            href="{{ route('templates.index') }}">Templates</a><a
                            href="{{ route('tools.index') }}">Tools</a></div>
                </div>
                <div>
                    <h2 class="text-sm font-semibold">Information</h2>
                    <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-sm text-muted-text dark:text-soft-slate"><a
                            href="{{ route('about') }}">About</a><a href="{{ route('contact') }}">Contact</a><a
                            href="{{ route('privacy') }}">Privacy</a><a href="{{ route('terms') }}">Terms</a><a
                            href="{{ route('login') }}">Staff login</a>
                        @if ($siteContactEmail)
                            <a href="mailto:{{ $siteContactEmail }}">Email us</a>
                        @endif
                    </div>
                    @if ($siteSocialLinks->isNotEmpty())
                        <div class="mt-4 flex flex-wrap gap-3 text-sm">
                            @foreach ($siteSocialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                    class="text-electric-blue hover:underline">{{ $link->label ?: ucfirst($link->platform) }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="border-t border-soft-border dark:border-white/10">
                <div
                    class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-4 text-xs text-muted-text sm:flex-row sm:justify-between sm:px-8 dark:text-soft-slate">
                    <p>&copy; {{ now()->year }} HamzixTech.</p>
                    <p>Built with care and clear intent.</p>
                </div>
            </div>
        </footer>
    </div>
    @if (filled($siteWhatsApp))
        @php($wa = preg_replace('/\D+/', '', $siteWhatsApp))
        @if ($wa)
            @php($waHref = 'https://wa.me/' . $wa . (filled($siteWhatsAppMessage) ? '?text=' . rawurlencode($siteWhatsAppMessage) : ''))<a href="{{ $waHref }}" target="_blank" rel="noopener noreferrer"
                aria-label="Contact HamzixTech on WhatsApp"
                class="fixed bottom-5 right-5 z-30 inline-flex size-12 items-center justify-center rounded-full bg-electric-blue text-white shadow-lg transition hover:scale-105 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-electric-blue/30"><span
                    class="text-lg font-bold" aria-hidden="true">W</span></a>
        @endif
    @endif
    @livewireScripts
    @fluxScripts
    @stack('scripts')
</body>

</html>
