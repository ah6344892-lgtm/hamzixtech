@extends('layouts.admin')
@section('title', ($record->exists ? 'Edit ' : 'Create ') . $definition['title'])
@section('content')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.' . $resource . '.index') }}" class="text-sm font-semibold text-electric-blue">←
            {{ $definition['title'] }}</a>
    </div>
    <h1 class="mt-3 text-3xl font-bold">{{ $record->exists ? 'Edit item' : 'Create item' }}</h1>
    <form method="post" enctype="multipart/form-data"
        action="{{ $record->exists ? route('admin.' . $resource . '.update', $record->id) : route('admin.' . $resource . '.store') }}"
        class="mt-7 max-w-4xl rounded-2xl border border-soft-border bg-white p-6 sm:p-8 dark:border-white/10 dark:bg-slate-navy">
        @csrf @if ($record->exists)
            @method('PUT')
        @endif
        <div class="grid gap-5 sm:grid-cols-2">
            @foreach ($definition['fields'] as [$name, $label, $type, $required])
                @php($value = old($name, $record->getAttribute($name)))
                @if ($type === 'tags')
                    @if (auth()->user()->can(match ($resource) {
                                    'posts' => 'manage post tags',
                                    'tutorials' => 'manage tutorial tags',
                                    'templates' => 'manage template tags',
                                    default => 'manage post tags',
                                }))
                        <div class="sm:col-span-2"><label for="field-{{ $name }}"
                                class="block text-sm font-medium">{{ $label }}</label><select multiple
                                id="field-{{ $name }}" name="tags[]"
                                class="mt-2 min-h-28 w-full rounded-xl border border-soft-border bg-light-background px-3 py-2 dark:border-white/10 dark:bg-deep-navy">
                                @foreach (\App\Models\Tag::query()->orderBy('name')->get() as $tag)
                                    <option value="{{ $tag->id }}" @selected(collect(old('tags', $record->exists ? $record->tags->pluck('id')->all() : []))->contains($tag->id))>{{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">Hold Ctrl or Command to select
                                multiple.</p>
                        </div>
                    @endif
                @elseif(str_starts_with($type, 'category:'))
                    <div><label for="field-{{ $name }}"
                            class="block text-sm font-medium">{{ $label }}</label><select
                            id="field-{{ $name }}" name="{{ $name }}"
                            class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-3 py-3 dark:border-white/10 dark:bg-deep-navy">
                            <option value="">No category</option>
                            @foreach (\App\Models\Category::query()->where('type', substr($type, 9))->orderBy('name')->get() as $category)
                                <option value="{{ $category->id }}" @selected((string) $value === (string) $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="{{ in_array($type, ['textarea', 'list']) ? 'sm:col-span-2' : '' }}"><label
                            for="field-{{ $name }}" class="block text-sm font-medium">{{ $label }}
                            @if ($required)
                                <span class="text-red-600"> *</span>
                            @endif
                        </label>
                        @if ($type === 'textarea')
                            @if (config('hamzixtech.ui_mode') === 'livewire')
                                <livewire:admin.markdown-editor :name="$name" :label="$label" :value="$value ?? ''"
                                    :required="$required" />
                            @else
                                <textarea id="field-{{ $name }}" name="{{ $name }}" rows="7" @required($required)
                                    class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy">{{ old($name, $value) }}</textarea>
                            @endif
                        @elseif($type === 'list')
                            <textarea id="field-{{ $name }}" name="{{ $name }}" rows="3"
                                class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy">{{ is_array($value) ? implode(', ', $value) : $value }}</textarea>
                        @elseif($type === 'boolean')
                            <label class="mt-3 flex items-center gap-3"><input id="field-{{ $name }}"
                                    type="checkbox" name="{{ $name }}" value="1" @checked((bool) $value)
                                    class="size-4 rounded border-soft-border text-electric-blue focus:ring-electric-blue"><span
                                    class="text-sm">Enabled</span></label>
                        @elseif($type === 'status' || str_starts_with($type, 'select:'))
                            <select id="field-{{ $name }}" name="{{ $name }}" @required($required)
                                class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-3 py-3 dark:border-white/10 dark:bg-deep-navy">
                                @foreach ($type === 'status' ? ['draft', 'published', 'archived'] : explode(',', substr($type, 7)) as $option)
                                    <option value="{{ $option }}" @selected($value === $option)>
                                        {{ ucfirst(str_replace('_', ' ', $option)) }}</option>
                                @endforeach
                            </select>
                        @elseif($type === 'image' || $type === 'file')
                            <input id="field-{{ $name }}" type="file" name="{{ $name }}"
                                accept="{{ $type === 'image' ? 'image/jpeg,image/png,image/webp' : '.zip,.pdf,.txt' }}"
                                class="mt-2 block w-full rounded-xl border border-soft-border bg-light-background px-3 py-2 text-sm dark:border-white/10 dark:bg-deep-navy">
                            @if ($value)
                                <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">Current file:
                                    {{ basename($value) }}</p>
                            @endif
                        @else<input id="field-{{ $name }}"
                                type="{{ match ($type) {'number' => 'number','date' => 'date','datetime' => 'datetime-local','url' => 'url',default => 'text'} }}"
                                name="{{ $name }}"
                                value="{{ $value instanceof \Carbon\CarbonInterface ? $value->format($type === 'date' ? 'Y-m-d' : 'Y-m-d\TH:i') : $value }}"
                                @required($required)
                                class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 outline-none focus:ring-2 focus:ring-electric-blue dark:border-white/10 dark:bg-deep-navy">
                        @endif
                        @error($name)
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            @endforeach
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <flux:button type="submit" variant="primary" color="blue">{{ $record->exists ? 'Save changes' : 'Save item' }}
            </flux:button><a href="{{ route('admin.' . $resource . '.index') }}"
                class="rounded-lg border border-soft-border px-4 py-2.5 text-sm font-semibold dark:border-white/10">Cancel</a>
        </div>
    </form>
@endsection
