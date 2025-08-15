<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // All available products
        $allProducts = [
            [
                'id' => 1,
                'name' => 'Chocolate Fudge Cake', 
                'price' => 249, 
                'category' => 'Cakes', 
                'image' => 'images/home/pro1.jpg',
                'description' => 'Rich and moist chocolate cake with layers of fudge frosting',
                'rating' => 4.5,
                'reviews' => 128
            ],
            [
                'id' => 2,
                'name' => 'Sourdough Bread', 
                'price' => 99, 
                'category' => 'Bread', 
                'image' => 'images/home/pro2.webp',
                'description' => 'Artisanal sourdough bread with perfect crust and airy interior',
                'rating' => 4.8,
                'reviews' => 215
            ],
            [
                'id' => 3,
                'name' => 'Croissant', 
                'price' => 350, 
                'category' => 'Pastries', 
                'image' => 'images/home/pro3.jpeg',
                'description' => 'Buttery, flaky croissant with a perfect golden crust',
                'rating' => 4.7,
                'reviews' => 189
            ],
            [
                'id' => 4,
                'name' => 'Chocolate Chip Cookies', 
                'price' => 199, 
                'category' => 'Cookies', 
                'image' => 'images/home/pro4.jpg',
                'description' => 'Classic cookies loaded with premium chocolate chips',
                'rating' => 4.9,
                'reviews' => 342
            ],
            [
                'id' => 5,
                'name' => 'Red Velvet Cupcake', 
                'price' => 325, 
                'category' => 'Desserts', 
                'image' => 'images/home/pro5.webp',
                'description' => 'Moist red velvet cupcake with cream cheese frosting',
                'rating' => 4.6,
                'reviews' => 156
            ],
            [
                'id' => 6,
                'name' => 'Baguette', 
                'price' => 299, 
                'category' => 'Bread', 
                'image' => 'images/home/pro6.jpeg',
                'description' => 'Traditional French baguette with crispy crust and soft interior',
                'rating' => 4.5,
                'reviews' => 201
            ]
        ];

        // Get all unique categories for filter
        $categories = array_unique(array_column($allProducts, 'category'));
        
        // Filter products by category if specified
        $category = $request->input('category');
        $products = $category 
            ? array_filter($allProducts, fn($product) => $product['category'] === $category)
            : $allProducts;

        // Sort products
        $sort = $request->input('sort');
        if ($sort) {
            usort($products, function($a, $b) use ($sort) {
                if ($sort === 'price_asc') return $a['price'] <=> $b['price'];
                if ($sort === 'price_desc') return $b['price'] <=> $a['price'];
                return 0;
            });
        }

        // Search functionality
        $search = $request->input('search');
        if ($search) {
            $products = array_filter($products, function($product) use ($search) {
                return stripos($product['name'], $search) !== false || 
                       stripos($product['description'], $search) !== false;
            });
        }

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
            'searchQuery' => $search
        ]);
    }
}
