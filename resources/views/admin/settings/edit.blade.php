@extends('layouts.admin')

@section('title', 'Prize Split Settings')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pools.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to pools</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Prize Split Settings</h1>
        <p class="mt-1 text-sm text-slate-500">Default split for all pools. Individual pools can use this or set their own custom %.</p>
    </div>

    <div class="mx-auto max-w-lg rounded-xl border border-slate-200 bg-white p-6">
        <div class="mb-6 rounded-lg bg-indigo-50 px-4 py-3 text-sm text-indigo-800">
            <strong>Formula:</strong> Total pool = participants × entry fee<br>
            System share = total × system %<br>
            Winner prize = total × winner %
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4" id="split-form">
            @csrf @method('PUT')

            <div>
                <label for="system_share_percent" class="mb-1 block text-sm font-medium text-slate-700">System share (%)</label>
                <input type="number" name="system_share_percent" id="system_share_percent"
                    value="{{ old('system_share_percent', $settings->system_share_percent) }}" required min="0" max="100"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('system_share_percent')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="winner_share_percent" class="mb-1 block text-sm font-medium text-slate-700">Winner prize share (%)</label>
                <input type="number" name="winner_share_percent" id="winner_share_percent"
                    value="{{ old('winner_share_percent', $settings->winner_share_percent) }}" required min="0" max="100"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('winner_share_percent')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <p class="text-sm text-slate-500">Total must equal <strong>100%</strong>. Current: <span id="split-total">{{ $settings->system_share_percent + $settings->winner_share_percent }}</span>%</p>

            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Save percentages
            </button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const system = document.getElementById('system_share_percent');
    const winner = document.getElementById('winner_share_percent');
    const total = document.getElementById('split-total');

    function updateTotal() {
        total.textContent = (parseInt(system.value || 0) + parseInt(winner.value || 0));
    }

    system.addEventListener('input', updateTotal);
    winner.addEventListener('input', updateTotal);
</script>
@endpush
