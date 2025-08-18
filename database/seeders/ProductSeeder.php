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
        $products = [
            [
                'name' => 'Chocolate Fudge Cake', 
                'price' => 249, 
                'category' => 'Cakes', 
                'image' => 'images/home/pro1.jpg',
                'description' => 'Rich and moist chocolate cake with layers of fudge frosting',
                'rating' => 4.5,
                'reviews_count' => 128
            ],
            [
                'name' => 'Sourdough Bread', 
                'price' => 99, 
                'category' => 'Bread', 
                'image' => 'images/home/pro2.webp',
                'description' => 'Artisanal sourdough bread with perfect crust and airy interior',
                'rating' => 4.8,
                'reviews_count' => 215
            ],
            [
                'name' => 'Croissant', 
                'price' => 350, 
                'category' => 'Pastries', 
                'image' => 'images/home/pro3.jpeg',
                'description' => 'Buttery, flaky croissant with a perfect golden crust',
                'rating' => 4.7,
                'reviews_count' => 189
            ],
            [
                'name' => 'Chocolate Chip Cookies', 
                'price' => 199, 
                'category' => 'Cookies', 
                'image' => 'images/home/pro4.jpg',
                'description' => 'Classic cookies loaded with premium chocolate chips',
                'rating' => 4.9,
                'reviews_count' => 342
            ],
            [
                'name' => 'Red Velvet Cupcake', 
                'price' => 325, 
                'category' => 'Desserts', 
                'image' => 'images/home/pro5.webp',
                'description' => 'Moist red velvet cupcake with cream cheese frosting',
                'rating' => 4.6,
                'reviews_count' => 156
            ],
            [
                'name' => 'Baguette', 
                'price' => 299, 
                'category' => 'Bread', 
                'image' => 'images/home/pro6.jpeg',
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
