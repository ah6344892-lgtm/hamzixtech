@extends('layouts.app')
@section('title', 'Services | HamzixTech')
@section('meta_description',
    'Explore web design, application development, and backend engineering services from
    HamzixTech.')
@section('content')
    <section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
        <header class="public-page-hero px-6 py-10 sm:px-10 sm:py-14" data-reveal>
            <p class="public-kicker">Services</p>
            <h1 class="public-page-title">Thoughtful digital products, built around your goals.</h1>
            <p class="public-page-description">From a clear first website to a more capable application, explore the services
                and building blocks that can move an idea forward.</p>
            <a href="{{ route('contact') }}"
                class="mt-7 inline-flex rounded-full bg-electric-blue px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-electric-blue/20 transition hover:-translate-y-0.5 hover:bg-blue-700">Discuss
                your project <span class="ml-2" aria-hidden="true">↗</span></a>
        </header>
        @if ($items->isEmpty())
            <div class="public-empty mt-8 text-center">
                <h2 class="font-semibold">Service details are being prepared.</h2>
                <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Contact us to discuss a project.</p><a
                    class="mt-5 inline-flex font-semibold text-electric-blue" href="{{ route('contact') }}">Start a
                    conversation →</a>
            </div>
        @else
            <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <a href="{{ route('services.show', $item) }}" class="public-card group p-6" data-reveal
                        data-reveal-delay="{{ ($loop->index % 3) * 70 }}">
                        <div class="flex items-start justify-between">
                            <span
                                class="flex size-12 items-center justify-center rounded-2xl bg-electric-blue/10 text-electric-blue transition duration-300 group-hover:-rotate-6 group-hover:scale-105">
                                <flux:icon :icon="$item->icon ?: 'squares-2x2'" variant="mini" />
                            </span>
                            <span class="text-xs font-bold tracking-[.15em] text-slate-400">0{{ $loop->iteration }}</span>
                        </div>
                        <h2 class="public-card-title mt-7">{{ $item->title }}</h2>
                        <p class="public-card-copy">{{ $item->summary }}</p>
                        <span class="public-card-link">Explore service <span aria-hidden="true">→</span></span>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $items->links() }}</div>
        @endif
    </section>
    <section class="px-5 pb-16 sm:px-8 sm:pb-20">
        <div
            class="cta-panel mx-auto flex max-w-7xl flex-col items-start justify-between gap-5 p-7 sm:p-10 md:flex-row md:items-center">
            <div class="max-w-2xl">
                <p class="section-kicker !text-blue-200">A good first step</p>
                <h2 class="mt-3 text-2xl font-semibold text-white sm:text-3xl">Bring the rough idea. We’ll shape the next
                    steps.</h2>
                <p class="mt-3 text-sm leading-6 text-white/65">A short conversation can help turn a broad goal into a
                    practical scope.</p>
            </div><a href="{{ route('contact') }}"
                class="shrink-0 rounded-full bg-white px-5 py-3 text-sm font-semibold text-deep-navy transition hover:-translate-y-0.5">Start
                a conversation <span aria-hidden="true">↗</span></a><span class="cta-orb" aria-hidden="true"></span>
        </div>
    </section>
@endsection
