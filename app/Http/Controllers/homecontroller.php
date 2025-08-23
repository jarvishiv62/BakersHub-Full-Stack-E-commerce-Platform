<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use App\Models\Testimonial;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active occasions from the database
        $occasions = Occasion::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function($occasion) {
                return [
                    'title' => $occasion->title,
                    'image' => asset('storage/' . $occasion->image),
                    'alt' => $occasion->alt_text,
                    'description' => $occasion->description,
                    'route' => $occasion->route
                ];
            });
            
        // Get unique product categories with an example product image
        $categories = Product::select('category')
            ->distinct()
            ->get()
            ->map(function($category) {
                $product = Product::where('category', $category->category)
                    ->whereNotNull('image')
                    ->first();
                    
                return [
                    'name' => $category->category,
                    'slug' => strtolower(str_replace(' ', '-', $category->category)),
                    'image' => $product ? asset('storage/' . $product->image) : asset('images/placeholder.jpg')
                ];
            });

        // Get all active testimonials, ordered by most recent first
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $deliveryOptions = [
            [
                'title' => 'Home Delivery',
                'icon' => 'bi-truck',
                'description' => 'Get our delicious treats delivered straight to your doorstep. Fast, reliable, and always fresh.',
                'link' => '#',
                'linkText' => 'Order Now'
            ],
            [
                'title' => 'Store Pickup',
                'icon' => 'bi-shop',
                'description' => 'Prefer to pick up? Visit our store and enjoy the full range of our fresh bakery items.',
                'link' => '#',
                'linkText' => 'Find a Store'
            ],
            [
                'title' => 'Corporate Orders',
                'icon' => 'bi-building',
                'description' => 'Special menu and bulk order options for corporate events and celebrations.',
                'link' => '#',
                'linkText' => 'Enquire Now'
            ]
        ];

        return view('home', [
            'occasions' => $occasions,
            'testimonials' => $testimonials,
            'categories' => $categories,
            'deliveryOptions' => $deliveryOptions
        ]);
    }
}
