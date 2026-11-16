@extends('layouts.app')
@section('title', 'HamzixTech | Modern websites and software')
@section('meta_description', 'HamzixTech builds modern websites and software and shares practical technology resources.')
@section('content')
@php
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'HamzixTech',
        'url' => config('app.url'),
        'logo' => asset('images/brand/hamzixtech-logo.png'),
    ];
    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'HamzixTech',
        'url' => config('app.url'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => route('search').'?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ];
@endphp
@push('head')
    <script type="application/ld+json">@json($organizationSchema)</script>
    <script type="application/ld+json">@json($websiteSchema)</script>
@endpush
<section class="hero-shell relative isolate overflow-hidden">
    <div class="hero-noise pointer-events-none absolute inset-0" aria-hidden="true"></div>
    <div class="hero-glow hero-glow-one pointer-events-none absolute" aria-hidden="true"></div>
    <div class="hero-glow hero-glow-two pointer-events-none absolute" aria-hidden="true"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:min-h-[650px] lg:grid-cols-[1.05fr_.95fr] lg:gap-8 lg:py-20">
        <div class="relative z-10 max-w-2xl" data-reveal>
            <p class="hero-eyebrow inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[.15em]"><span class="status-pulse size-2 rounded-full"></span>Independent digital studio</p>
            <h1 class="hero-title mt-7 text-4xl font-semibold leading-[1.08] tracking-[-.045em] sm:text-5xl lg:text-[4.1rem]">{{ $headline }}</h1>
            <p class="mt-6 max-w-xl text-base leading-7 text-white/65 sm:text-lg sm:leading-8">{{ $introduction }}</p>
            <div class="mt-8 flex flex-wrap gap-3"><flux:button href="{{ route('contact') }}" variant="primary" color="blue" icon:trailing="arrow-right">Discuss a project</flux:button><flux:button href="{{ route('projects.index') }}" variant="outline">Explore projects</flux:button></div>
            <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-white/55"><a class="hero-text-link" href="{{ route('services.index') }}">Services <span aria-hidden="true">↗</span></a><a class="hero-text-link" href="{{ route('blog.index') }}">Technology articles <span aria-hidden="true">↗</span></a><a class="hero-text-link" href="{{ route('tools.index') }}">Developer tools <span aria-hidden="true">↗</span></a></div>
            <div class="mt-10 flex flex-wrap items-center gap-x-5 gap-y-2 border-t border-white/10 pt-6 text-[11px] font-medium tracking-wide text-white/50"><span class="inline-flex items-center gap-2"><i class="size-1.5 rounded-full bg-blue-300"></i>Thoughtful design</span><span class="inline-flex items-center gap-2"><i class="size-1.5 rounded-full bg-violet-300"></i>Reliable engineering</span><span class="inline-flex items-center gap-2"><i class="size-1.5 rounded-full bg-cyan-300"></i>Useful resources</span></div>
        </div>
        <div class="hero-stage relative mx-auto w-full max-w-[540px]" data-reveal data-reveal-delay="150">
            <div class="hero-orbit hero-orbit-one" aria-hidden="true"></div><div class="hero-orbit hero-orbit-two" aria-hidden="true"></div>
            <div class="hero-satellite-field" aria-hidden="true">
                <div class="hero-satellite-guide"></div>
                <div class="hero-satellite-track">
                    <div class="hero-satellite hero-satellite-top"><div class="hero-satellite-face"><i>✳</i><span>Web design</span></div></div>
                    <div class="hero-satellite hero-satellite-right"><div class="hero-satellite-face"><i>&lt;/&gt;</i><span>Software</span></div></div>
                    <div class="hero-satellite hero-satellite-bottom"><div class="hero-satellite-face"><i>↗</i><span>Tutorials</span></div></div>
                    <div class="hero-satellite hero-satellite-left"><div class="hero-satellite-face"><i>◌</i><span>Developer tools</span></div></div>
                </div>
            </div>
            <div class="hero-glass-card" data-tilt>
                <div class="hero-card-top"><span class="flex items-center gap-2"><span class="size-2 rounded-full bg-emerald-400"></span>HAMZIXTECH <span class="text-white/30">/</span> STUDIO</span><span class="hero-window-controls" aria-hidden="true"><i></i><i></i><i></i></span></div>
                <div class="hero-card-art">
                    <div class="hero-grid-pattern" aria-hidden="true"></div>
                    <div class="hero-dashboard">
                        <div class="hero-dashboard-heading">
                            <div><span class="hero-dashboard-kicker">STUDIO PULSE</span><strong>Ideas into impact</strong></div>
                            <span class="hero-live-indicator"><i></i> LIVE</span>
                        </div>
                        <div class="hero-dashboard-summary">
                            <div><span>Momentum</span><strong>+38.6%</strong></div>
                            <span class="hero-dashboard-period">LAST 30 DAYS <i>⌄</i></span>
                        </div>
                        <div class="hero-chart" aria-hidden="true">
                            <div class="hero-chart-y-labels"><span>100</span><span>75</span><span>50</span><span>25</span></div>
                            <svg class="hero-chart-svg" viewBox="0 0 600 220" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="hero-chart-fill" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#4f9dff" stop-opacity=".34" />
                                        <stop offset="100%" stop-color="#4f9dff" stop-opacity="0" />
                                    </linearGradient>
                                    <linearGradient id="hero-chart-stroke" x1="0" x2="1" y1="0" y2="0">
                                        <stop offset="0%" stop-color="#60a5fa" />
                                        <stop offset="56%" stop-color="#48d6d0" />
                                        <stop offset="100%" stop-color="#a7f3d0" />
                                    </linearGradient>
                                </defs>
                                <path class="hero-chart-area" d="M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29 L592 220 L8 220 Z">
                                    <animate attributeName="d" dur="10s" repeatCount="indefinite" calcMode="spline" keyTimes="0;0.33;0.66;1" keySplines=".42 0 .58 1;.42 0 .58 1;.42 0 .58 1" values="M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29 L592 220 L8 220 Z;M8 175 C38 185 48 150 76 158 S120 168 148 142 S195 152 222 128 S267 138 296 110 S337 124 366 97 S410 110 441 77 S484 91 516 58 S558 63 592 40 L592 220 L8 220 Z;M8 194 C38 166 48 174 76 148 S120 158 148 137 S195 143 222 115 S267 124 296 101 S337 112 366 88 S410 94 441 67 S484 78 516 49 S558 56 592 22 L592 220 L8 220 Z;M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29 L592 220 L8 220 Z" />
                                </path>
                                <path class="hero-chart-line" pathLength="1000" d="M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29">
                                    <animate attributeName="d" dur="10s" repeatCount="indefinite" calcMode="spline" keyTimes="0;0.33;0.66;1" keySplines=".42 0 .58 1;.42 0 .58 1;.42 0 .58 1" values="M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29;M8 175 C38 185 48 150 76 158 S120 168 148 142 S195 152 222 128 S267 138 296 110 S337 124 366 97 S410 110 441 77 S484 91 516 58 S558 63 592 40;M8 194 C38 166 48 174 76 148 S120 158 148 137 S195 143 222 115 S267 124 296 101 S337 112 366 88 S410 94 441 67 S484 78 516 49 S558 56 592 22;M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29" />
                                </path>
                                <path class="hero-chart-trace" pathLength="1000" d="M8 188 C38 178 48 160 76 168 S120 151 148 158 S195 135 222 145 S267 117 296 128 S337 108 366 113 S410 86 441 98 S484 69 516 77 S558 42 592 29" />
                                <circle class="hero-chart-halo" cx="592" cy="29" r="13"><animate attributeName="cy" dur="10s" repeatCount="indefinite" values="29;40;22;29" /></circle>
                                <circle class="hero-chart-point" cx="592" cy="29" r="5"><animate attributeName="cy" dur="10s" repeatCount="indefinite" values="29;40;22;29" /></circle>
                            </svg>
                            <div class="hero-chart-x-labels"><span>WEEK 01</span><span>WEEK 02</span><span>WEEK 03</span><span>WEEK 04</span></div>
                        </div>
                        <div class="hero-dashboard-metrics">
                            <div><span class="hero-metric-icon hero-metric-icon-blue">↗</span><span><small>Projects</small><strong>12 active</strong></span></div>
                            <div><span class="hero-metric-icon hero-metric-icon-mint">✳</span><span><small>Ideas shipped</small><strong>On the rise</strong></span></div>
                            <div class="hero-dashboard-logo"><img src="{{ asset('images/brand/hamzixtech-logo.png') }}" alt="HamzixTech"></div>
                        </div>
                    </div>
                </div>
                <div class="hero-card-bottom"><div><span class="hero-card-label">OUR APPROACH</span><p>Build <span>·</span> Learn <span>·</span> Share</p></div><span class="hero-arrow" aria-hidden="true">↗</span></div>
            </div>
            <div class="hero-stage-caption"><span></span>Digital experiences, built with intention</div>
        </div>
    </div>
</section>
<section class="relative border-y border-soft-border/80 bg-white py-20 sm:py-24 dark:border-white/10 dark:bg-slate-navy/45" data-reveal>
    <div class="mx-auto max-w-7xl px-5 sm:px-8"><div class="section-heading"><p class="section-kicker">What we do</p><h2 class="section-title">Useful technology,<br class="hidden sm:block"> thoughtfully made.</h2><p class="section-description">A thoughtful blend of digital services and practical resources—designed around real needs, built to last.</p></div>
        <div class="mt-12 grid gap-4 md:grid-cols-3">@foreach([['computer-desktop','01','Web experiences','Responsive websites and interfaces designed around clear content and real user needs.'],['cube','02','Software and systems','Web applications, dashboards, APIs, and backend foundations built for maintainability.'],['book-open','03','Technology resources','Articles, tutorials, templates, and small tools for learning and everyday development.']] as [$icon,$number,$title,$body])<article class="service-card group" data-tilt><div class="flex items-start justify-between"><span class="service-icon"><flux:icon :icon="$icon" variant="mini" /></span><span class="service-number">{{ $number }}</span></div><h3 class="mt-8 text-lg font-semibold tracking-tight">{{ $title }}</h3><p class="mt-3 text-sm leading-6 text-muted-text dark:text-soft-slate">{{ $body }}</p><span class="service-accent" aria-hidden="true"></span></article>@endforeach</div>
    </div>
</section>
@foreach([['Featured services',$services,'services.index','services.show','title','summary'],['Selected projects',$projects,'projects.index','projects.show','title','summary'],['Latest articles',$posts,'blog.index','blog.show','title','excerpt'],['Practical tutorials',$tutorials,'tutorials.index','tutorials.show','title','summary'],['Featured templates',$templates,'templates.index','templates.show','title','summary'] ] as [$heading,$items,$indexRoute,$itemRoute,$titleField,$summaryField])
    @if($items->isNotEmpty())<section class="py-20 sm:py-24" data-reveal><div class="mx-auto max-w-7xl px-5 sm:px-8"><div class="flex flex-wrap items-end justify-between gap-4"><div><p class="section-kicker">HamzixTech</p><h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">{{ $heading }}</h2></div><a href="{{ route($indexRoute) }}" class="section-link">View all <span aria-hidden="true">↗</span></a></div><div class="mt-9 grid gap-4 md:grid-cols-3">@foreach($items as $item)<a href="{{ route($itemRoute, $item) }}" class="content-card group" data-tilt><p class="section-kicker text-[10px]">{{ match($indexRoute){'blog.index'=>'Article','tutorials.index'=>'Tutorial','templates.index'=>'Template','services.index'=>'Service',default=>'Project'} }}</p><h3 class="mt-3 text-lg font-semibold group-hover:text-electric-blue">{{ $item->{$titleField} }}</h3><p class="mt-2 line-clamp-3 text-sm leading-6 text-muted-text dark:text-soft-slate">{{ $item->{$summaryField} }}</p><span class="content-card-arrow" aria-hidden="true">↗</span></a>@endforeach</div></div></section>@endif
@endforeach
@if($tools->isNotEmpty())<section class="border-y border-soft-border/80 bg-white py-20 sm:py-24 dark:border-white/10 dark:bg-slate-navy/45" data-reveal><div class="mx-auto max-w-7xl px-5 sm:px-8"><div class="flex flex-wrap items-end justify-between gap-4"><div><p class="section-kicker">Tools and resources</p><h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Small tools for everyday work.</h2></div><a href="{{ route('tools.index') }}" class="section-link">All tools <span aria-hidden="true">↗</span></a></div><div class="mt-9 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">@foreach($tools as $tool)<a href="{{ route('tools.show',$tool) }}" class="tool-card" data-tilt><span class="tool-card-icon"><flux:icon icon="command-line" variant="mini" /></span><h3 class="mt-5 font-semibold">{{ $tool->title }}</h3><p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">{{ $tool->description }}</p><span class="tool-card-arrow" aria-hidden="true">↗</span></a>@endforeach</div></div></section>@endif
<section class="px-5 py-5 sm:px-8" data-reveal><div class="public-page-hero mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 p-7 sm:p-10 lg:flex-row lg:items-center"><div><p class="public-kicker">Explore more</p><h2 class="mt-3 text-2xl font-semibold tracking-tight sm:text-3xl">Learn, experiment, and build.</h2><p class="public-page-description mt-3 max-w-2xl text-sm">Browse practical tutorials, starter resources, and AI experiments. AI features stay clearly marked until a provider is configured.</p></div><div class="flex flex-wrap gap-3"><a class="rounded-full bg-electric-blue px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-electric-blue/20 transition hover:-translate-y-0.5 hover:bg-blue-700" href="{{ route('ai-tools.index') }}">Explore AI tools <span aria-hidden="true">↗</span></a><a class="rounded-full border border-soft-border bg-white/70 px-5 py-3 text-sm font-semibold transition hover:border-electric-blue/40 dark:border-white/10 dark:bg-white/5" href="{{ route('tutorials.index') }}">Browse tutorials</a></div></div></section>
<section class="px-5 py-20 sm:px-8 sm:py-24" data-reveal><div class="cta-panel mx-auto flex max-w-7xl flex-col justify-between gap-8 px-6 py-10 sm:px-10 sm:py-12 lg:flex-row lg:items-center"><div class="max-w-2xl"><p class="section-kicker !text-blue-200">Have an idea?</p><h2 class="mt-3 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Let's build something<br class="hidden sm:block"> meaningful together.</h2><p class="mt-4 leading-7 text-white/65">Share a little about your project, goals, or question and we’ll get back to you.</p></div><flux:button href="{{ route('contact') }}" variant="primary" color="blue" icon:trailing="arrow-right">Contact HamzixTech</flux:button><span class="cta-orb" aria-hidden="true"></span></div></section>
@endsection
