<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('price');
            $table->integer('diamonds');
            $table->string('image')->nullable();
            $table->unsignedInteger('rarity_class_id')->default(0);
            $table->unsignedInteger('hero_rarity_id')->default(0);
            $table->unsignedInteger('frame_rarity_id')->default(0);
            $table->unsignedInteger('prize_cost')->default(0);
            $table->unsignedInteger('points_count')->default(0);
            $table->unsignedInteger('diamonds_count')->default(0);
            $table->unsignedInteger('hero_percent')->default(0);
            $table->unsignedInteger('frame_percent')->default(0);
            $table->unsignedInteger('prize_percent')->default(0);
            $table->unsignedInteger('points_percent')->default(0);
            $table->unsignedInteger('diamonds_percent')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_types');
    }
}
