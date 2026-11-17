<div class="sm:col-span-2" x-data="{ wrap(open, close) { const field = $refs.markdown; const start = field.selectionStart; const end = field.selectionEnd; const selected = field.value.slice(start, end) || 'text';
        field.setRangeText(open + selected + close, start, end, 'select');
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.focus(); } }">
    <div class="flex flex-wrap items-center justify-between gap-2"><label for="markdown-{{ $name }}"
            class="block text-sm font-medium">{{ $label }} <span
                class="font-normal text-muted-text dark:text-soft-slate">(Markdown)</span></label>
        <div class="flex gap-1"><button type="button" x-on:click="wrap('**','**')"
                class="rounded border border-soft-border px-2 py-1 text-xs font-bold dark:border-white/10"
                aria-label="Bold">B</button><button type="button" x-on:click="wrap('*','*')"
                class="rounded border border-soft-border px-2 py-1 text-xs italic dark:border-white/10"
                aria-label="Italic">I</button><button type="button" x-on:click="wrap('`','`')"
                class="rounded border border-soft-border px-2 py-1 text-xs font-mono dark:border-white/10"
                aria-label="Inline code">&lt;/&gt;</button><button type="button" x-on:click="wrap('[','](https://)')"
                class="rounded border border-soft-border px-2 py-1 text-xs dark:border-white/10"
                aria-label="Link">Link</button></div>
    </div>
    <textarea id="markdown-{{ $name }}" name="{{ $name }}" wire:model.live.debounce.300ms="value"
        rows="7" @required($required)
        class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 font-mono text-sm leading-6 outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy"></textarea>
    <details class="mt-3 rounded-xl border border-soft-border dark:border-white/10">
        <summary class="cursor-pointer px-3 py-2 text-xs font-semibold">Preview formatted content</summary>
        <div class="prose-content px-4 pb-4 pt-2 text-sm leading-6">{!! \Illuminate\Support\Str::markdown($value, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
    </details>
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
