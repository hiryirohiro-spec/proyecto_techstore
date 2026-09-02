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

    public function getStatusBadge(): string
    {
        return match ($this->status) {
            'completed' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'canceled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function restoreStock(): void
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            $product = $item->product;

            if (! $product) {
                continue;
            }

            $product->increment('stock', $item->quantity);

            if ($product->stock > 0 && $product->status === 'out_of_stock') {
                $product->update(['status' => 'available']);
            }
        }
    }

    public function deductStock(): void
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            $product = $item->product;

            if (! $product) {
                continue;
            }

            $product->decrement('stock', $item->quantity);
            $product->refresh();

            if ($product->stock <= 0) {
                $product->update(['status' => 'out_of_stock']);
            }
        }
    }
}