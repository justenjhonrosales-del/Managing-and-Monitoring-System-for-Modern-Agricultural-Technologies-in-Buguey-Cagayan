<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            [
                'name' => 'Kuliglig/Hand Tractor',
                'description' => 'Manual hand-operated tractor for small to medium farming operations. Perfect for plowing, tilling soil, and land preparation.',
                'image_path' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=300&fit=crop',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'status' => 'available',
            ],
            [
                'name' => 'Reaper',
                'description' => 'Modern harvesting reaper for efficient crop cutting and collection. Reduces manual harvesting labor significantly.',
                'image_path' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=300&fit=crop',
                'total_quantity' => 2,
                'available_quantity' => 2,
                'status' => 'available',
            ],
            [
                'name' => 'Tractor',
                'description' => 'Heavy-duty agricultural tractor for large-scale farming. Used for plowing, cultivation, and harvesting operations.',
                'image_path' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad576?w=500&h=300&fit=crop',
                'total_quantity' => 2,
                'available_quantity' => 2,
                'status' => 'available',
            ],
            [
                'name' => 'Water Pump',
                'description' => 'High-capacity water pump for irrigation systems. Essential for maintaining consistent water supply to crops.',
                'image_path' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=500&h=300&fit=crop',
                'total_quantity' => 1,
                'available_quantity' => 1,
                'status' => 'available',
            ],
            [
                'name' => 'Soil Tiller',
                'description' => 'Compact soil tilling machine for preparing seed beds. Ideal for vegetable gardens and small farm plots.',
                'image_path' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=300&fit=crop',
                'total_quantity' => 3,
                'available_quantity' => 3,
                'status' => 'available',
            ],
            [
                'name' => 'Sprayer Machine',
                'description' => 'Pesticide and fertilizer spraying machine. Covers large areas efficiently for crop protection.',
                'image_path' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=300&fit=crop',
                'total_quantity' => 4,
                'available_quantity' => 4,
                'status' => 'available',
            ],
        ];

        foreach ($technologies as $tech) {
            Technology::create($tech);
        }
    }
}
