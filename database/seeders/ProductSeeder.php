<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['sku' => 'SKU-001', 'name' => 'Laptop ASUS ROG', 'description' => 'Gaming laptop dengan spesifikasi tinggi', 'price' => 15000000],
            ['sku' => 'SKU-002', 'name' => 'Monitor LG 27"', 'description' => 'Monitor IPS 27 inch Full HD', 'price' => 3500000],
            ['sku' => 'SKU-003', 'name' => 'Keyboard Mechanical', 'description' => 'Keyboard gaming mechanical RGB', 'price' => 750000],
            ['sku' => 'SKU-004', 'name' => 'Mouse Gaming Logitech', 'description' => 'Mouse gaming wireless', 'price' => 850000],
            ['sku' => 'SKU-005', 'name' => 'Headset Razer', 'description' => 'Gaming headset 7.1 surround', 'price' => 1200000],
            ['sku' => 'SKU-006', 'name' => 'Webcam HD 1080p', 'description' => 'Webcam untuk streaming dan meeting', 'price' => 450000],
            ['sku' => 'SKU-007', 'name' => 'SSD 1TB Samsung', 'description' => 'SSD NVMe 1TB kecepatan tinggi', 'price' => 1500000],
            ['sku' => 'SKU-008', 'name' => 'RAM DDR4 16GB', 'description' => 'RAM DDR4 3200MHz 16GB Kit', 'price' => 900000],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            InventoryMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => rand(20, 100),
                'notes' => 'Initial stock',
            ]);
        }
    }
}
