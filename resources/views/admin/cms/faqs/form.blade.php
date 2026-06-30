@extends('layouts.admin')

@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">{{ $faq->exists ? 'Edit' : 'Add' }} FAQ</h1>
    @include('admin.cms._nav')
    <form method="POST" action="{{ $faq->exists ? route('admin.cms.faqs.update', $faq) : route('admin.cms.faqs.store') }}" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @if($faq->exists) @method('PUT') @endif
        <div><label class="mb-1 block text-sm font-medium">Question</label><input type="text" name="question" value="{{ old('question', $faq->question) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Answer</label><textarea name="answer" rows="5" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('answer', $faq->answer) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}> Active</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection
