<?php

use App\Models\Product;

if (! function_exists('format_money')) {
    function format_money(float|int|string|null $value): string
    {
        $value = (float) $value;

        if (fmod($value, 1) == 0) {
            return 'Bs ' . number_format($value, 0, ',', '.');
        }

        return 'Bs ' . number_format($value, 2, ',', '.');
    }
}

if (! function_exists('product_image')) {
    function product_image(?Product $product): string
    {
        if (! $product || empty($product->image)) {
            return 'https://placehold.co/600x400?text=Electronica';
        }

        if (\Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])) {
            return $product->image;
        }

        return asset('storage/' . ltrim($product->image, '/'));
    }
}