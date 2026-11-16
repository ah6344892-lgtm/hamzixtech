@extends('layouts.app')
@section('title','Developer Tools | HamzixTech')
@section('meta_description','Small, privacy-respecting tools for everyday development tasks.')
@section('content')
<section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
    <header class="public-page-hero px-6 py-10 sm:px-10 sm:py-14" data-reveal>
        <p class="public-kicker">The developer toolkit</p>
        <h1 class="public-page-title">Little helpers. Less busywork.</h1>
        <p class="public-page-description">Quick utilities for common development tasks. Run a tool, review the result, and keep moving. Input is processed for the request and is not saved.</p>
        <div class="mt-7 flex flex-wrap gap-2"><span class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 text-xs font-medium dark:border-white/10 dark:bg-white/5">JSON</span><span class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 text-xs font-medium dark:border-white/10 dark:bg-white/5">Text</span><span class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 text-xs font-medium dark:border-white/10 dark:bg-white/5">URLs</span></div>
    </header>
    @if($tools->isEmpty())
        <div class="public-empty mt-8 text-center"><h2 class="font-semibold">New tools are being prepared.</h2><p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Check back soon for practical utilities.</p></div>
    @else
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tools as $tool)
                <a href="{{ route('tools.show',$tool) }}" class="public-card group p-6" data-reveal data-reveal-delay="{{ ($loop->index % 3) * 70 }}">
                    <div class="flex items-start justify-between"><span class="flex size-12 items-center justify-center rounded-2xl bg-electric-blue/10 text-electric-blue transition duration-300 group-hover:-rotate-6 group-hover:scale-105"><flux:icon icon="wrench-screwdriver" variant="mini" /></span><span class="rounded-full bg-emerald-500/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-300">Ready to use</span></div>
                    <h2 class="public-card-title mt-7">{{ $tool->title }}</h2>
                    <p class="public-card-copy">{{ $tool->description }}</p>
                    <span class="public-card-link">Open tool <span aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
    @endif
    <aside class="mt-8 flex flex-col gap-4 rounded-2xl border border-soft-border bg-white/70 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6 dark:border-white/10 dark:bg-white/[.03]"><div><p class="text-sm font-semibold">Built for quick, focused tasks</p><p class="mt-1 text-sm text-muted-text dark:text-soft-slate">No accounts, saved history, or unnecessary setup for these utilities.</p></div><a href="{{ route('contact') }}" class="shrink-0 text-sm font-semibold text-electric-blue">Suggest a tool <span aria-hidden="true">↗</span></a></aside>
</section>
@endsection
