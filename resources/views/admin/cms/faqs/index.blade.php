@extends('layouts.admin')

@section('title', 'FAQ')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">FAQ</h1>
        <a href="{{ route('admin.cms.faqs.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add FAQ</a>
    </div>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'faqs'])
    <div class="mt-6 overflow-hidden rounded-xl border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="px-4 py-3 text-left">Question</th><th class="px-4 py-3">Actions</th></tr></thead>
            <tbody class="divide-y">
                @foreach($faqs as $faq)
                    <tr><td class="px-4 py-3">{{ Str::limit($faq->question, 60) }}</td>
                        <td class="px-4 py-3"><a href="{{ route('admin.cms.faqs.edit', $faq) }}" class="text-indigo-600">Edit</a>
                        <form method="POST" action="{{ route('admin.cms.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="ml-2 text-red-600">Delete</button></form></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
