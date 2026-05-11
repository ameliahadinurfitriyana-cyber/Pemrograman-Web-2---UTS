<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = [
            'Makanan' => [
                ['name' => 'Nasi Goreng Spesial', 'price' => 18000, 'stock' => 40],
                ['name' => 'Mie Goreng Jumbo', 'price' => 15000, 'stock' => 50],
                ['name' => 'Ayam Bakar', 'price' => 25000, 'stock' => 35],
                ['name' => 'Sate Ayam', 'price' => 22000, 'stock' => 30],
                ['name' => 'Bakso Urat', 'price' => 20000, 'stock' => 45],
            ],
            'Minuman' => [
                ['name' => 'Es Teh Manis', 'price' => 7000, 'stock' => 80],
                ['name' => 'Jus Alpukat', 'price' => 12000, 'stock' => 45],
                ['name' => 'Kopi Susu', 'price' => 10000, 'stock' => 60],
                ['name' => 'Air Mineral 600ml', 'price' => 5000, 'stock' => 120],
                ['name' => 'Soda Gembira', 'price' => 13000, 'stock' => 30],
            ],
            'Sembako' => [
                ['name' => 'Beras Premium 5kg', 'price' => 72000, 'stock' => 25],
                ['name' => 'Gula Pasir 1kg', 'price' => 16000, 'stock' => 50],
                ['name' => 'Minyak Goreng 1L', 'price' => 18000, 'stock' => 45],
                ['name' => 'Telur Ayam 1kg', 'price' => 28000, 'stock' => 40],
                ['name' => 'Tepung Terigu 1kg', 'price' => 12000, 'stock' => 35],
            ],
            'Elektronik' => [
                ['name' => 'Mouse Wireless', 'price' => 85000, 'stock' => 20],
                ['name' => 'Keyboard USB', 'price' => 125000, 'stock' => 15],
                ['name' => 'Flashdisk 32GB', 'price' => 65000, 'stock' => 25],
                ['name' => 'Headset Gaming', 'price' => 175000, 'stock' => 12],
                ['name' => 'Charger 20W', 'price' => 99000, 'stock' => 18],
            ],
            'ATK' => [
                ['name' => 'Buku Tulis', 'price' => 5000, 'stock' => 100],
                ['name' => 'Pulpen', 'price' => 3000, 'stock' => 150],
                ['name' => 'Pensil 2B', 'price' => 4000, 'stock' => 120],
                ['name' => 'Penghapus', 'price' => 2000, 'stock' => 130],
                ['name' => 'Spidol Hitam', 'price' => 8000, 'stock' => 70],
            ],
            'Perawatan' => [
                ['name' => 'Sabun Mandi', 'price' => 9000, 'stock' => 65],
                ['name' => 'Shampoo', 'price' => 17000, 'stock' => 55],
                ['name' => 'Pasta Gigi', 'price' => 14000, 'stock' => 50],
                ['name' => 'Sikat Gigi', 'price' => 8000, 'stock' => 75],
                ['name' => 'Hand Sanitizer', 'price' => 12000, 'stock' => 40],
            ],
            'Snack' => [
                ['name' => 'Keripik Kentang', 'price' => 10000, 'stock' => 90],
                ['name' => 'Biskuit Cokelat', 'price' => 12000, 'stock' => 85],
                ['name' => 'Chiki Bulat', 'price' => 5000, 'stock' => 110],
                ['name' => 'Kacang Telur', 'price' => 8000, 'stock' => 60],
                ['name' => 'Wafer Cokelat', 'price' => 9000, 'stock' => 95],
            ],
            'Rumah Tangga' => [
                ['name' => 'Pembersih Lantai', 'price' => 16000, 'stock' => 30],
                ['name' => 'Sapu Ijuk', 'price' => 25000, 'stock' => 20],
                ['name' => 'Pel Lantai', 'price' => 18000, 'stock' => 25],
                ['name' => 'Spons Cuci Piring', 'price' => 6000, 'stock' => 100],
                ['name' => 'Tempat Sampah', 'price' => 45000, 'stock' => 15],
            ],
        ];

        foreach ($catalog as $categoryName => $products) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['name' => $productData['name'], 'category_id' => $category->id],
                    [
                        'description' => $categoryName . ' - ' . $productData['name'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                    ]
                );
            }
        }
    }
}
