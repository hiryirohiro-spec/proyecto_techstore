<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin TechStore',
            'email' => 'admin@techstore.com',
            'password' => 'admin123',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@techstore.com',
            'password' => 'cliente123',
        ]);

        $categories = [
            'Computadores y Laptops' => 'Portátiles, computadoras de escritorio y dispositivos para productividad.',
            'Celulares' => 'Smartphones de última generación con las mejores marcas.',
            'Audífonos y Audio' => 'Audífonos, parlantes y accesorios de audio.',
            'Accesorios y Periféricos' => 'Teclados, mouse, cables, cargadores y más.',
            'Tablets y Tablets' => 'Tablets para entretenimiento y trabajo.',
            'Televisores' => 'Televisores inteligentes de alta resolución.',
            'Videojuegos' => 'Consolas, controles y videojuegos.',
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
            ]);
        }

        $laptops = Category::where('slug', 'computadores-y-laptops')->first();
        $phones = Category::where('slug', 'celulares')->first();
        $audio = Category::where('slug', 'audifonos-y-audio')->first();
        $accessories = Category::where('slug', 'accesorios-y-perifericos')->first();
        $tablets = Category::where('slug', 'tablets-y-tablets')->first();
        $tvs = Category::where('slug', 'televisores')->first();
        $games = Category::where('slug', 'videojuegos')->first();

        $products = [
            [
                'category_id' => $laptops->id, 'name' => 'Laptop Gamer Nitro V15', 'sku' => 'LAP-001',
                'description' => 'Laptop gamer con procesador Intel Core i7, 16GB RAM, SSD 512GB y RTX 4060. Perfecta para juegos y trabajo pesado.',
                'price' => 14500, 'cost' => 11500, 'stock' => 12, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $laptops->id, 'name' => 'Laptop Office Inspiron 15', 'sku' => 'LAP-002',
                'description' => 'Laptop ideal para oficina y estudio: Ryzen 5, 8GB RAM y SSD 256GB. Batería de larga duración.',
                'price' => 7400, 'cost' => 5800, 'stock' => 25, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $laptops->id, 'name' => 'Laptop Todo en uno Pro 16', 'sku' => 'LAP-003',
                'description' => 'Laptop convertible con pantalla táctil, 16GB RAM y 1TB SSD. Versatilidad para cualquier tarea.',
                'price' => 11500, 'cost' => 9000, 'stock' => 8, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $laptops->id, 'name' => 'Laptop Ultraligera Air 13', 'sku' => 'LAP-004',
                'description' => 'Ultrabook de apenas 1.2kg con 13 pulgadas, ideal para viajar. Procesador eficiente y pantalla brillante.',
                'price' => 9300, 'cost' => 7400, 'stock' => 3, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $phones->id, 'name' => 'Smartphone Galaxy S24', 'sku' => 'CEL-001',
                'description' => 'Smartphone insignia con pantalla AMOLED 120Hz, cámara de 200MP y carga rápida. Bandeja de doble SIM.',
                'price' => 7900, 'cost' => 6700, 'stock' => 20, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1567581935884-3349723552ca?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $phones->id, 'name' => 'Smartphone Redmi Note 13', 'sku' => 'CEL-002',
                'description' => 'Excelente relación calidad-precio: pantalla AMOLED, 256GB y cámara de 108MP.',
                'price' => 3200, 'cost' => 2500, 'stock' => 40, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $phones->id, 'name' => 'Smartphone iPhone 15', 'sku' => 'CEL-003',
                'description' => 'El iPhone 15 con chip A16, cámara de 48MP y Dynamic Island. Resistente al agua.',
                'price' => 10500, 'cost' => 9200, 'stock' => 0, 'status' => 'out_of_stock', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $phones->id, 'name' => 'Smartphone X100 Pro', 'sku' => 'CEL-004',
                'description' => 'Smartphone de gama alta con cámara teleobjetivo, carga inalámbrica y pantalla curva.',
                'price' => 7200, 'cost' => 6800, 'stock' => 6, 'status' => 'defective', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $audio->id, 'name' => 'Audífonos Inalámbricos AirMax', 'sku' => 'AUD-001',
                'description' => 'Audífonos over-ear con cancelación activa de ruido, 30 horas de batería y sonido envolvente.',
                'price' => 2900, 'cost' => 2100, 'stock' => 35, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $audio->id, 'name' => 'Parlante Bluetooth Boom', 'sku' => 'AUD-002',
                'description' => 'Parlante portátil resistente al agua con graves potentes y 12 horas de reproducción.',
                'price' => 1100, 'cost' => 750, 'stock' => 18, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1589003077984-894e133dabab?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $audio->id, 'name' => 'Audífonos Earbuds TWS', 'sku' => 'AUD-003',
                'description' => 'Audífonos in-ear con estuche de carga, Bluetooth 5.3 y micrófono integrado.',
                'price' => 550, 'cost' => 380, 'stock' => 7, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $audio->id, 'name' => 'Barra de Sonido Theater', 'sku' => 'AUD-004',
                'description' => 'Barra de sonido 5.1 para cine en casa con subwoofer inalámbrico.',
                'price' => 4800, 'cost' => 3800, 'stock' => 0, 'status' => 'out_of_stock', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1580894908361-967195033215?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $accessories->id, 'name' => 'Teclado Mecánico RGB', 'sku' => 'ACC-001',
                'description' => 'Teclado mecánico con switches rojos, retroiluminación RGB y teclas anti-ghosting.',
                'price' => 800, 'cost' => 550, 'stock' => 30, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $accessories->id, 'name' => 'Mouse Gamer Pro 26000 DPI', 'sku' => 'ACC-002',
                'description' => 'Mouse ergonómico con 26000 DPI ajustables, botones programables y cable paracord.',
                'price' => 500, 'cost' => 330, 'stock' => 45, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $accessories->id, 'name' => 'Cargador Rápido 65W GaN', 'sku' => 'ACC-003',
                'description' => 'Cargador compacto de 65W con 3 puertos USB para cargar tus dispositivos a toda velocidad.',
                'price' => 400, 'cost' => 260, 'stock' => 100, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1618410320928-25228d811631?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $tablets->id, 'name' => 'Tablet Tab 11 256GB', 'sku' => 'TAB-001',
                'description' => 'Tablet con pantalla de 11 pulgadas, 8GB RAM y 256GB de almacenamiento. Ideal para estudios.',
                'price' => 4200, 'cost' => 3300, 'stock' => 15, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $tvs->id, 'name' => 'Smart TV 55" 4K UHD', 'sku' => 'TV-001',
                'description' => 'Smart TV con resolución 4K, HDR10+ y sistema operativo inteligente con apps preinstaladas.',
                'price' => 6200, 'cost' => 5000, 'stock' => 9, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $games->id, 'name' => 'Consola ProSlim + Control', 'sku' => 'VID-001',
                'description' => 'Consola de videojuegos de última generación con control inalámbrico y 1TB de almacenamiento.',
                'price' => 8239, 'cost' => 7200, 'stock' => 5, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $games->id, 'name' => 'Control Inalámbrico Duo', 'sku' => 'VID-002',
                'description' => 'Control inalámbrico con vibración, gatillos adaptativos y batería recargable de larga duración.',
                'price' => 950, 'cost' => 750, 'stock' => 22, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $laptops->id, 'name' => 'Laptop Edición Gamer RGB 17', 'sku' => 'LAP-005',
                'description' => 'Laptop de 17 pulgadas con RTX 4080, 32GB RAM y pantalla 240Hz. Potencia máxima para creadores.',
                'price' => 28000, 'cost' => 24000, 'stock' => 2, 'status' => 'available', 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1603481588273-2f908a9a7a1b?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $phones->id, 'name' => 'Smartphone Básico A15', 'sku' => 'CEL-005',
                'description' => 'Smartphone económico con 64GB, batería de 5000mAh y pantalla de 6.5 pulgadas.',
                'price' => 1400, 'cost' => 1100, 'stock' => 60, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1523206489230-c012c64b2b48?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $accessories->id, 'name' => 'Adaptador USB-C Hub 7 en 1', 'sku' => 'ACC-004',
                'description' => 'Hub USB-C con HDMI 4K, 3 puertos USB 3.0, SD card reader y carga passthrough.',
                'price' => 450, 'cost' => 320, 'stock' => 55, 'status' => 'available', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1618424181497-157f25b6ddd5?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
            [
                'category_id' => $audio->id, 'name' => 'Audífonos Deportivos Fit', 'sku' => 'AUD-005',
                'description' => 'Audífonos deportivos con gancho de oreja, resistencia al sudor y sonido claro.',
                'price' => 550, 'cost' => 380, 'stock' => 4, 'status' => 'defective', 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=600&h=400&auto=format&fit=crop&crop=entropy&q=80',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'category_id' => $product['category_id'],
                'sku' => $product['sku'],
                'description' => $product['description'],
                'price' => $product['price'],
                'cost' => $product['cost'],
                'stock' => $product['stock'],
                'status' => $product['status'],
                'is_featured' => $product['is_featured'],
                'image' => $product['image'],
                'created_at' => now()->subDays(rand(0, 12)),
            ]);
        }
    }
}