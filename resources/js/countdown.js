export function formatCountdown(diffMs) {
    if (diffMs <= 0) {
        return { expired: true, label: 'Draw happening now!' };
    }

    const d = Math.floor(diffMs / 86400000);
    diffMs -= d * 86400000;
    const h = Math.floor(diffMs / 3600000);
    diffMs -= h * 3600000;
    const m = Math.floor(diffMs / 60000);
    diffMs -= m * 60000;
    const s = Math.floor(diffMs / 1000);

    return {
        expired: false,
        label: `${d}d ${h}h ${m}m ${s}s`,
        parts: { d, h, m, s },
    };
}

export function initCountdownElements(selector = '[data-countdown-target]') {
    const elements = document.querySelectorAll(selector);

    if (!elements.length) {
        return;
    }

    function tick() {
        elements.forEach((el) => {
            const target = el.dataset.countdownTarget;
            if (!target) {
                return;
            }

            const end = new Date(target).getTime();
            const result = formatCountdown(end - Date.now());

            if (result.expired) {
                el.textContent = el.dataset.countdownExpired || result.label;
                return;
            }

            if (el.dataset.countdownParts === '1' && result.parts) {
                el.querySelector('[data-countdown-days]')?.replaceChildren(document.createTextNode(String(result.parts.d)));
                el.querySelector('[data-countdown-hours]')?.replaceChildren(document.createTextNode(String(result.parts.h)));
                el.querySelector('[data-countdown-minutes]')?.replaceChildren(document.createTextNode(String(result.parts.m)));
                el.querySelector('[data-countdown-seconds]')?.replaceChildren(document.createTextNode(String(result.parts.s)));
            } else {
                el.textContent = result.label;
            }
        });
    }

    tick();
    setInterval(tick, 1000);
}

export function updateCountdownTargets(isoString, selector = '[data-countdown-target]') {
    document.querySelectorAll(selector).forEach((el) => {
        el.dataset.countdownTarget = isoString;
    });
}
