@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Payment Details</h1>
        <p class="mt-1 text-sm text-slate-500">These details are shown to users on the pool entry page when they submit payment.</p>
    </div>

    <div class="mx-auto max-w-lg rounded-xl border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('admin.payment-settings.update') }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label for="raast_id" class="mb-1 block text-sm font-medium text-slate-700">Raast ID</label>
                <input type="text" name="raast_id" id="raast_id" value="{{ old('raast_id', $payment->raast_id) }}"
                    placeholder="e.g. 03001234567"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('raast_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="bank_name" class="mb-1 block text-sm font-medium text-slate-700">Bank Name</label>
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $payment->bank_name) }}"
                    placeholder="e.g. HBL, Meezan Bank"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('bank_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="account_title" class="mb-1 block text-sm font-medium text-slate-700">Account Title</label>
                <input type="text" name="account_title" id="account_title" value="{{ old('account_title', $payment->account_title) }}"
                    placeholder="Account holder name"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('account_title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="account_number" class="mb-1 block text-sm font-medium text-slate-700">Account Number</label>
                <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $payment->account_number) }}"
                    placeholder="Bank account number"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono">
                @error('account_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="iban" class="mb-1 block text-sm font-medium text-slate-700">IBAN (optional)</label>
                <input type="text" name="iban" id="iban" value="{{ old('iban', $payment->iban) }}"
                    placeholder="PKxx xxxx xxxx xxxx xxxx xxxx"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono">
                @error('iban')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="payment_note" class="mb-1 block text-sm font-medium text-slate-700">Note for users (optional)</label>
                <textarea name="payment_note" id="payment_note" rows="3"
                    placeholder="e.g. Send payment via Raast and upload screenshot below."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('payment_note', $payment->payment_note) }}</textarea>
                @error('payment_note')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Save payment details
            </button>
        </form>
    </div>
@endsection
