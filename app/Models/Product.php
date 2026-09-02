<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OUT_OF_STOCK = 'out_of_stock';
    public const STATUS_DEFECTIVE = 'defective';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'cost',
        'stock',
        'image',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function imageUrl(): ?string
    {
        if (empty($this->image)) {
            return 'https://placehold.co/600x400?text=' . urlencode($this->name);
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function isAvailable(): bool
    {
        if ($this->status !== self::STATUS_AVAILABLE) {
            return false;
        }

        return $this->stock > 0;
    }

    public function isNew(): bool
    {
        return $this->created_at !== null && $this->created_at->gte(now()->subDays(7));
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Disponible',
            self::STATUS_OUT_OF_STOCK => 'Agotado',
            self::STATUS_DEFECTIVE => 'Defectuoso',
            default => $this->status,
        };
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE)->where('stock', '>', 0);
    }

    public function scopeNewlyAdded($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    public function scopeOutOfStock($query)
    {
        return $query->where(function ($q) {
            $q->where('status', self::STATUS_OUT_OF_STOCK)
                ->orWhere('stock', 0);
        });
    }

    public function scopeDefective($query)
    {
        return $query->where('status', self::STATUS_DEFECTIVE);
    }

    public function scopeLowStock($query, int $threshold = 10)
    {
        return $query->where('status', self::STATUS_AVAILABLE)
            ->where('stock', '>', 0)
            ->where('stock', '<=', $threshold);
    }
}