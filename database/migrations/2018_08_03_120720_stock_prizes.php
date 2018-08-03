<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockPrizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description', 1023)->nullable();
            $table->unsignedSmallInteger('cost')->default(0);
            $table->unsignedSmallInteger('amount')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('stock_prizes');
    }
}
