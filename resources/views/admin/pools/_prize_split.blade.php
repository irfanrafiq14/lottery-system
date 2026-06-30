@php
    $useDefault = old('use_default_split') !== null
        ? (bool) old('use_default_split')
        : ($pool->exists ? $pool->usesDefaultSplit() : true);
    $globalSystem = $globalSettings->system_share_percent;
    $globalWinner = $globalSettings->winner_share_percent;
@endphp

<div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
    <h3 class="text-sm font-semibold text-slate-800">Prize split</h3>
    <p class="mt-1 text-xs text-slate-500">Global default is {{ $globalSystem }}% system / {{ $globalWinner }}% winner.</p>

    <label class="mt-3 flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="use_default_split" value="1" id="use_default_split"
            @checked($useDefault)
            class="rounded border-slate-300 text-indigo-600">
        Use global default split
    </label>

    <div id="custom-split-fields" class="mt-4 space-y-4 {{ $useDefault ? 'hidden' : '' }}">
        <div>
            <label for="system_share_percent" class="mb-1 block text-sm font-medium text-slate-700">System share (%)</label>
            <input type="number" name="system_share_percent" id="system_share_percent"
                value="{{ old('system_share_percent', $pool->system_share_percent ?? $globalSystem) }}" min="0" max="100"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
            @error('system_share_percent')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="winner_share_percent" class="mb-1 block text-sm font-medium text-slate-700">Winner prize share (%)</label>
            <input type="number" name="winner_share_percent" id="winner_share_percent"
                value="{{ old('winner_share_percent', $pool->winner_share_percent ?? $globalWinner) }}" min="0" max="100"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
            @error('winner_share_percent')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <p class="text-sm text-slate-500">Custom split total: <span id="pool-split-total">100</span>%</p>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const useDefault = document.getElementById('use_default_split');
        const customFields = document.getElementById('custom-split-fields');
        const system = document.getElementById('system_share_percent');
        const winner = document.getElementById('winner_share_percent');
        const total = document.getElementById('pool-split-total');

        if (!useDefault || !customFields) return;

        function updateTotal() {
            if (!total || !system || !winner) return;
            total.textContent = (parseInt(system.value || 0) + parseInt(winner.value || 0));
        }

        function toggleCustomFields() {
            customFields.classList.toggle('hidden', useDefault.checked);
            if (system) system.required = !useDefault.checked;
            if (winner) winner.required = !useDefault.checked;
        }

        useDefault.addEventListener('change', toggleCustomFields);
        system?.addEventListener('input', updateTotal);
        winner?.addEventListener('input', updateTotal);
        toggleCustomFields();
        updateTotal();
    })();
</script>
@endpush
