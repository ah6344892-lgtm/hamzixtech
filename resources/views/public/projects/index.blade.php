@extends('layouts.app')
@section('title','Projects | HamzixTech')
@section('meta_description','Explore interface concepts and project examples published by HamzixTech.')
@section('content')
<section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
    <header class="public-page-hero px-6 py-10 sm:px-10 sm:py-14" data-reveal>
        <p class="public-kicker">Projects &amp; concepts</p>
        <h1 class="public-page-title">Ideas made visible.</h1>
        <p class="public-page-description">A growing collection of interface concepts and example builds. Each sample is clearly identified so you can explore the layout without mistaking it for a client case study.</p>
    </header>
    @if($items->isEmpty())
        <div class="public-empty mt-8 text-center"><span class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-electric-blue/10 text-electric-blue"><flux:icon icon="window" variant="mini" /></span><h2 class="mt-4 font-semibold">Project examples are being prepared.</h2><p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Check back soon for new work and concepts.</p></div>
    @else
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach($items as $item)
                <a href="{{ route('projects.show',$item) }}" class="public-card group" data-reveal data-reveal-delay="{{ ($loop->index % 3) * 70 }}">
                    @if($item->main_image)
                        <img src="{{ Storage::url($item->main_image) }}" alt="{{ $item->main_image_alt }}" class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                    @else
                        <div class="public-card-art public-card-art-{{ (($loop->index % 3) + 1) }}">
                            <span class="public-card-art-label"><flux:icon icon="window" variant="mini" />{{ $item->category?->name ?: 'DESIGN CONCEPT' }}</span>
                            <div class="absolute right-8 top-6 z-[1] w-2/5 rounded-xl border border-white/60 bg-white/70 p-2 shadow-xl shadow-slate-900/10 backdrop-blur"><div class="h-2 w-2/3 rounded-full bg-electric-blue/30"></div><div class="mt-2 grid grid-cols-3 gap-1"><i class="h-8 rounded bg-electric-blue/10"></i><i class="h-8 rounded bg-violet-400/15"></i><i class="h-8 rounded bg-cyan-400/15"></i></div><div class="mt-2 h-7 rounded bg-slate-400/10"></div></div>
                        </div>
                    @endif
                    <div class="public-card-body">
                        <p class="text-[11px] font-bold uppercase tracking-[.13em] text-electric-blue">{{ $item->category?->name ?: 'Example project' }}</p>
                        <h2 class="public-card-title mt-2">{{ $item->title }}</h2>
                        <p class="public-card-copy line-clamp-3">{{ $item->summary }}</p>
                        @if($item->technologies)<p class="mt-4 text-xs font-medium text-muted-text dark:text-soft-slate">{{ implode(' · ', $item->technologies) }}</p>@endif
                        <span class="public-card-link">View concept <span aria-hidden="true">→</span></span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $items->links() }}</div>
    @endif
</section>
@endsection
