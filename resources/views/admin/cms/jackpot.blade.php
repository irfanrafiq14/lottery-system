@extends('layouts.admin')

@section('title', 'Jackpot')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Current Jackpot Section</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'jackpot'])
    <form method="POST" action="{{ route('admin.cms.jackpot.update') }}" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $jackpot['title']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Fallback Amount (PKR)</label><input type="number" name="amount" value="{{ old('amount', $jackpot['amount']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Tickets Remaining</label><input type="number" name="tickets_remaining" value="{{ old('tickets_remaining', $jackpot['tickets_remaining']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Total Tickets</label><input type="number" name="total_tickets" value="{{ old('total_tickets', $jackpot['total_tickets']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Estimated Winner (PKR)</label><input type="number" name="estimated_winner" value="{{ old('estimated_winner', $jackpot['estimated_winner']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection
