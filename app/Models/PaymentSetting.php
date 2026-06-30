<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'raast_id',
        'bank_name',
        'account_title',
        'account_number',
        'iban',
        'payment_note',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([]);
    }

    public function hasDetails(): bool
    {
        return collect([
            $this->raast_id,
            $this->bank_name,
            $this->account_title,
            $this->account_number,
            $this->iban,
        ])->filter(fn ($value) => filled($value))->isNotEmpty();
    }

    public function hasRaast(): bool
    {
        return filled($this->raast_id);
    }

    public function hasBank(): bool
    {
        return collect([
            $this->bank_name,
            $this->account_title,
            $this->account_number,
            $this->iban,
        ])->filter(fn ($value) => filled($value))->isNotEmpty();
    }

    /**
     * @return array<int, array{label: string, value: string, key: string, icon: string}>
     */
    public function bankFields(): array
    {
        $fields = [];

        if (filled($this->bank_name)) {
            $fields[] = ['key' => 'bank_name', 'label' => 'Bank Name', 'value' => $this->bank_name, 'icon' => 'fa-building-columns'];
        }
        if (filled($this->account_title)) {
            $fields[] = ['key' => 'account_title', 'label' => 'Account Title', 'value' => $this->account_title, 'icon' => 'fa-user'];
        }
        if (filled($this->account_number)) {
            $fields[] = ['key' => 'account_number', 'label' => 'Account Number', 'value' => $this->account_number, 'icon' => 'fa-hashtag'];
        }
        if (filled($this->iban)) {
            $fields[] = ['key' => 'iban', 'label' => 'IBAN', 'value' => $this->iban, 'icon' => 'fa-barcode'];
        }

        return $fields;
    }

    /**
     * @return array<int, array{label: string, value: string, key: string}>
     */
    public function displayFields(): array
    {
        $fields = [];

        if ($this->hasRaast()) {
            $fields[] = ['key' => 'raast_id', 'label' => 'Raast ID', 'value' => $this->raast_id];
        }

        foreach ($this->bankFields() as $field) {
            $fields[] = collect($field)->except('icon')->all();
        }

        return $fields;
    }
}
