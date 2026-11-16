@extends('layouts.app')

@section('title', 'HamzixTech | Modern Websites and Software')
@section('meta_description', 'HamzixTech is building a technology platform for modern web experiences, useful software, and practical technology resources.')

@section('content')
    <section class="relative isolate overflow-hidden">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16 lg:py-28">
            <div class="max-w-2xl">
                <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-electric-blue/20 bg-electric-blue/5 px-3.5 py-1.5 text-sm font-medium text-electric-blue dark:border-electric-blue/30 dark:bg-electric-blue/10">
                    <span class="size-1.5 rounded-full bg-electric-blue"></span>
                    A technology platform by HamzixTech
                </p>
                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-dark-text sm:text-5xl lg:text-6xl dark:text-white">
                    Modern websites and software, built with care.
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-muted-text dark:text-soft-slate">
                    HamzixTech brings digital experiences and practical technology resources together in one thoughtful platform.
                </p>
                <div class="mt-9 flex flex-wrap items-center gap-3">
                    <flux:button href="#foundation" variant="primary" color="blue" icon:trailing="arrow-down">Explore our approach</flux:button>
                    <flux:button href="{{ route('login') }}" variant="outline">Staff sign in</flux:button>
                </div>
                <p class="mt-5 text-sm text-muted-text dark:text-soft-slate">A clear, useful experience from the first visit.</p>
            </div>

            <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="absolute -inset-5 -z-10 rounded-[2.5rem] bg-electric-blue/5 blur-2xl dark:bg-electric-blue/10"></div>
                <div class="rounded-[2rem] border border-soft-border bg-white p-5 shadow-xl shadow-slate-900/5 sm:p-7 dark:border-white/10 dark:bg-slate-navy dark:shadow-black/20">
                    <div class="flex min-h-[18rem] flex-col items-center justify-center rounded-[1.5rem] bg-deep-navy px-8 py-10 text-center sm:min-h-[21rem]">
                        <img src="{{ asset('images/brand/hamzixtech-logo.png') }}" alt="HamzixTech HT monogram" class="size-36 object-contain sm:size-44">
                        <p class="mt-6 text-xs font-semibold uppercase tracking-[0.24em] text-white/65">Build · Learn · Share</p>
                    </div>
                    <div class="flex items-center justify-between gap-4 px-1 pt-5">
                        <div>
                            <p class="font-semibold text-dark-text dark:text-white">HamzixTech</p>
                            <p class="mt-1 text-sm text-muted-text dark:text-soft-slate">Digital solutions and resources</p>
                        </div>
                        <span class="flex size-10 items-center justify-center rounded-full bg-electric-blue/10 text-electric-blue dark:bg-electric-blue/15">
                            <flux:icon icon="bolt" variant="mini" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="foundation" class="border-t border-soft-border bg-white py-16 sm:py-20 dark:border-white/10 dark:bg-slate-navy/45">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-8">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-electric-blue">Our approach</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-dark-text sm:text-4xl dark:text-white">Useful technology, thoughtfully presented.</h2>
                <p class="mt-4 leading-7 text-muted-text dark:text-soft-slate">
                    The platform is being built around a few simple priorities: clarity, practical value, and a reliable foundation.
                </p>
            </div>

            <div class="mt-10 grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl border border-soft-border bg-light-background p-6 dark:border-white/10 dark:bg-deep-navy">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-electric-blue/10 text-electric-blue dark:bg-electric-blue/15"><flux:icon icon="computer-desktop" variant="mini" /></span>
                    <h3 class="mt-5 text-lg font-semibold text-dark-text dark:text-white">Digital experiences</h3>
                    <p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">Clear, responsive interfaces that make information and services easier to use.</p>
                </article>
                <article class="rounded-2xl border border-soft-border bg-light-background p-6 dark:border-white/10 dark:bg-deep-navy">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-electric-blue/10 text-electric-blue dark:bg-electric-blue/15"><flux:icon icon="cube" variant="mini" /></span>
                    <h3 class="mt-5 text-lg font-semibold text-dark-text dark:text-white">Useful software</h3>
                    <p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">Maintainable foundations for web applications, tools, and business workflows.</p>
                </article>
                <article class="rounded-2xl border border-soft-border bg-light-background p-6 dark:border-white/10 dark:bg-deep-navy">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-electric-blue/10 text-electric-blue dark:bg-electric-blue/15"><flux:icon icon="book-open" variant="mini" /></span>
                    <h3 class="mt-5 text-lg font-semibold text-dark-text dark:text-white">Practical resources</h3>
                    <p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">A growing home for technology articles, learning material, and reusable resources.</p>
                </article>
            </div>
        </div>
    </section>
@endsection
