<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public const SESSION_KEY = 'cart';

    public function index()
    {
        $cart = $this->getCart();

        return view('cart.index', [
            'cart' => $cart,
            'subtotal' => $this->subtotal(),
            'count' => $this->count(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        if (! $product->isAvailable()) {
            return back()->with('error', 'Este producto no está disponible en este momento.');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        $cart = $this->getCart();
        $cart[$product->id] = min($quantity, $product->stock) + ($cart[$product->id] ?? 0);

        if ($cart[$product->id] > $product->stock) {
            $cart[$product->id] = $product->stock;
        }

        session([self::SESSION_KEY => $cart]);

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = max(0, (int) $request->input('quantity', 0));

        $cart = $this->getCart();

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = min($quantity, $product->stock);
        }

        session([self::SESSION_KEY => $cart]);

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove(Product $product)
    {
        $cart = $this->getCart();
        unset($cart[$product->id]);
        session([self::SESSION_KEY => $cart]);

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear()
    {
        session()->forget(self::SESSION_KEY);

        return back()->with('success', 'Carrito vacío.');
    }

    public function getCart(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return array_sum($this->getCart());
    }

    public function subtotal(): float
    {
        $total = 0;

        foreach ($this->getCart() as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        return round($total, 2);
    }
}