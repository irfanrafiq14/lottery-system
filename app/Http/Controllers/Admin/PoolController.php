<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Services\PoolPrizeService;
use App\Services\RealtimeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PoolController extends Controller
{
    public function index(PoolPrizeService $prizeService): View
    {
        $pools = Pool::withCount([
            'entries',
            'entries as pending_entries_count' => fn ($q) => $q->where('status', 'pending'),
            'entries as approved_entries_count' => fn ($q) => $q->where('status', 'approved'),
        ])->orderBy('entry_fee')->get();

        $prizes = $pools->mapWithKeys(fn (Pool $pool) => [
            $pool->id => $prizeService->prizeForPool($pool),
        ]);

        return view('admin.pools.index', compact('pools', 'prizes'));
    }

    public function create(): View
    {
        return view('admin.pools.create');
    }

    public function store(Request $request, RealtimeService $realtime): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:pools,name'],
            'entry_fee' => ['required', 'integer', 'min:1', 'max:1000000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $slug = $this->uniqueSlug(Str::slug($validated['name']));

        Pool::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'entry_fee' => $validated['entry_fee'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $realtime->poolsUpdated();

        return redirect()->route('admin.pools.index')
            ->with('success', 'Pool created successfully.');
    }

    public function edit(Pool $pool): View
    {
        return view('admin.pools.edit', compact('pool'));
    }

    public function update(Request $request, Pool $pool, RealtimeService $realtime): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:pools,name,'.$pool->id],
            'entry_fee' => ['required', 'integer', 'min:1', 'max:1000000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $pool->update([
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug(Str::slug($validated['name']), $pool->id),
            'entry_fee' => $validated['entry_fee'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $realtime->poolsUpdated();

        return redirect()->route('admin.pools.index')
            ->with('success', 'Pool updated successfully.');
    }

    public function toggle(Pool $pool, RealtimeService $realtime): RedirectResponse
    {
        $pool->update(['is_active' => ! $pool->is_active]);

        $realtime->poolsUpdated();

        $status = $pool->is_active ? 'opened' : 'closed';

        return back()->with('success', "{$pool->name} pool has been {$status}.");
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug ?: 'pool';
        $candidate = $base;
        $counter = 1;

        while (Pool::where('slug', $candidate)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $candidate = $base.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }
}
