<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->string('street');
            // $table->string('suburb');
            // $table->string('state')->nullable();
            // $table->string('post_code');
            // $table->string('country')->nullable();

            $table->decimal('price', 15, 2);
            $table->enum('price_type', ['fixed', 'negotiable', 'on_request']);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area');
            $table->boolean('status');
            $table->longText('main_image');
            $table->enum('availability_status', ['available', 'sold', 'rental']);
            $table->string('rental_period')->nullable();
            $table->json('other_images')->nullable();
            $table->foreignId('metadata_id')->constrained('metadata')->onDelete('cascade');
            $table->string('googlemap')->nullable();
            $table->timestamp('update_time')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
}