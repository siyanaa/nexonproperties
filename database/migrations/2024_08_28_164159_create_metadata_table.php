<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTable extends Migration
{
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title', 255);
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->string('slug', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metadata');
    }
}
