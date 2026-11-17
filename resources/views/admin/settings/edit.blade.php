@extends('layouts.admin')
@section('title', 'Site settings')
@section('content')
    <div>
        <p class="text-sm font-semibold uppercase tracking-widest text-electric-blue">Configuration</p>
        <h1 class="mt-2 text-3xl font-bold">Site settings</h1>
        <p class="mt-2 max-w-3xl text-sm leading-6 text-muted-text dark:text-soft-slate">Contact details, social profiles,
            and editable public copy. Empty contact or social values stay hidden on the public site.</p>
    </div>
    <form method="post" action="{{ route('admin.settings.update') }}" class="mt-7 max-w-5xl space-y-6">@csrf @method('PUT')
        <section class="rounded-2xl border border-soft-border bg-white p-6 dark:border-white/10 dark:bg-slate-navy">
            <h2 class="text-lg font-semibold">Public information</h2>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div><label for="home_headline" class="block text-sm font-medium">Homepage headline</label><input
                        id="home_headline" name="home_headline" maxlength="180"
                        value="{{ old('home_headline', $settings['home.headline']->value ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">
                </div>
                <div><label for="home_introduction" class="block text-sm font-medium">Homepage introduction</label>
                    <textarea id="home_introduction" name="home_introduction" rows="3"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">{{ old('home_introduction', $settings['home.introduction']->value ?? '') }}</textarea>
                </div>
                <div class="sm:col-span-2"><label for="about_introduction" class="block text-sm font-medium">About page
                        copy</label>
                    <textarea id="about_introduction" name="about_introduction" rows="5"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">{{ old('about_introduction', $settings['about.introduction']->value ?? '') }}</textarea>
                </div>
                <div><label for="contact_email" class="block text-sm font-medium">Contact email</label><input
                        id="contact_email" type="email" name="contact_email"
                        value="{{ old('contact_email', $settings['contact.email']->value ?? config('hamzixtech.contact_email')) }}"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">
                    @error('contact_email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div><label for="whatsapp_number" class="block text-sm font-medium">WhatsApp number with country
                        code</label><input id="whatsapp_number" name="whatsapp_number"
                        value="{{ old('whatsapp_number', $settings['contact.whatsapp']->value ?? config('hamzixtech.whatsapp_number')) }}"
                        placeholder="e.g. +country code and number"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">
                    @error('whatsapp_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2"><label for="whatsapp_message" class="block text-sm font-medium">Optional WhatsApp
                        prefilled message</label><input id="whatsapp_message" name="whatsapp_message"
                        value="{{ old('whatsapp_message', $settings['contact.whatsapp_message']->value ?? '') }}"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">
                </div>
            </div>
        </section>
        <section class="rounded-2xl border border-soft-border bg-white p-6 dark:border-white/10 dark:bg-slate-navy">
            <h2 class="text-lg font-semibold">Social profiles</h2>
            <div class="mt-4 space-y-4">
                @foreach ($socialLinks as $link)
                    <div class="grid gap-3 sm:grid-cols-[140px_1fr_2fr_auto] sm:items-end">
                        <div><label class="block text-xs font-medium">Platform</label><input
                                value="{{ ucfirst($link->platform) }}" disabled
                                class="mt-1 w-full rounded-lg border border-soft-border bg-light-background px-3 py-2 text-sm dark:border-white/10 dark:bg-deep-navy">
                        </div>
                        <div><label for="social-label-{{ $link->id }}"
                                class="block text-xs font-medium">Label</label><input id="social-label-{{ $link->id }}"
                                name="social[{{ $link->platform }}][label]"
                                value="{{ old('social.' . $link->platform . '.label', $link->label) }}"
                                class="mt-1 w-full rounded-lg border border-soft-border bg-light-background px-3 py-2 text-sm dark:border-white/10 dark:bg-deep-navy">
                        </div>
                        <div><label for="social-url-{{ $link->id }}" class="block text-xs font-medium">Profile
                                URL</label><input id="social-url-{{ $link->id }}" type="url"
                                name="social[{{ $link->platform }}][url]"
                                value="{{ old('social.' . $link->platform . '.url', $link->url) }}" placeholder="https://"
                                class="mt-1 w-full rounded-lg border border-soft-border bg-light-background px-3 py-2 text-sm dark:border-white/10 dark:bg-deep-navy">
                        </div><label class="flex items-center gap-2 text-xs"><input type="checkbox"
                                name="social[{{ $link->platform }}][enabled]" value="1" @checked(old('social.' . $link->platform . '.enabled', $link->enabled))
                                class="rounded border-soft-border text-electric-blue">Enabled</label>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="rounded-2xl border border-soft-border bg-white p-6 dark:border-white/10 dark:bg-slate-navy">
            <h2 class="text-lg font-semibold">Legal pages</h2>
            <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">Review this copy against your actual deployment,
                analytics, mail and retention setup before launch.</p>
            <div class="mt-5 space-y-5">
                <div><label for="privacy_policy" class="block text-sm font-medium">Privacy policy</label>
                    <textarea id="privacy_policy" name="privacy_policy" rows="8"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">{{ old('privacy_policy', $settings['legal.privacy_policy']->value ?? '') }}</textarea>
                </div>
                <div><label for="terms" class="block text-sm font-medium">Terms and conditions</label>
                    <textarea id="terms" name="terms" rows="8"
                        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">{{ old('terms', $settings['legal.terms']->value ?? '') }}</textarea>
                </div>
            </div>
        </section>
        <flux:button type="submit" variant="primary" color="blue">Save settings</flux:button>
    </form>
@endsection
