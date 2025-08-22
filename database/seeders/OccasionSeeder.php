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
        // Create the directory if it doesn't exist
        $imageDir = storage_path('app/public/images/occasions');
        if (!file_exists($imageDir)) {
            mkdir($imageDir, 0755, true);
        }
        
        // Copy sample images from public/images/home to storage/app/public/images/occasions
        $imageMap = [
            'cake5.webp' => 'cake5.webp',
            'ocake4.jpg' => 'ocake4.jpg',
            'ocake1.jpg' => 'ocake1.jpg',
            'cake3.webp' => 'cake3.webp',
            'cake1.webp' => 'cake1.webp',
            'ocake2.webp' => 'ocake2.webp'
        ];
        
        foreach ($imageMap as $destFile => $sourceFile) {
            $source = public_path("images/home/{$sourceFile}");
            $dest = "{$imageDir}/{$destFile}";
            
            if (file_exists($source) && !file_exists($dest)) {
                copy($source, $dest);
            }
        }
        
        $occasions = [
            [
                'title' => 'Birthday Celebration',
                'description' => 'Make their special day unforgettable with our custom birthday cakes and treats!',
                'image' => 'images/occasions/cake5.webp',
                'alt_text' => 'Colorful birthday cake with candles',
                'route' => '/products?occasion=birthday',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Anniversary',
                'description' => 'Celebrate your love with our specially designed anniversary cakes and desserts.',
                'image' => 'images/occasions/ocake4.jpg',
                'alt_text' => 'Elegant anniversary cake',
                'route' => '/products?occasion=anniversary',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Wedding',
                'description' => 'Make your wedding day even more special with our exquisite wedding cakes.',
                'image' => 'images/occasions/ocake1.jpg',
                'alt_text' => 'Beautiful wedding cake',
                'route' => '/products?occasion=wedding',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Graduation',
                'description' => 'Celebrate academic achievements with our graduation-themed treats!',
                'image' => 'images/occasions/cake3.webp',
                'alt_text' => 'Graduation cap cake',
                'route' => '/products?occasion=graduation',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Baby Shower',
                'description' => 'Sweet treats to celebrate the upcoming arrival of your little one.',
                'image' => 'images/occasions/cake1.webp',
                'alt_text' => 'Baby shower cupcakes',
                'route' => '/products?occasion=baby-shower',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Corporate Events',
                'description' => 'Impress your clients and colleagues with our professional catering options.',
                'image' => 'images/occasions/ocake2.webp',
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
