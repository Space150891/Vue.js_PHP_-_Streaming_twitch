<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_plan_id');
            $table->bigInteger('from_viewers')->unsigned()->default(0);
            $table->bigInteger('to_viewers')->unsigned()->default(0);
            $table->integer('points')->unsigned()->default(0);
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
        Schema::dropIfExists('subscription_points');
    }
}
