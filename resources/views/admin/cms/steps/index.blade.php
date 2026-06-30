@extends('layouts.admin')

@section('title', 'How It Works Steps')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">How It Works Steps</h1>
        <a href="{{ route('admin.cms.steps.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add Step</a>
    </div>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'steps'])
    <div class="mt-6 overflow-hidden rounded-xl border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left"><tr><th class="px-4 py-3">#</th><th class="px-4 py-3">Title</th><th class="px-4 py-3">Active</th><th class="px-4 py-3">Actions</th></tr></thead>
            <tbody class="divide-y">
                @foreach($steps as $step)
                    <tr>
                        <td class="px-4 py-3">{{ $step->step_number }}</td>
                        <td class="px-4 py-3">{{ $step->title }}</td>
                        <td class="px-4 py-3">{{ $step->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.cms.steps.edit', $step) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.cms.steps.destroy', $step) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="ml-2 text-red-600">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
