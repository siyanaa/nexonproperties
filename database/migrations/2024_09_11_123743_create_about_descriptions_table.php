<?php
// database/migrations/xxxx_xx_xx_create_about_descriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAboutDescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('about_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        // Add a trigger to limit the number of rows to 5
        DB::unprepared('
            CREATE TRIGGER limit_about_descriptions BEFORE INSERT ON about_descriptions
            FOR EACH ROW
            BEGIN
                IF (SELECT COUNT(*) FROM about_descriptions) >= 5 THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Cannot insert more than 5 rows.";
                END IF;
            END
        ');
    }

    public function down()
    {
        // Drop the trigger first
        DB::unprepared('DROP TRIGGER IF EXISTS limit_about_descriptions');
        
        Schema::dropIfExists('about_descriptions');
    }
}