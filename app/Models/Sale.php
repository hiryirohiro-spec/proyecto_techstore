<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'subtotal',
        'tax',
        'total',
        'status',
        'payment_method',
        'shipping_address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'completed' => 'Completada',
            'pending' => 'Pendiente',
            'canceled' => 'Cancelada',
            default => $this->status,
        };
    }
}