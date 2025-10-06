<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Package::create([
            'name' => 'Starter',
            'description' => 'Perfect for small businesses and startups',
            'price' => 299.00,
            'features' => [
                'Logo design',
                'Business card design',
                '2 revisions',
                'Source files included'
            ]
        ]);

        \App\Models\Package::create([
            'name' => 'Professional',
            'description' => 'Ideal for growing businesses',
            'price' => 599.00,
            'features' => [
                'Logo design',
                'Business card design',
                'Letterhead design',
                'Social media kit',
                '5 revisions',
                'Source files included'
            ]
        ]);

        \App\Models\Package::create([
            'name' => 'Enterprise',
            'description' => 'Comprehensive branding solution',
            'price' => 999.00,
            'features' => [
                'Complete brand identity',
                'Logo suite',
                'Full stationery set',
                'Social media kit',
                'Brand guidelines',
                'Unlimited revisions',
                'Source files included'
            ]
        ]);
    }
}
