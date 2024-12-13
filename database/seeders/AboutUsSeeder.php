<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            [
                'title' => 'Trusted Real Estate Care',
                'subtitle' => 'Dream Living Spaces Setting New Build',
                'description' => 'At Nexon Property, we are dedicated to redefining the real estate experience by combining innovation with a personalized touch. Our team of experienced professionals specializes in residential, commercial, and industrial properties, offering tailored solutions that meet the unique needs of every client. With an extensive portfolio of properties and a deep understanding of market trends, we empower our clients to make informed decisions, whether they are buying, selling, or renting.',
                'keywords' => json_encode(['Real Estate', 'Property Management', 'Residential Properties']), // Store keywords as JSON
                'image' => json_encode(['image1.jpg', 'image2.jpg']), // Store images as JSON
                'status' => true,
                'metadata_id' => 1, // Ensure this ID exists in your metadata table
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
