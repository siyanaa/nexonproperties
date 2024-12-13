<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Metadata;

class MetadataTableSeeder extends Seeder
{
    public function run()
    {
        Metadata::create([
            'meta_title' => 'Best Digital Marketing Services in 2024 - Grow Your Business Online',
            'meta_description' => 'Discover top-notch digital marketing services to boost your online presence in 2024. From SEO and content marketing to social media management, we help you grow your business with proven strategies.',
            'meta_keywords' => 'digital marketing, SEO services, content marketing, social media management, online marketing strategies, grow business online, marketing agency 2024',
            'slug' => 'best-digital-marketing-services-2024',
        ]);

        Metadata::create([
            'meta_title' => 'Ultimate Guide to Sustainable Living - Tips and Resources',
            'meta_description' => 'Learn how to live sustainably with our ultimate guide. Explore eco-friendly tips, green living resources, and sustainable product recommendations to make a positive impact on the environment.',
            'meta_keywords' => 'sustainable living, eco-friendly tips, green living, sustainable products, environmental impact, zero waste, green lifestyle, sustainability guide',
            'slug' => 'ultimate-guide-sustainable-living',
        ]);

        Metadata::create([
            'meta_title' => 'Top 10 Travel Destinations for 2024 - Explore the World',
            'meta_description' => 'Explore the top 10 travel destinations for 2024. Discover hidden gems, popular tourist spots, and must-visit places around the world for your next adventure.',
            'meta_keywords' => 'travel destinations 2024, top travel spots, must-visit places, hidden travel gems, tourism guide, world travel, travel inspiration 2024',
            'slug' => 'top-10-travel-destinations-2024',
        ]);

        Metadata::create([
            'meta_title' => 'The Complete Guide to Home Automation - Smart Home Technology',
            'meta_description' => 'Upgrade your home with the latest smart home technology. Our complete guide to home automation covers everything from smart lighting and security systems to voice assistants and home hubs.',
            'meta_keywords' => 'home automation, smart home technology, smart lighting, home security, voice assistants, smart home guide, home tech upgrades, smart home devices',
            'slug' => 'complete-guide-home-automation',
        ]);

        Metadata::create([
            'meta_title' => 'Healthy Eating: Meal Planning Tips and Nutritious Recipes',
            'meta_description' => 'Stay healthy with our meal planning tips and nutritious recipes. Find delicious ideas for balanced meals, weight loss, and a healthier lifestyle for the entire family.',
            'meta_keywords' => 'healthy eating, meal planning, nutritious recipes, balanced diet, weight loss meals, healthy lifestyle, family meal ideas, cooking tips',
            'slug' => 'healthy-eating-meal-planning-tips',
        ]);
    }
}