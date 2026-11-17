@extends('layouts.app')
@section('title', $title . ' | HamzixTech')
@section('meta_description', $description)
@section('content')
    <section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
        <header class="public-page-hero px-6 py-10 sm:px-10 sm:py-14" data-reveal>
            <p class="public-kicker">
                {{ $kind === 'posts' ? 'From the journal' : ($kind === 'tutorials' ? 'Learn by doing' : 'Ready-to-use resources') }}
            </p>
            <h1 class="public-page-title">{{ $title }}</h1>
            <p class="public-page-description">{{ $description }}</p>
            <div class="mt-7 flex flex-wrap gap-2 text-xs font-medium">
                @if ($kind === 'posts')
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Ideas
                        &amp; notes</span>
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Web
                        development</span>
                @elseif($kind === 'tutorials')
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Step
                        by step</span>
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Practical
                        examples</span>
                @else
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Starter
                        resources</span>
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">Example
                        blueprints</span>
                @endif
            </div>
        </header>
        @if ($items->isEmpty())
            <div class="public-empty mt-8 text-center" data-reveal>
                <span
                    class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-electric-blue/10 text-electric-blue">
                    <flux:icon icon="sparkles" variant="mini" />
                </span>
                <h2 class="mt-4 text-lg font-semibold">Fresh resources are on the way.</h2>
                <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-muted-text dark:text-soft-slate">New resources will
                    appear here as they are prepared. In the meantime, explore the tools or get in touch.</p>
                <a class="mt-5 inline-flex rounded-full bg-electric-blue px-4 py-2.5 text-sm font-semibold text-white"
                    href="{{ route('tools.index') }}">Explore developer tools <span class="ml-2"
                        aria-hidden="true">↗</span></a>
            </div>
        @else
            <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    @php(
    $url = match ($kind) {
        'posts' => route('blog.show', $item),
        'tutorials' => route('tutorials.show', $item),
        'templates' => route('templates.show', $item),
        default => route('home')
    }
)
                    @php($cardTitle = $item->title)
                    @php($cardSummary = $item->excerpt ?? ($item->summary ?? null))
                    <a href="{{ $url }}" class="public-card group" data-reveal
                        data-reveal-delay="{{ ($loop->index % 3) * 70 }}">
                        @if (($item->featured_image ?? null) || ($item->cover_image ?? null) || ($item->thumbnail ?? null))
                            <img src="{{ Storage::url($item->featured_image ?? ($item->cover_image ?? $item->thumbnail)) }}"
                                alt="{{ $item->featured_image_alt ?? ($item->cover_image_alt ?? ($item->thumbnail_alt ?? '')) }}"
                                class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                        @else
                            <div class="public-card-art public-card-art-{{ ($loop->index % 3) + 1 }}">
                                <span class="public-card-art-label">
                                    <flux:icon
                                        :icon="$kind === 'tutorials' ? 'academic-cap' : ($kind === 'templates' ?
                                            'rectangle-stack' : 'document-text')"
                                        variant="mini" />
                                    {{ $kind === 'posts' ? 'FIELD NOTES' : strtoupper(rtrim($kind, 's')) }}
                                </span>
                            </div>
                        @endif
                        <div class="public-card-body">
                            @if ($item->category)
                                <p class="text-[11px] font-bold uppercase tracking-[.13em] text-electric-blue">
                                    {{ $item->category->name }}</p>
                            @endif
                            <h2 class="public-card-title mt-2">{{ $cardTitle }}</h2>
                            @if ($cardSummary)
                                <p class="public-card-copy line-clamp-3">{{ $cardSummary }}</p>
                            @endif
                            @if ($kind === 'tutorials')
                                <p class="mt-4 text-xs font-medium text-muted-text dark:text-soft-slate">
                                    {{ ucfirst($item->difficulty) }}@if ($item->estimated_minutes)
                                        <span class="mx-1 text-electric-blue">·</span> {{ $item->estimated_minutes }} min
                                        read
                                    @endif
                                </p>
                            @elseif($kind === 'templates')
                                <p class="mt-4 text-xs font-medium text-muted-text dark:text-soft-slate">
                                    {{ ucfirst($item->pricing_type) }} resource @if ($item->version)
                                        <span class="mx-1 text-electric-blue">·</span> v{{ $item->version }}
                                    @endif
                                </p>
                            @elseif($item->published_at)
                                <p class="mt-4 text-xs font-medium text-muted-text dark:text-soft-slate">
                                    {{ $item->published_at->format('M j, Y') }}</p>
                            @endif
                            <span
                                class="public-card-link">{{ $kind === 'tutorials' ? 'Start learning' : ($kind === 'templates' ? 'Explore resource' : 'Read article') }}
                                <span aria-hidden="true">→</span></span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-9">{{ $items->links() }}</div>
        @endif
    </section>
@endsection
