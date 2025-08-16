<?php

namespace App\Http\Controllers;

use App\Models\Occasion;

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
                    'title' => $occasion->name,
                    'image' => asset('storage/' . $occasion->image),
                    'alt' => $occasion->name . ' Gifts',
                    'description' => $occasion->description,
                    'route' => 'products?occasion=' . strtolower($occasion->slug)
                ];
            });

        $featuredProducts = [
            [
                'id' => 1, 
                'name' => 'Vanilla Cake', 
                'price' => 1299, 
                'image' => 'images/home/cake1.webp',
                'description' => 'Classic vanilla sponge layered with creamy frosting',
                'category' => 'Cakes'
            ],
            [
                'id' => 2, 
                'name' => 'Chocolate Fudge', 
                'price' => 1499, 
                'image' => 'images/home/cake2.webp',
                'description' => 'Rich chocolate cake with decadent fudge icing',
                'category' => 'Cakes'
            ],
            [
                'id' => 3, 
                'name' => 'Pastry', 
                'price' => 99, 
                'image' => 'images/home/cake3.webp',
                'description' => 'Flaky, buttery pastries baked fresh',
                'category' => 'Pastries'
            ],
            [
                'id' => 4, 
                'name' => 'Assorted Cake', 
                'price' => 299, 
                'image' => 'images/home/cake4.webp',
                'description' => 'Delightful mix of chocolate chip and more',
                'category' => 'Cakes'
            ]
        ];

        $testimonials = [
            [
                'name' => 'Anjali Mehta',
                'role' => 'Food Enthusiast',
                'quote' => 'Best pastries in town, their custom cakes made my wedding day magical!',
                'rating' => 5
            ],
            [
                'name' => 'Rahul Singh',
                'role' => 'Regular Customer',
                'quote' => 'Amazing texture, taste and service. Highly recommended!',
                'rating' => 4
            ]
        ];

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

        return view('home', compact(
            'featuredProducts',
            'occasions',
            'testimonials',
            'deliveryOptions'
        ));
    }
}
