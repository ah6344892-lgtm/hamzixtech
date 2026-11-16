<section class="rounded-2xl border border-soft-border bg-white p-5 shadow-sm sm:p-7 dark:border-white/10 dark:bg-slate-navy">
    <form method="post" action="{{ route('tools.run', $tool) }}" class="space-y-4">
        @csrf
        <div><label for="tool-input" class="block text-sm font-medium">Input</label><textarea id="tool-input" name="input" rows="8" maxlength="50000" class="mt-2 w-full rounded-xl border border-soft-border bg-light-background p-3 font-mono text-sm outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy" placeholder="Paste text here">{{ old('input', $input) }}</textarea>@error('input')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        <div class="flex flex-wrap gap-2">
            @if($tool->slug === 'text-utilities')
                @foreach(['uppercase' => 'Uppercase', 'lowercase' => 'Lowercase', 'trim' => 'Trim spaces', 'count' => 'Count'] as $value => $label)
                    <flux:button type="submit" name="operation" value="{{ $value }}" variant="{{ $loop->first ? 'primary' : 'outline' }}" color="blue">{{ $label }}</flux:button>
                @endforeach
            @elseif($tool->slug === 'url-encoder-decoder')
                <flux:button type="submit" name="operation" value="encode" variant="primary" color="blue">Encode</flux:button>
                <flux:button type="submit" name="operation" value="decode" variant="outline">Decode</flux:button>
            @else
                <flux:button type="submit" name="operation" value="format" variant="primary" color="blue">{{ $tool->slug === 'slug-generator' ? 'Generate slug' : 'Run tool' }}</flux:button>
            @endif
        </div>
    </form>
    @if($error)<p class="mt-4 text-sm text-red-600" role="alert">{{ $error }}</p>@endif
    @if($output !== null)
        <div class="mt-6"><label for="tool-output" class="block text-sm font-medium">Output</label><textarea id="tool-output" readonly rows="8" class="mt-2 w-full rounded-xl border border-soft-border bg-light-background p-3 font-mono text-sm dark:border-white/10 dark:bg-deep-navy">{{ $output }}</textarea></div>
    @endif
</section>
