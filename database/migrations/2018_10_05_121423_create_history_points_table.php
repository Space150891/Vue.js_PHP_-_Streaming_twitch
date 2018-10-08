<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('viewer_id');
            $table->unsignedInteger('points');
            $table->string('title');
            $table->string('description');
            $table->string('info')->nullable();
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
        Schema::dropIfExists('history_points');
    }
}
