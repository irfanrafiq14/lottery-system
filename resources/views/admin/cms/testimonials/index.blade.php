@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Testimonials</h1>
        <a href="{{ route('admin.cms.testimonials.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Add Testimonial</a>
    </div>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'testimonials'])
    <div class="mt-6 overflow-hidden rounded-xl border bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Country</th><th class="px-4 py-3">Actions</th></tr></thead>
            <tbody class="divide-y">
                @foreach($testimonials as $t)
                    <tr><td class="px-4 py-3">{{ $t->name }}</td><td class="px-4 py-3">{{ $t->country }}</td>
                        <td class="px-4 py-3"><a href="{{ route('admin.cms.testimonials.edit', $t) }}" class="text-indigo-600">Edit</a>
                        <form method="POST" action="{{ route('admin.cms.testimonials.destroy', $t) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="ml-2 text-red-600">Delete</button></form></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
