@props(['payment'])

@if($payment->hasRaast())
    <div class="mb-4 overflow-hidden rounded-xl border border-emerald-500/30 bg-emerald-500/5">
        <div class="flex items-center gap-2 border-b border-emerald-500/20 px-4 py-2.5">
            <i class="fas fa-bolt text-emerald-400"></i>
            <p class="text-sm font-semibold text-emerald-300">Raast ID</p>
        </div>
        <div class="flex items-center gap-3 px-4 py-3">
            <p class="flex-1 break-all font-mono text-base font-semibold text-white" id="payment-raast_id">{{ $payment->raast_id }}</p>
            <button type="button" onclick="copyPayment('payment-raast_id', this)"
                class="shrink-0 rounded-lg border border-emerald-500/30 px-3 py-1.5 text-xs font-medium text-emerald-300 hover:bg-emerald-500/10">
                Copy
            </button>
        </div>
    </div>
@endif

@if($payment->hasBank())
    <div class="mb-4 overflow-hidden rounded-xl border border-gold/25 bg-gold/5">
        <div class="flex items-center gap-2 border-b border-gold/20 px-4 py-2.5">
            <i class="fas fa-university text-gold"></i>
            <p class="text-sm font-semibold text-gold">Bank Details</p>
        </div>
        <dl class="divide-y divide-white/5">
            @foreach($payment->bankFields() as $field)
                <div class="flex items-start justify-between gap-3 px-4 py-2.5">
                    <div class="min-w-0">
                        <dt class="text-xs text-white/50">{{ $field['label'] }}</dt>
                        <dd class="mt-0.5 break-all font-mono text-sm font-semibold text-white" id="payment-{{ $field['key'] }}">{{ $field['value'] }}</dd>
                    </div>
                    <button type="button" onclick="copyPayment('payment-{{ $field['key'] }}', this)"
                        class="shrink-0 rounded-lg border border-gold/25 px-2.5 py-1 text-xs text-gold hover:bg-gold/10">
                        Copy
                    </button>
                </div>
            @endforeach
        </dl>
    </div>
@endif

@if(filled($payment->payment_note))
    <p class="mb-4 text-xs text-white/50">{{ $payment->payment_note }}</p>
@endif
