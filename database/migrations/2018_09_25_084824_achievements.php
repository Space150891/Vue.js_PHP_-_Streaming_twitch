<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Achievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name')->nullable();
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('steps');
            $table->unsignedInteger('level_points');
            $table->string('image')->nullable();
            $table->unsignedInteger('diamonds')->default(0);
            $table->unsignedInteger('case_rarity_id')->default(0);
            $table->unsignedInteger('card_rarity_id')->default(0);
            $table->unsignedInteger('frame_rarity_id')->default(0);
            $table->unsignedInteger('hero_rarity_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievement_photos');
    }
}
