<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define your amenities with titles and descriptions
        $amenities = [
            [
                'title' => 'Air Conditioning',
                'description' => 'Provides cooling for comfort during hot weather.',
            ],
            [
                'title' => 'Heating',
                'description' => 'Keeps the property warm during colder months.',
            ],
            [
                'title' => 'High-Speed Internet',
                'description' => 'Fast internet connection for streaming and remote work.',
            ],
            [
                'title' => 'Cable/Satellite TV',
                'description' => 'Access to cable or satellite television channels.',
            ],
            [
                'title' => 'Furnished/Unfurnished',
                'description' => 'Option to rent with or without furniture.',
            ],
            [
                'title' => 'Parking Space',
                'description' => 'Dedicated space for parking vehicles.',
            ],
            [
                'title' => 'Balcony/Patio',
                'description' => 'Outdoor space for relaxation and enjoyment.',
            ],
            [
                'title' => 'Garden/Yard',
                'description' => 'Green space for gardening and outdoor activities.',
            ],
            [
                'title' => 'Pool',
                'description' => 'Swimming pool for leisure and recreation.',
            ],
            [
                'title' => 'Gym/Fitness Center',
                'description' => 'On-site fitness facilities for exercise and wellness.',
            ],
            [
                'title' => 'Laundry Facilities',
                'description' => 'Access to washers and dryers either in-unit or on-site.',
            ],
            [
                'title' => 'Security System',
                'description' => 'Monitoring systems for enhanced safety.',
            ],
            [
                'title' => 'Elevator',
                'description' => 'Lift access to upper floors.',
            ],
            [
                'title' => 'Pet-Friendly',
                'description' => 'Allows pets within the property.',
            ],
            [
                'title' => 'Wheelchair Accessible',
                'description' => 'Designed for ease of access for individuals with disabilities.',
            ],
            [
                'title' => 'Fireplace',
                'description' => 'Cozy fireplace for warmth and ambiance.',
            ],
            [
                'title' => 'Storage Space',
                'description' => 'Additional space for storing belongings.',
            ],
            [
                'title' => 'Smart Home Features',
                'description' => 'Home automation features for convenience.',
            ],
            [
                'title' => 'Hardwood Floors',
                'description' => 'Durable and stylish hardwood flooring.',
            ],
            [
                'title' => 'Granite/Marble Countertops',
                'description' => 'High-quality surface materials for kitchens and bathrooms.',
            ],
            // Add more amenities as needed
        ];

        foreach ($amenities as $amenity) {
            // Insert each amenity into the amenities table
            DB::table('amenities')->insert([
                'title' => $amenity['title'],
                'description' => $amenity['description'], // Optional description
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
