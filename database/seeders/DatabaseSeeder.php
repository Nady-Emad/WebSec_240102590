<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        Product::query()->updateOrCreate(
            ['code' => 'PRD-1001'],
            [
                'name' => 'Smart Phone X',
                'price' => 799.99,
                'model' => 'SPX-2026',
                'description' => '6.5-inch display, 128GB storage, dual camera.',
                'photo' => 'https://sm.pcmag.com/pcmag_uk/photo/a/apple-ipho/apple-iphone-17-in-hand_f7d1.jpg',
            ]
        );

        Product::query()->updateOrCreate(
            ['code' => 'PRD-1002'],
            [
                'name' => 'Laptop Pro 14',
                'price' => 1299.00,
                'model' => 'LTP-14',
                'description' => '14-inch business laptop with 16GB RAM and SSD.',
                'photo' => 'https://sm.pcmag.com/pcmag_uk/photo/a/apple-ipho/apple-iphone-17-in-hand_f7d1.jpg',
            ]
        );
    }
}