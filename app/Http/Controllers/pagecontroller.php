<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the about page with all its sections
     */
    public function login()
    {
        return view('auth.login');
    }
    public function catering()
    {
        return view('catering');
    }
    public function account()
    {
        return view('account');
    }
    public function search()
    {
        return view('search');
    }
    public function contact()
    {
        return view('contact');
    }
    public function about()
    {
        $data = [
            'meta' => [
                'title' => 'About Us | ' . config('app.name'),
                'description' => 'Learn about our bakery, meet our team, and discover what makes our baked goods special.'
            ],
            'hero' => [
                'title' => 'Baked with Love, Shared with Joy',
                'subtitle' => 'Every bite tells a story of passion, tradition, and the finest ingredients',
                'buttons' => [
                    [
                        'text' => 'Our Creations',
                        'route' => 'products',
                        'class' => 'btn-light',
                        'icon' => null
                    ],
                    [
                        'text' => 'Our Story',
                        'route' => 'about',
                        'class' => 'btn-outline-light',
                        'icon' => null
                    ]
                ]
            ],
            'timeline' => [
                'title' => 'Our Sweet Journey',
                'subtitle' => 'From a small family bakery to your favorite neighborhood spot',
                'items' => [
                    [
                        'year' => '2021',
                        'title' => 'Humble Beginnings',
                        'description' => 'Started as a small home bakery with just one oven and a dream to bake the best pastries in town.',
                        'icon' => 'fa-birthday-cake',
                        'position' => 'left'
                    ],
                    [
                        'year' => '2022',
                        'title' => 'First Store Opens',
                        'description' => 'Opened our first physical location in downtown, becoming a local favorite for fresh bread and pastries.',
                        'icon' => 'fa-store',
                        'position' => 'right'
                    ],
                    [
                        'year' => '2023',
                        'title' => 'First Award',
                        'description' => 'Won "Best Bakery in the City" for our signature sourdough bread and croissants.',
                        'icon' => 'fa-award',
                        'position' => 'left'
                    ],
                    [
                        'year' => '2024',
                        'title' => 'Expanded Menu',
                        'description' => 'Introduced gluten-free and vegan options, making our treats accessible to everyone.',
                        'icon' => 'fa-utensils',
                        'position' => 'right'
                    ],
                    [
                        'year' => '2025',
                        'title' => 'Community Love',
                        'description' => 'Served our one millionth customer and expanded to three locations across the city.',
                        'icon' => 'fa-heart',
                        'position' => 'left'
                    ]
                ]
            ],
            'bakers' => [
                'title' => 'Meet Our Bakers',
                'subtitle' => 'The talented hands behind every delicious creation',
                'team' => [
                    [
                        'name' => 'Sarfaraj',
                        'role' => 'Head Baker',
                        'image' => 'person1.jpg',
                        'social' => [
                            'instagram' => '#',
                            'twitter' => '#',
                            'linkedin' => '#',
                            'facebook' => null
                        ],
                        'fun_fact' => 'Can decorate a cake blindfolded in under 5 minutes!',
                        'specialty' => 'Artisan Breads',
                        'delay' => '100'
                    ],
                    [
                        'name' => 'Misti Dubey',
                        'role' => 'Pastry Chef',
                        'image' => 'person2.jpg',
                        'social' => [
                            'instagram' => '#',
                            'twitter' => '#',
                            'linkedin' => '#',
                            'facebook' => null
                        ],
                        'fun_fact' => 'Misti once made a 7-tier wedding cake in just one day!',
                        'specialty' => 'French Pastries',
                        'delay' => '200'
                    ],
                    [
                        'name' => 'Mahesh Kumar',
                        'role' => 'Cake Artist',
                        'image' => 'person3.jpg',
                        'social' => [
                            'instagram' => '#',
                            'twitter' => '#',
                            'linkedin' => '#',
                            'facebook' => null
                        ],
                        'fun_fact' => 'Can sculpt anything out of fondant - even your pet\'s portrait!',
                        'specialty' => 'Custom Cakes',
                        'delay' => '300'
                    ],
                    [
                        'name' => 'Jaya Kumari',
                        'role' => 'Bread Master',
                        'image' => 'person4.jpg',
                        'social' => [
                            'instagram' => '#',
                            'twitter' => '#',
                            'linkedin' => '#',
                            'facebook' => null
                        ],
                        'fun_fact' => 'Wakes up at 3 AM every day to start the sourdough!',
                        'specialty' => 'Sourdough & Artisan Breads',
                        'delay' => '400'
                    ]
                ]
            ],
            'awards' => [
                'title' => 'Awards & Recognition',
                'subtitle' => 'Celebrating excellence in baking and customer satisfaction',
                'slides' => [
                    [
                        [
                            'title' => 'Best Bakery 2023',
                            'issuer' => 'City Food Awards',
                            'description' => 'Recognized for our exceptional pastries and outstanding customer service.',
                            'icon' => 'trophy',
                            'delay' => '100'
                        ],
                        [
                            'title' => 'Chef\'s Choice',
                            'issuer' => 'International Baking Association',
                            'description' => 'Awarded for innovation in traditional baking techniques.',
                            'icon' => 'award',
                            'delay' => '200'
                        ],
                        [
                            'title' => '5-Star Rating',
                            'issuer' => 'Food & Hospitality Magazine',
                            'description' => 'Consistently rated 5 stars for quality and taste by food critics.',
                            'icon' => 'star',
                            'delay' => '300'
                        ]
                    ],
                    [
                        [
                            'title' => 'Best Sourdough',
                            'issuer' => 'Artisan Bread Awards',
                            'description' => 'First place for our signature sourdough recipe and technique.',
                            'icon' => 'medal',
                            'delay' => '100'
                        ],
                        [
                            'title' => 'Customer Favorite',
                            'issuer' => 'Local\'s Choice Awards',
                            'description' => 'Voted #1 bakery by our wonderful community for 5 years running.',
                            'icon' => 'heart',
                            'delay' => '200'
                        ],
                        [
                            'title' => 'Sustainable Business',
                            'issuer' => 'Green Eats Initiative',
                            'description' => 'Recognized for our commitment to sustainable and ethical sourcing.',
                            'icon' => 'leaf',
                            'delay' => '300'
                        ]
                    ]
                ]
            ],
            'signature_creations' => [
                'title' => 'Signature Creations',
                'subtitle' => 'Our most beloved and iconic baked goods',
                'items' => [
                    [
                        'name' => 'Artisan Sourdough',
                        'description' => 'Our 48-hour fermented sourdough with perfect crust and airy crumb.',
                        'image' => 'spec1.jpg',
                        'rating' => 5,
                        'review_count' => 128,
                        'delay' => '100'
                    ],
                    [
                        'name' => 'Butter Croissant',
                        'description' => 'Flaky, buttery layers that melt in your mouth. Baked fresh daily.',
                        'image' => 'spec2.jpg',
                        'rating' => 4.5,
                        'review_count' => 245,
                        'delay' => '200'
                    ],
                    [
                        'name' => 'Chocolate Decadence',
                        'description' => 'Rich, moist chocolate cake with layers of ganache and fresh berries.',
                        'image' => 'spec3.jpg',
                        'rating' => 5,
                        'review_count' => 312,
                        'delay' => '300'
                    ]
                ]
            ],
            'fun_facts' => [
                'title' => 'Fun Facts About Us',
                'subtitle' => 'Some interesting numbers that make us proud',
                'facts' => [
                    [
                        'count' => 5000,
                        'title' => 'Loaves Baked',
                        'description' => 'Fresh bread made with love every month',
                        'icon' => 'bread-slice',
                        'delay' => '100'
                    ],
                    [
                        'count' => 2500,
                        'title' => 'Happy Customers',
                        'description' => 'And counting! Your smiles keep us going',
                        'icon' => 'smile',
                        'delay' => '200'
                    ],
                    [
                        'count' => 10000,
                        'title' => 'Cups of Coffee',
                        'description' => 'Brewed to perfection for our bakers',
                        'icon' => 'coffee',
                        'delay' => '300'
                    ],
                    [
                        'count' => 100,
                        'title' => 'Different Recipes',
                        'description' => 'From traditional to innovative creations',
                        'icon' => 'heart',
                        'delay' => '400'
                    ]
                ]
            ],
            'instagram' => [
                'title' => '@Wish-Bakery',
                'subtitle' => 'Follow us on Instagram for daily treats and behind-the-scenes!',
                'handle' => 'wishbakery',
                'button' => [
                    'text' => 'Follow Us',
                    'url' => 'https://www.instagram.com/wishbakery',
                    'icon' => 'instagram'
                ],
                'posts' => [
                    ['image' => 'insta1.jpg', 'likes' => 1200, 'comments' => 89, 'delay' => '0'],
                    ['image' => 'insta2.jpg', 'likes' => 956, 'comments' => 42, 'delay' => '100'],
                    ['image' => 'insta3.jpg', 'likes' => 2100, 'comments' => 134, 'delay' => '150'],
                    ['image' => 'insta4.jpg', 'likes' => 1500, 'comments' => 97, 'delay' => '200'],
                    ['image' => 'insta5.jpg', 'likes' => 1800, 'comments' => 112, 'delay' => '250'],
                    ['image' => 'insta6.jpg', 'likes' => 2400, 'comments' => 156, 'delay' => '300']
                ]
            ],
            'trust_badges' => [
                [
                    'title' => '5-Star Rated',
                    'description' => 'By 500+ Customers',
                    'icon' => 'award',
                    'delay' => '100'
                ],
                [
                    'title' => '100% Natural',
                    'description' => 'Ingredients',
                    'icon' => 'heart',
                    'delay' => '200'
                ],
                [
                    'title' => 'Free Delivery',
                    'description' => 'On Orders Over $50',
                    'icon' => 'truck',
                    'delay' => '300'
                ],
                [
                    'title' => '5+ Years',
                    'description' => 'Of Baking Excellence',
                    'icon' => 'medal',
                    'delay' => '400'
                ]
            ]
        ];

        return view('about', $data);
    }
}
