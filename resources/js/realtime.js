import './echo';
import { updateCountdownTargets } from './countdown';

const statusColors = {
    bronze: { btn: 'bg-amber-600 hover:bg-amber-700', border: 'border-amber-200' },
    silver: { btn: 'bg-slate-600 hover:bg-slate-700', border: 'border-slate-300' },
    gold: { btn: 'bg-yellow-600 hover:bg-yellow-700', border: 'border-yellow-300' },
    default: { btn: 'bg-indigo-600 hover:bg-indigo-700', border: 'border-indigo-200' },
};

function showToast(message, type = 'info') {
    let container = document.getElementById('realtime-toast');
    if (!container) {
        container = document.createElement('div');
        container.id = 'realtime-toast';
        container.className = 'fixed bottom-4 right-4 z-50 flex flex-col gap-2';
        document.body.appendChild(container);
    }

    const colors = {
        info: 'bg-indigo-600',
        success: 'bg-emerald-600',
        warning: 'bg-amber-600',
    };

    const toast = document.createElement('div');
    toast.className = `${colors[type] ?? colors.info} max-w-xs rounded-lg px-4 py-3 text-sm text-white shadow-lg`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(() => toast.remove(), 4000);
}

function setConnectionStatus(connected) {
    const dot = document.getElementById('realtime-status');
    if (!dot) return;

    dot.className = connected
        ? 'h-2 w-2 rounded-full bg-emerald-500'
        : 'h-2 w-2 rounded-full bg-red-400';
    dot.title = connected ? 'Live updates connected' : 'Live updates disconnected';
}

function formatPkr(amount) {
    return Number(amount).toLocaleString() + ' PKR';
}

function updatePoolPrize(card, pool) {
    const block = card.querySelector('[data-pool-prize]');
    if (!block || pool.winner_prize === undefined) return;

    const simple = block.dataset.poolPrizeSimple === '1';
    const winner = block.querySelector('[data-prize-winner]');

    if (winner) winner.textContent = formatPkr(pool.winner_prize);

    if (simple) return;

    const total = block.querySelector('[data-prize-total]');
    const system = block.querySelector('[data-prize-system]');
    const formula = block.querySelector('[data-prize-formula]');
    const systemLabel = block.querySelector('[data-prize-system-label]');
    const winnerLabel = block.querySelector('[data-prize-winner-label]');

    if (total) total.textContent = formatPkr(pool.total_pool);
    if (system) system.textContent = formatPkr(pool.system_amount);
    if (formula) formula.textContent = `${pool.participants} participants × ${Number(pool.entry_fee).toLocaleString()} PKR`;
    if (systemLabel) systemLabel.textContent = `System (${pool.system_percent}%)`;
    if (winnerLabel) winnerLabel.textContent = `Winner prize (${pool.winner_percent}%)`;
}

function updatePoolCards(pools, userId) {
    if (!pools?.length) return;

    pools.forEach((pool) => {
        const card = document.querySelector(`[data-pool-id="${pool.id}"]`);
        if (!card) return;

        updatePoolPrize(card, pool);

        const badge = card.querySelector('[data-pool-status-badge]');
        if (badge) {
            badge.textContent = pool.status_label;
            badge.className = pool.is_active
                ? 'rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-100 text-emerald-700'
                : 'rounded-full px-2.5 py-0.5 text-xs font-semibold bg-red-100 text-red-700';
        }

        const action = card.querySelector('[data-pool-action]');
        if (!action) return;

        const entryStatus = action.dataset.userEntryStatus;
        const colors = statusColors[pool.slug] ?? statusColors.default;

        if (entryStatus && entryStatus !== 'none') {
            action.innerHTML = `<div class="rounded-lg bg-slate-50 px-3 py-2 text-sm">Your entry: <span class="font-semibold capitalize">${entryStatus}</span></div>`;
        } else if (pool.is_active) {
            const enterUrl = card.dataset.enterUrl ?? `/pools/${pool.id}/enter`;
            action.innerHTML = `<a href="${enterUrl}" class="mt-4 block w-full rounded-lg ${colors.btn} px-4 py-2.5 text-center text-sm font-semibold text-white">Join Pool</a>`;
        } else {
            action.innerHTML = '<p class="mt-4 text-center text-sm text-slate-500">Entries closed — draw in progress</p>';
        }
    });
}

function updateUserEntryStatus(entry, userId) {
    if (!entry || String(entry.user_id) !== String(userId)) return;

    const card = document.querySelector(`[data-pool-id="${entry.pool_id}"]`);
    const action = card?.querySelector('[data-pool-action]');
    if (action) {
        action.dataset.userEntryStatus = entry.status;
        action.innerHTML = `<div class="rounded-lg bg-slate-50 px-3 py-2 text-sm">Your entry: <span class="font-semibold capitalize">${entry.status}</span></div>`;
    }
}

