@extends('layouts.app')

@section('title', 'Reset your password')
@section('robots', 'noindex,nofollow')

@section('content')
    <section class="mx-auto flex w-full max-w-7xl flex-1 items-center justify-center px-5 py-14 sm:px-8 sm:py-20">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-dark-text dark:text-white">Reset your password</h1>
                <p class="mt-2 text-sm leading-6 text-muted-text dark:text-soft-slate">Enter your staff account email and
                    we’ll send a reset link if the account exists.</p>
            </div>
            <div
                class="rounded-2xl border border-soft-border bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-slate-navy">
                @if (session('status'))
                    <div role="status"
                        class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-200">
                        {{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-dark-text dark:text-white">Email
                            address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email"
                            required autofocus
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <flux:button type="submit" variant="primary" color="blue" class="w-full">Email password reset link
                    </flux:button>
                </form>
                <p class="mt-5 text-center text-sm"><a href="{{ route('login') }}"
                        class="font-medium text-electric-blue hover:underline">Return to sign in</a></p>
            </div>
        </div>
    </section>
@endsection
