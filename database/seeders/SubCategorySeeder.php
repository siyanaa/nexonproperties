<?php

namespace Database\Seeders;

use Log;
use App\Models\Category;
use App\Models\Metadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    public function run()
    {
        // Define your subcategories and their associated category and metadata IDs
        $subCategories = [
            [
                'title' => 'Apartments',
                'category_id' => 1, // Replace with the actual category ID
                'metadata_id' => 1,  // Replace with actual metadata ID
            ],
            [
                'title' => 'Houses',
                'category_id' => 1,
                'metadata_id' => 1,
            ],
            [
                'title' => 'Office Spaces',
                'category_id' => 2,
                'metadata_id' => 1,
            ],
            [
                'title' => 'Retail Spaces',
                'category_id' => 2,
                'metadata_id' => 1,
            ],
            [
                'title' => 'Residential Land',
                'category_id' => 3,
                'metadata_id' => 1,
            ],
            [
                'title' => 'Commercial Land',
                'category_id' => 3,
                'metadata_id' => 1,
            ],
            [
                'title' => 'Penthouses',
                'category_id' => 4,
                'metadata_id' => 1,
            ],
            [
                'title' => 'High-End Villas',
                'category_id' => 4,
                'metadata_id' => 1,
            ],
        ];

        foreach ($subCategories as $subCategory) {
            // Check if the category and metadata exist
            $categoryExists = Category::find($subCategory['category_id']);
            $metadataExists = Metadata::find($subCategory['metadata_id']);

            if ($categoryExists && $metadataExists) {
                // Create or update the subcategory record
                DB::table('sub_categories')->updateOrInsert(
                    [
                        'title' => $subCategory['title'],
                        'category_id' => $subCategory['category_id'],
                        'metadata_id' => $subCategory['metadata_id'],
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } else {
                // Log or handle case when category or metadata is not found
                Log::warning("Category or metadata not found for subcategory: " . $subCategory['title']);
            }
        }
    }
}