function updateAdminStats(stats) {
    if (!stats) return;

    Object.entries(stats).forEach(([key, value]) => {
        const el = document.querySelector(`[data-stat="${key}"]`);
        if (el) el.textContent = value;
    });
}

function prependAdminEntry(entry) {
    const tbody = document.getElementById('admin-recent-entries');
    if (!tbody || !entry) return;

    const empty = tbody.querySelector('[data-empty-row]');
    if (empty) empty.remove();

    const row = document.createElement('tr');
    row.className = 'animate-pulse';
    row.innerHTML = `
        <td class="px-4 py-3"><a href="/admin/entries/${entry.id}" class="text-indigo-600 hover:underline">${entry.user_name}</a></td>
        <td class="px-4 py-3">${entry.pool_name}</td>
        <td class="px-4 py-3 capitalize">${entry.status}</td>
        <td class="px-4 py-3">${entry.created_at ?? 'Just now'}</td>
    `;
    tbody.prepend(row);
    setTimeout(() => row.classList.remove('animate-pulse'), 1500);
}

function updateAdminEntryRow(entry) {
    const row = document.querySelector(`[data-entry-id="${entry.id}"]`);
    if (!row) return;

    const statusCell = row.querySelector('[data-entry-status]');
    if (statusCell) {
        const badge = statusCell.querySelector('span') ?? statusCell;
        badge.textContent = entry.status;
        if (badge.tagName === 'SPAN') {
            badge.className = `rounded-full px-2 py-0.5 text-xs font-medium capitalize ${
                entry.status === 'approved' ? 'bg-emerald-100 text-emerald-700' :
                entry.status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700'
            }`;
        } else {
            statusCell.className = `px-4 py-3 capitalize font-medium ${
                entry.status === 'approved' ? 'text-emerald-600' :
                entry.status === 'rejected' ? 'text-red-600' : 'text-amber-600'
            }`;
        }
    }
}

function handleUpdate(data, context, userId) {
    const { action, payload } = data;

    switch (action) {
        case 'pools.updated':
            updatePoolCards(payload.pools, userId);
            if (context === 'admin') showToast('Pool status updated live', 'info');
            break;

        case 'entry.created':
            updatePoolCards(payload.pools, userId);
            updateAdminStats(payload.admin_stats);
            if (context === 'admin') {
                prependAdminEntry(payload.entry);
                showToast(`New entry from ${payload.entry.user_name}`, 'info');
            }
            if (context === 'user' && String(payload.entry.user_id) === String(userId)) {
                updateUserEntryStatus(payload.entry, userId);
                showToast('Entry submitted — awaiting admin review', 'success');
            }
            break;

        case 'entry.status_changed':
            updatePoolCards(payload.pools, userId);
            updateAdminStats(payload.admin_stats);
            updateAdminEntryRow(payload.entry);
            if (context === 'user' && String(payload.entry.user_id) === String(userId)) {
                updateUserEntryStatus(payload.entry, userId);
                showToast(`Your entry was ${payload.entry.status}`, payload.entry.status === 'approved' ? 'success' : 'warning');
            }
            if (context === 'admin') {
                showToast(`Entry ${payload.entry.status}: ${payload.entry.user_name}`, 'info');
            }
            break;

        case 'draw.completed':
            updatePoolCards(payload.pools, userId);
            updateAdminStats(payload.admin_stats);
            if (payload.next_draw_at) {
                updateCountdownTargets(payload.next_draw_at);
            }
            document.querySelectorAll('[data-pool-action]').forEach((el) => {
                el.dataset.userEntryStatus = 'none';
            });
            updatePoolCards(payload.pools, userId);
            if (payload.winners?.length) {
                const names = payload.winners.map((w) => `${w.pool_name}: ${w.user_name}`).join(', ');
                showToast(`Winners: ${names}`, 'success');
            } else {
                showToast('Weekly draw completed — new week started!', 'success');
            }
            break;
    }
}

export function initRealtime(context) {
    if (!window.Echo) {
        setConnectionStatus(false);
        return;
    }

    const userId = document.querySelector('meta[name="realtime-user-id"]')?.content;
    const handler = (data) => handleUpdate(data, context, userId);

    window.Echo.channel('pools').listen('.realtime.update', handler);

    if (context === 'admin') {
        window.Echo.private('admin.dashboard')
            .listen('.realtime.update', handler)
            .error(() => setConnectionStatus(false));
    }

    if (context === 'user' && userId) {
        window.Echo.private(`user.${userId}`)
            .listen('.realtime.update', handler)
            .error(() => setConnectionStatus(false));
    }

    setConnectionStatus(true);
}
