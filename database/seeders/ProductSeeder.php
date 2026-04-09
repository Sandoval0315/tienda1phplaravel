<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'CAMISETA MANGA LARGA RAYAS',
                'description' => 'Camiseta de manga larga con estampado de rayas. Estilo casual y cómodo.',
                'price' => 35,
                'category' => 'Camisetas',
                'brand' => 'BéRRY MEN',
                'stock' => 25,
                'image' => 'https://static.bershka.net/assets/public/0199/d921/971d496dbc90/892639a3292a/01958538712-a4o/01958538712-a4o.jpg?ts=1773928361275&w=850&f=auto',
                'sizes' => json_encode(['S', 'M', 'L', 'XL']),
                'colors' => json_encode(['Unico'])
            ],
            [
                'name' => 'PANTALON SUPER BAGGY',
                'description' => 'Pantalón de algodón con corte super baggy. Estilo urbano y cómodo.',
                'price' => 65,
                'category' => 'Pantalones',
                'brand' => 'BéRRY MEN',
                'stock' => 15,
                'image' => 'https://static.bershka.net/assets/public/21a8/3ae9/d408437abb87/7b1032455c79/01541710829-a2d/01541710829-a2d.jpg?ts=1774864400880&w=850&f=auto',
                'sizes' => json_encode(['28', '30', '32', '34']),
                'colors' => json_encode(['Gris Oscuro'])
            ],
            [
                'name' => 'VESTIDO MIDI ENCAJE',
                'description' => 'Vestido midi de encaje con forro interior. Elegante y sofisticado.',
                'price' => 60,
                'category' => 'Vestidos',
                'brand' => 'BéRRY WOMEN',
                'stock' => 10,
                'image' => 'https://static.bershka.net/assets/public/388e/09d0/17a3479bbb1f/beafb2434e41/02154218712-a3o/02154218712-a3o.jpg?ts=1774876943949&w=850&f=auto',
                'sizes' => json_encode(['XS', 'S', 'M', 'L']),
                'colors' => json_encode(['Beige', 'Verde Oliva'])
            ],
            [
                'name' => 'GABARDINA CROPPED',
                'description' => 'Chaqueta de mezclilla con corte clásico. Un básico que nunca pasa de moda.',
                'price' => 80,
                'category' => 'Chaquetas',
                'brand' => 'BéRRY MEN',
                'stock' => 8,
                'image' => 'https://static.bershka.net/assets/public/b0d2/9f80/b4454603ba13/981f1a1cf586/01456073742-p/01456073742-p.jpg?ts=1774863656605&w=850&f=auto',
                'sizes' => json_encode(['S', 'M', 'L']),
                'colors' => json_encode(['Cafe Denim'])
            ],
            [
                'name' => 'PANTALÓN SUPER BAGGY',
                'description' => 'Pantalón de lana con corte super baggy y pinzas. Perfecto para looks casuales.',
                'price' => 65,
                'category' => 'Pantalones',
                'brand' => 'BéRRY MEN',
                'stock' => 20,
                'image' => 'https://static.bershka.net/assets/public/68ac/700e/8f0e4eca832e/b0013d57c2ca/01552710711-a4o/01552710711-a4o.jpg?ts=1773734367804&w=850&f=auto',
                'sizes' => json_encode(['28', '30', '32', '34']),
                'colors' => json_encode(['Gris Oscuro'])
            ],
            [
                'name' => 'CAMISETA BOXY FIT PRINT',
                'description' => 'Camiseta de corte boxy con estampado. Perfecta para looks casuales.',
                'price' => 26,
                'category' => 'Camisetas',
                'brand' => 'BéRRY MEN',
                'stock' => 30,
                'image' => 'https://static.bershka.net/assets/public/31f4/8832/b64c4bca948d/7ba6cc64f4d2/01916732810-b/01916732810-b.jpg?ts=1775054806474&w=850&f=auto',
                'sizes' => json_encode(['S', 'M', 'L']),
                'colors' => json_encode(['Blanco', 'Negro', 'Gris'])
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✅ 6 productos creados exitosamente!');
    }
}