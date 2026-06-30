@extends('layouts.admin')

@section('title', 'Landing Winners')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Landing Page Winners</h1>
        <a href="{{ route('admin.cms.winners.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add Winner</a>
    </div>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'winners'])
    <div class="mt-6 overflow-hidden rounded-xl border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Prize</th><th class="px-4 py-3 text-left">Country</th><th class="px-4 py-3">Actions</th></tr></thead>
            <tbody class="divide-y">
                @foreach($winners as $w)
                    <tr><td class="px-4 py-3">{{ $w->name }}</td><td class="px-4 py-3">{{ number_format($w->prize_amount) }} PKR</td><td class="px-4 py-3">{{ $w->country }}</td>
                        <td class="px-4 py-3"><a href="{{ route('admin.cms.winners.edit', $w) }}" class="text-indigo-600">Edit</a>
                        <form method="POST" action="{{ route('admin.cms.winners.destroy', $w) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="ml-2 text-red-600">Delete</button></form></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
