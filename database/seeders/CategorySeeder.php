<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'title' => 'Residential',
                'metadata_id' => 1, // Example metadata ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Commercial',
                'metadata_id' => 2, // Example metadata ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Land',
                'metadata_id' => 3, // Example metadata ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Luxury',
                'metadata_id' => 4, // Example metadata ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
       
    }
}
