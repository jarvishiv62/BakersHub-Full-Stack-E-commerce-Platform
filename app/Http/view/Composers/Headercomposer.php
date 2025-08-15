<?php

namespace App\Http\View\Composers;


use Illuminate\View\View;
use Illuminate\Support\Facades\Session;


class HeaderComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // Navigation items
        $navigation = [
            'products' => [
                'title' => 'Products',
                'url' => route('products'),
                'mega_menu' => true,
                'columns' => [
                    [
                        'title' => 'Cupcakes',
                        'items' => [
                            ['name' => 'Classic Cupcakes', 'url' => route('products', ['category' => 'classic-cupcakes'])],
                            ['name' => 'Seasonal Cupcakes', 'url' => route('products', ['category' => 'seasonal-cupcakes'])],
                            ['name' => 'Mini Cupcakes', 'url' => route('products', ['category' => 'mini-cupcakes'])],
                            ['name' => 'Cupcake Cakes', 'url' => route('products', ['category' => 'cupcake-cakes'])],
                        ]
                    ],
                    [
                        'title' => 'Cakes',
                        'items' => [
                            ['name' => 'Birthday Cakes', 'url' => route('products', ['category' => 'birthday-cakes'])],
                            ['name' => 'Wedding Cakes', 'url' => route('products', ['category' => 'wedding-cakes'])],
                            ['name' => 'Custom Cakes', 'url' => route('products', ['category' => 'custom-cakes'])],
                            ['name' => 'Cheesecakes', 'url' => route('products', ['category' => 'cheesecakes'])],
                        ]
                    ],
                    [
                        'title' => 'Cookies & More',
                        'items' => [
                            ['name' => 'Cookies', 'url' => route('products', ['category' => 'cookies'])],
                            ['name' => 'Brownies', 'url' => route('products', ['category' => 'brownies'])],
                            ['name' => 'Dessert Bars', 'url' => route('products', ['category' => 'dessert-bars'])],
                            ['name' => 'Seasonal Specials', 'url' => route('products', ['category' => 'seasonal-specials'])],
                        ]
                    ]
                ]
            ],
            'catering' => [
                'title' => 'Catering',
                'url' => route('catering'),
                'items' => [
                    ['name' => 'Birthday Cakes', 'url' => route('catering') . '#birthday'],
                    ['name' => 'Wedding Cakes', 'url' => route('catering') . '#wedding'],
                    ['name' => 'Special Events', 'url' => route('catering') . '#events'],
                ]
            ],
            'account' => [
                'title' => 'Account',
                'url' => route('account'),
                'auth' => true,
                'items' => [
                    ['name' => 'My Account', 'url' => route('account'), 'auth' => true],
                    ['name' => 'Order History', 'url' => '#', 'auth' => true],
                    ['name' => 'Login', 'url' => route('login'), 'guest' => true],
                    ['name' => 'Register', 'url' => route('register'), 'guest' => true],
                ]
            ],
            'contact' => [
                'title' => 'Contact',
                'url' => route('contact'),
                'mega_menu' => true,
                'columns' => [
                    [
                        'title' => 'Talk To Us',
                        'items' => [
                            ['name' => 'Contact Us', 'url' => route('contact')],
                            ['name' => 'Newsletter', 'url' => '#'],
                            ['name' => 'FAQ', 'url' => '#'],
                        ]
                    ],
                    [
                        'title' => 'Our Locations',
                        'items' => [
                            ['name' => 'Varanasi', 'url' => '#'],
                            ['name' => 'Bhadohi', 'url' => '#'],
                            ['name' => 'Mirzapur', 'url' => '#'],
                            ['name' => 'Ghazipur', 'url' => '#'],
                        ]
                    ]
                ]
            ],
            'about' => [
                'title' => 'Our Story',
                'url' => route('about'),
                'items' => [
                    ['name' => 'Mission', 'url' => route('about') . '#mission'],
                    ['name' => 'Vision', 'url' => route('about') . '#vision'],
                    ['name' => 'Careers', 'url' => route('about') . '#values'],
                ]
            ]
        ];

        // Site settings
        $settings = [
            'site_name' => config('app.name'),
            'logo' => asset('images/home/logo.png'),
            'cart_count' => Session::get('cart_count', 0),
        ];

        $view->with([
            'navigation' => $navigation,
            'settings' => $settings
        ]);
    }
}