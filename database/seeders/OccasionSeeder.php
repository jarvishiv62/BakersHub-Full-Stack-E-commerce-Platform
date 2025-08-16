<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Illuminate\Database\Seeder;

class OccasionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occasions = [
            [
                'title' => 'Birthday Celebration',
                'description' => 'Make their special day unforgettable with our custom birthday cakes and treats!',
                'image' => 'occasions/birthday.jpg',
                'alt_text' => 'Colorful birthday cake with candles',
                'route' => '/products?occasion=birthday',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Anniversary',
                'description' => 'Celebrate your love with our specially designed anniversary cakes and desserts.',
                'image' => 'occasions/anniversary.jpg',
                'alt_text' => 'Elegant anniversary cake',
                'route' => '/products?occasion=anniversary',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Wedding',
                'description' => 'Make your wedding day even more special with our exquisite wedding cakes.',
                'image' => 'occasions/wedding.jpg',
                'alt_text' => 'Beautiful wedding cake',
                'route' => '/products?occasion=wedding',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Graduation',
                'description' => 'Celebrate academic achievements with our graduation-themed treats!',
                'image' => 'occasions/graduation.jpg',
                'alt_text' => 'Graduation cap cake',
                'route' => '/products?occasion=graduation',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Baby Shower',
                'description' => 'Sweet treats to celebrate the upcoming arrival of your little one.',
                'image' => 'occasions/baby-shower.jpg',
                'alt_text' => 'Baby shower cupcakes',
                'route' => '/products?occasion=baby-shower',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Corporate Events',
                'description' => 'Impress your clients and colleagues with our professional catering options.',
                'image' => 'occasions/corporate.jpg',
                'alt_text' => 'Elegant corporate dessert table',
                'route' => '/products?occasion=corporate',
                'is_active' => true,
                'sort_order' => 6,
            ]
        ];

        foreach ($occasions as $occasion) {
            Occasion::create($occasion);
        }
    }
}
