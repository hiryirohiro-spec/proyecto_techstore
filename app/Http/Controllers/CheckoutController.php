<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public const TAX_RATE = 0.13;

    public function index(CartController $cartController)
    {
        $cart = $cartController->getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $items = $this->resolveItems($cart);

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = $cartController->subtotal();
        $tax = round($subtotal * self::TAX_RATE, 2);

        return view('checkout.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $subtotal + $tax,
        ]);
    }

    public function store(Request $request, CartController $cartController)
    {
        $cart = $cartController->getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $data = $request->validate([
            'payment_method' => ['required', 'in:tarjeta,efectivo,transferencia,qr'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $items = $this->resolveItems($cart);

        foreach ($items as $productId => $item) {
            if (! $item['product']->isAvailable()) {
                return back()->with('error', "El producto \"{$item['product']->name}\" ya no está disponible.");
            }

            if ($item['product']->stock < $item['quantity']) {
                return back()->with('error', "Stock insuficiente para \"{$item['product']->name}\".");
            }
        }

        $subtotal = $cartController->subtotal();
        $tax = round($subtotal * self::TAX_RATE, 2);
        $total = $subtotal + $tax;

        $sale = Sale::create([
            'code' => 'VENTA-' . strtoupper(Str::random(8)),
            'user_id' => $request->user()->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => 'completed',
            'payment_method' => $data['payment_method'],
            'shipping_address' => $data['shipping_address'],
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($items as $productId => $item) {
            $product = $item['product'];
            $lineSubtotal = round($product->price * $item['quantity'], 2);

            $sale->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $lineSubtotal,
            ]);

            $product->decrement('stock', $item['quantity']);
            $product->refresh();

            if ($product->stock <= 0) {
                $product->update(['status' => 'out_of_stock']);
            }
        }

        session()->forget(CartController::SESSION_KEY);

        return redirect()->route('orders.show', $sale->code)
            ->with('success', '¡Compra realizada con éxito!');
    }

    private function resolveItems(array $cart): array
    {
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            $items[$productId] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        return $items;
    }
}