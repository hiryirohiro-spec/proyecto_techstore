<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($status = $request->input('status')) {
            match ($status) {
                'new' => $query->newlyAdded(),
                'out_of_stock' => $query->outOfStock(),
                'defective' => $query->defective(),
                'low_stock' => $query->lowStock(),
                'available' => $query->where('status', 'available')->where('stock', '>', 0),
                default => null,
            };
        }

        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        $counts = [
            'all' => Product::count(),
            'new' => Product::newlyAdded()->count(),
            'available' => Product::where('status', 'available')->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::outOfStock()->count(),
            'defective' => Product::defective()->count(),
            'low_stock' => Product::lowStock()->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'counts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Producto eliminado.');
    }

    public function markStatus(Product $product, string $status)
    {
        if (! in_array($status, ['available', 'out_of_stock', 'defective'], true)) {
            abort(404);
        }

        $product->update(['status' => $status]);

        return back()->with('success', "Producto marcado como {$product->getStatusLabel()}.");
    }

    private function validateData(Request $request, ?Product $product = null): array
    {
        $uniqueSlugRule = 'unique:products,slug';
        $uniqueSkuRule = 'unique:products,sku';

        if ($product) {
            $uniqueSlugRule .= ',' . $product->id;
            $uniqueSkuRule .= ',' . $product->id;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255', $uniqueSlugRule,
                function ($attribute, $value, $fail) {
                    $generated = Str::slug($value);
                    if ($generated !== $value) {
                        $fail('El slug solo debe contener letras minúsculas, números y guiones.');
                    }
                },
            ],
            'sku' => ['nullable', 'string', 'max:50', $uniqueSkuRule],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:available,out_of_stock,defective'],
            'is_featured' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:3072'],
            'remove_image' => ['boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}