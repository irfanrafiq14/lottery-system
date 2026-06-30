@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Users</h1>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Verified</th>
                    <th class="px-4 py-3">Entries</th>
                    <th class="px-4 py-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->isEmailVerified())
                                <span class="text-emerald-600">Yes</span>
                            @else
                                <span class="text-slate-400">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $user->entries_count }}</td>
                        <td class="px-4 py-3">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
