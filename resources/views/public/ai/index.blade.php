@extends('layouts.app')
@section('title', 'AI tools | HamzixTech')
@section('meta_description', 'AI tools and experiments from HamzixTech.')
@section('content')
    <section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
        <header class="public-page-hero px-6 py-10 sm:px-10 sm:py-14" data-reveal>
            <p class="public-kicker">AI lab</p>
            <h1 class="public-page-title">Useful experiments, with transparency.</h1>
            <p class="public-page-description">A place for practical AI-powered ideas. Live tools only appear when an
                implementation and provider are configured—no pretend demos or hidden processing.</p>
        </header>
        @if (!$configured)
            <div class="mt-6 flex items-start gap-4 rounded-2xl border border-amber-500/20 bg-amber-500/[.06] p-5 sm:p-6"
                data-reveal>
                <span
                    class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-300">
                    <flux:icon icon="lock-closed" variant="mini" />
                </span>
                <div>
                    <h2 class="font-semibold">AI features are not configured yet.</h2>
                    <p class="mt-1 text-sm leading-6 text-muted-text dark:text-soft-slate">No provider credentials are set.
                        The example ideas below are not active tools and do not send or process your data.</p>
                </div>
            </div>
        @endif
        @if ($tools->isNotEmpty())
            <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($tools as $tool)
                    <article class="public-card p-6" data-reveal><span
                            class="flex size-11 items-center justify-center rounded-2xl bg-electric-blue/10 text-electric-blue">
                            <flux:icon icon="sparkles" variant="mini" />
                        </span>
                        <h2 class="public-card-title mt-5">{{ $tool->name }}</h2>
                        <p class="public-card-copy">{{ $tool->description }}</p><span
                            class="mt-5 inline-flex w-fit rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-300">Available</span>
                    </article>
                @endforeach
            </div>
        @endif
        <div class="mt-10">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="section-kicker">Ideas on the roadmap</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">Experiments worth exploring</h2>
                </div><span
                    class="rounded-full border border-soft-border px-3 py-1.5 text-xs font-semibold text-muted-text dark:border-white/10 dark:text-soft-slate">Examples
                    only · not active</span>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ([['document-text', 'Writing assistant', 'Explore ways to outline and improve technical documentation with clear review controls.'], ['magnifying-glass', 'Code explainers', 'Make unfamiliar code easier to understand while keeping source handling explicit.'], ['language', 'Translation helper', 'Explore translation workflows that preserve meaning, formatting, and user choice.']] as [$icon, $name, $description])
                    <article class="public-card p-5" data-reveal data-reveal-delay="{{ ($loop->index % 3) * 70 }}"><span
                            class="flex size-10 items-center justify-center rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-300">
                            <flux:icon :icon="$icon" variant="mini" />
                        </span>
                        <h3 class="mt-4 font-semibold">{{ $name }}</h3>
                        <p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">{{ $description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
