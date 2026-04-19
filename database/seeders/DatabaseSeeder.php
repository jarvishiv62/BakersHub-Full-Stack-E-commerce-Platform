<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\OccasionSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OccasionSeeder::class,
            TestimonialSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
