<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
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

        $occasions = [
            [
                'title' => 'Birthday',
                'image' => 'images/home/cake5.webp',
                'alt' => 'Birthday Gifts',
                'description' => 'Make every birthday special with our custom cakes and treats.',
                'route' => 'products?occasion=birthday'
            ],
            [
                'title' => 'Anniversary Specials',
                'image' => 'images/home/ocake3.jpeg',
                'alt' => 'Anniversary Gifts',
                'description' => 'Celebrate love with our romantic dessert collections.',
                'route' => 'products?occasion=anniversary'
            ],
            [
                'title' => 'Wedding Favors',
                'image' => 'images/home/ocake1.jpg',
                'alt' => 'Wedding Gifts',
                'description' => 'Elegant treats for your special day.',
                'route' => 'products?occasion=wedding'
            ],
            [
                'title' => 'Corporate Gifts',
                'image' => 'images/home/ocake2.webp',
                'alt' => 'Corporate Gifts',
                'description' => 'Impress your clients with our premium gift boxes.',
                'route' => 'products?occasion=corporate'
            ],
            [
                'title' => 'Holiday Specials',
                'image' => 'images/home/cake.webp',
                'alt' => 'Holiday Gifts',
                'description' => 'Festive treats for every holiday season.',
                'route' => 'products?occasion=holiday'
            ],
            [
                'title' => 'Surprise Gift',
                'image' => 'images/home/ocake4.jpg',
                'alt' => 'Surprise Gifts',
                'description' => 'Surprise your loved ones with our custom cakes.',
                'route' => 'products?occasion=surprise'
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
