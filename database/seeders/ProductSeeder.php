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
     *
     * @return void
     */
    public function run()
    {
        // Create the directory if it doesn't exist
        $imageDir = storage_path('app/public/images/products');
        if (!file_exists($imageDir)) {
            mkdir($imageDir, 0755, true);
        }
        
        // Copy sample images from public to storage
        for ($i = 1; $i <= 6; $i++) {
            $ext = $i === 2 || $i === 5 ? 'webp' : ($i === 3 || $i === 6 ? 'jpeg' : 'jpg');
            $source = public_path("images/home/pro{$i}.{$ext}");
            $dest = "{$imageDir}/pro{$i}.{$ext}";
            
            if (file_exists($source) && !file_exists($dest)) {
                copy($source, $dest);
            }
        }
        $products = [
            [
                'name' => 'Chocolate Fudge Cake', 
                'price' => 249, 
                'category' => 'Cakes', 
                'image' => 'storage/images/products/pro1.jpg',
                'description' => 'Rich and moist chocolate cake with layers of fudge frosting',
                'rating' => 4.5,
                'reviews_count' => 128
            ],
            [
                'name' => 'Sourdough Bread', 
                'price' => 99, 
                'category' => 'Bread', 
                'image' => 'storage/images/products/pro2.webp',
                'description' => 'Artisanal sourdough bread with perfect crust and airy interior',
                'rating' => 4.8,
                'reviews_count' => 215
            ],
            [
                'name' => 'Croissant', 
                'price' => 350, 
                'category' => 'Pastries', 
                'image' => 'storage/images/products/pro3.jpeg',
                'description' => 'Buttery, flaky croissant with a perfect golden crust',
                'rating' => 4.7,
                'reviews_count' => 189
            ],
            [
                'name' => 'Chocolate Chip Cookies', 
                'price' => 199, 
                'category' => 'Cookies', 
                'image' => 'storage/images/products/pro4.jpg',
                'description' => 'Classic cookies loaded with premium chocolate chips',
                'rating' => 4.9,
                'reviews_count' => 342
            ],
            [
                'name' => 'Red Velvet Cupcake', 
                'price' => 325, 
                'category' => 'Desserts', 
                'image' => 'storage/images/products/pro5.webp',
                'description' => 'Moist red velvet cupcake with cream cheese frosting',
                'rating' => 4.6,
                'reviews_count' => 156
            ],
            [
                'name' => 'Baguette', 
                'price' => 299, 
                'category' => 'Bread', 
                'image' => 'storage/images/products/pro6.jpeg',
                'description' => 'Traditional French baguette with crispy crust and soft interior',
                'rating' => 4.5,
                'reviews_count' => 201
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
