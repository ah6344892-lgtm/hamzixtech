@extends('layouts.admin')
@section('title', 'Staff accounts')
@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-electric-blue">Administration</p>
            <h1 class="mt-2 text-3xl font-bold">Staff accounts</h1>
            <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">Access is limited to invited staff accounts.</p>
        </div>
        @can('create', App\Models\User::class)
            <a href="{{ route('admin.users.create') }}"
                class="rounded-lg bg-electric-blue px-4 py-2.5 text-sm font-semibold text-white">Add staff member</a>
        @endcan
    </div>
    <form method="get" class="mt-6 flex gap-3"><input name="q" value="{{ request('q') }}"
            placeholder="Search name or email"
            class="flex-1 rounded-xl border border-soft-border bg-white px-4 py-2.5 dark:border-white/10 dark:bg-slate-navy"><button
            class="rounded-xl border border-soft-border px-4 py-2.5 text-sm font-semibold dark:border-white/10">Search</button>
    </form>
    <div
        class="mt-5 overflow-x-auto rounded-2xl border border-soft-border bg-white dark:border-white/10 dark:bg-slate-navy">
        <table class="w-full min-w-[680px] text-left text-sm">
            <thead class="bg-light-background text-xs uppercase text-muted-text dark:bg-deep-navy dark:text-soft-slate">
                <tr>
                    <th class="px-4 py-3">Staff member</th>
                    <th class="px-4 py-3">Role(s)</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Last login</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-soft-border dark:divide-white/10">
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold">{{ $user->name }}</p>
                            <p class="mt-1 text-xs text-muted-text dark:text-soft-slate">{{ $user->email }}</p>
                        </td>
                        <td class="px-4 py-4">{{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}</td>
                        <td class="px-4 py-4"><span
                                class="rounded-full px-2.5 py-1 text-xs {{ $user->is_active ? 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300' : 'bg-red-500/10 text-red-700 dark:text-red-300' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="px-4 py-4 text-muted-text dark:text-soft-slate">
                            {{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                @can('update', $user)
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="font-semibold text-electric-blue">Edit</a>
                                    @endcan @can('delete', $user)
                                    <form method="post" action="{{ route('admin.users.destroy', $user) }}"
                                        onsubmit="return confirm('Permanently delete this staff account?')">@csrf
                                        @method('DELETE')<button type="submit"
                                            class="font-semibold text-red-600">Delete</button></form>
                                    @endcan @if (!auth()->user()->can('update', $user) && !auth()->user()->can('delete', $user))
                                        <span class="text-xs text-muted-text">Protected</span>
                                    @endif
                                </div>
                            </td>
                    </tr>@empty<tr>
                            <td class="p-8 text-center text-muted-text" colspan="5">No staff accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $users->links() }}</div>
    @endsection
