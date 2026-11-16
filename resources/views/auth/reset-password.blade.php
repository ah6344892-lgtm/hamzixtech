@extends('layouts.app')

@section('title', 'Choose a new password')
@section('robots','noindex,nofollow')

@section('content')
    <section class="mx-auto flex w-full max-w-7xl flex-1 items-center justify-center px-5 py-14 sm:px-8 sm:py-20">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-dark-text dark:text-white">Choose a new password</h1>
                <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Set a new password for your staff account.</p>
            </div>
            <div class="rounded-2xl border border-soft-border bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-slate-navy">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-dark-text dark:text-white">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" autocomplete="email" required autofocus
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white">
                        @error('email')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-dark-text dark:text-white">New password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white">
                        @error('password')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-dark-text dark:text-white">Confirm new password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="w-full rounded-xl border border-soft-border bg-white px-4 py-3 text-sm text-dark-text outline-none transition focus:border-electric-blue focus:ring-4 focus:ring-electric-blue/10 dark:border-white/15 dark:bg-deep-navy dark:text-white">
                    </div>
                    <flux:button type="submit" variant="primary" color="blue" class="w-full">Save new password</flux:button>
                </form>
            </div>
        </div>
    </section>
@endsection
