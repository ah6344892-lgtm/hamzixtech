@extends('layouts.app')

@section('title', 'Staff sign in')
@section('meta_description', 'Sign in to the HamzixTech management area.')
@section('robots','noindex,nofollow')

@section('content')
    <section class="mx-auto flex w-full max-w-7xl flex-1 items-center justify-center px-5 py-14 sm:px-8 sm:py-20">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <span class="mx-auto flex size-16 items-center justify-center overflow-hidden rounded-2xl bg-deep-navy p-1.5 ring-1 ring-black/5">
                    <img src="{{ asset('images/brand/hamzixtech-logo.png') }}" alt="" class="size-full object-contain">
                </span>
                <h1 class="mt-5 text-2xl font-semibold tracking-tight text-dark-text dark:text-white">Staff sign in</h1>
                <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Use your HamzixTech staff account.</p>
            </div>

            <div class="rounded-2xl border border-soft-border bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-slate-navy">
                @if (session('status'))
                    <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-200">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-dark-text dark:text-white">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition placeholder:text-muted-text/70 focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white dark:placeholder:text-soft-slate/60">
                        @error('email')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="password" class="block text-sm font-medium text-dark-text dark:text-white">Password</label>
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-electric-blue hover:underline">Forgot password?</a>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition placeholder:text-muted-text/70 focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white dark:placeholder:text-soft-slate/60">
                        @error('password')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <label class="flex items-center gap-2.5 text-sm text-muted-text dark:text-soft-slate">
                        <input type="checkbox" name="remember" value="1" class="size-4 rounded border-soft-border text-electric-blue focus:ring-electric-blue dark:border-white/20">
                        Remember me
                    </label>
                    @if ($errors->has('email') && ! $errors->has('password'))
                        <p role="alert" class="text-sm text-red-600 dark:text-red-400">{{ $errors->first('email') }}</p>
                    @endif
                    <flux:button type="submit" variant="primary" color="blue" class="w-full">Sign in</flux:button>
                </form>
            </div>
        </div>
    </section>
@endsection
