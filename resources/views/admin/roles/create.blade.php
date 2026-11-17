@extends('layouts.admin')
@section('title', 'Create role')
@section('content')
    <a href="{{ route('admin.roles.index') }}" class="text-sm font-semibold text-electric-blue">
        ← Roles</a>
    <h1 class="mt-3 text-3xl font-bold">Create role</h1>
    <form method="post" action="{{ route('admin.roles.store') }}"
        class="mt-7 max-w-5xl rounded-2xl border border-soft-border bg-white p-6 sm:p-8 dark:border-white/10 dark:bg-slate-navy">
        @csrf<div class="max-w-md"><label for="name" class="block text-sm font-medium">Role name</label><input
                id="name" name="name" value="{{ old('name') }}" required maxlength="64"
                class="mt-2 w-full rounded-xl border border-soft-border bg-light-background px-4 py-3 dark:border-white/10 dark:bg-deep-navy">
            @error('name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-7 grid gap-5 xl:grid-cols-2">
            @foreach ($permissionGroups as $group => $permissions)
                <fieldset>
                    <legend class="mb-2 text-xs font-bold uppercase tracking-wider text-muted-text dark:text-soft-slate">
                        {{ str_replace('_', ' ', $group) }}</legend>
                    <div class="grid gap-1 sm:grid-cols-2">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-xs"><input type="checkbox"
                                    name="permissions[]" value="{{ $permission }}" @checked(in_array($permission, old('permissions', []), true))
                                    @disabled(!auth()->user()->hasRole('Super Admin') && !auth()->user()->can($permission))
                                    class="rounded border-soft-border text-electric-blue"><span>{{ $permission }}</span></label>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
        </div>
        <div class="mt-7">
            <flux:button type="submit" variant="primary" color="blue">Create role</flux:button>
        </div>
    </form>
@endsection
