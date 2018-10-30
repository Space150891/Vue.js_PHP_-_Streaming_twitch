<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryBoxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('viewer_id');
            $table->unsignedInteger('viewer_box_id');
            $table->unsignedInteger('box_type_id');
            $table->unsignedInteger('item_id')->default(0);
            $table->unsignedInteger('item_type_id');
            $table->string('details')->nullable();
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
        Schema::dropIfExists('history_boxes');
    }
}
