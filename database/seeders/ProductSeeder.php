<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation and 30-hour battery life. Perfect for music lovers and professionals.',
                'price' => 199.99,
                'stock' => 50,
                'status' => 'active',
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Feature-rich smartwatch with fitness tracking, heart rate monitor, and smartphone notifications. Water-resistant design.',
                'price' => 299.99,
                'stock' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Ergonomic aluminum laptop stand with adjustable height. Improves posture and workspace organization.',
                'price' => 49.99,
                'stock' => 100,
                'status' => 'active',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard with Cherry MX switches. Perfect for gaming and typing enthusiasts.',
                'price' => 129.99,
                'stock' => 75,
                'status' => 'active',
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with precision tracking and long battery life. Comfortable for extended use.',
                'price' => 39.99,
                'stock' => 120,
                'status' => 'active',
            ],
            [
                'name' => 'USB-C Hub',
                'description' => 'Multi-port USB-C hub with HDMI, USB 3.0, and SD card reader. Expand your laptop connectivity.',
                'price' => 59.99,
                'stock' => 80,
                'status' => 'active',
            ],
            [
                'name' => 'Monitor Stand',
                'description' => 'Sleek monitor stand with built-in storage compartments. Organize your desk space efficiently.',
                'price' => 79.99,
                'stock' => 45,
                'status' => 'active',
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p HD webcam with auto-focus and built-in microphone. Ideal for video calls and streaming.',
                'price' => 89.99,
                'stock' => 60,
                'status' => 'active',
            ],
            [
                'name' => 'Desk Lamp',
                'description' => 'LED desk lamp with adjustable brightness and color temperature. Eye-friendly lighting for work.',
                'price' => 34.99,
                'stock' => 90,
                'status' => 'active',
            ],
            [
                'name' => 'Cable Management',
                'description' => 'Cable organizer kit with clips and sleeves. Keep your workspace tidy and organized.',
                'price' => 19.99,
                'stock' => 150,
                'status' => 'active',
            ],
            [
                'name' => 'External SSD',
                'description' => '1TB portable SSD with USB-C connectivity. Fast data transfer speeds up to 1050MB/s.',
                'price' => 149.99,
                'stock' => 40,
                'status' => 'active',
            ],
            [
                'name' => 'Phone Stand',
                'description' => 'Adjustable phone stand compatible with all smartphones. Perfect for video calls and media viewing.',
                'price' => 14.99,
                'stock' => 200,
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'status' => $product['status'],
            ]);
        }
    }
}
