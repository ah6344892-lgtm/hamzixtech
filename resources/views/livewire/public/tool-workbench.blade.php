<section class="rounded-2xl border border-soft-border bg-white p-5 shadow-sm sm:p-7 dark:border-white/10 dark:bg-slate-navy">
    <label for="tool-input" class="block text-sm font-medium">Input</label>
    <textarea id="tool-input" wire:model="input" rows="8" class="mt-2 w-full rounded-xl border border-soft-border bg-light-background p-3 font-mono text-sm outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy" placeholder="Paste text here"></textarea>
    <div class="mt-4 flex flex-wrap gap-2">
        @if($slug === 'text-utilities')
            <flux:button wire:click="run('uppercase')" variant="primary" color="blue">Uppercase</flux:button>
            <flux:button wire:click="run('lowercase')" variant="outline">Lowercase</flux:button>
            <flux:button wire:click="run('trim')" variant="outline">Trim spaces</flux:button>
            <flux:button wire:click="run('count')" variant="outline">Count</flux:button>
        @elseif($slug === 'url-encoder-decoder')
            <flux:button wire:click="run('encode')" variant="primary" color="blue">Encode</flux:button>
            <flux:button wire:click="run('decode')" variant="outline">Decode</flux:button>
        @else
            <flux:button wire:click="run" variant="primary" color="blue">Run tool</flux:button>
        @endif
        @if($slug === 'slug-generator') <flux:button wire:click="run" variant="outline">Generate slug</flux:button> @endif
    </div>
    @if($error)<p class="mt-4 text-sm text-red-600" role="alert">{{ $error }}</p>@endif
    @if($output !== '')
        <div class="mt-6">
            <label for="tool-output" class="block text-sm font-medium">Output</label>
            <textarea id="tool-output" readonly rows="8" class="mt-2 w-full rounded-xl border border-soft-border bg-light-background p-3 font-mono text-sm dark:border-white/10 dark:bg-deep-navy">{{ $output }}</textarea>
        </div>
    @endif
</section>
