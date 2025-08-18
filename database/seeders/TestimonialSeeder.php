<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'name' => 'Anjali Mehta',
                'role' => 'Food Enthusiast',
                'quote' => 'Best pastries in town, their custom cakes made my wedding day magical!',
                'rating' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Rahul Singh',
                'role' => 'Regular Customer',
                'quote' => 'Amazing texture, taste and service. Highly recommended!',
                'rating' => 5,
                'is_active' => true
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }
    }
}
