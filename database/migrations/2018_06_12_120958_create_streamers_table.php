<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streamers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('alert_type_id')->nullable();
            $table->integer('twitch_id')->nullable();
            $table->string('game')->nullable();
            $table->integer('referal')->default(0);
            $table->string('name')->default('');
            $table->integer('user_id');
            $table->string('paypal')->nullable();
            $table->string('donate_front')->nullable();
            $table->string('donate_back')->nullable();
            $table->string('donate_text')->nullable();
            $table->string('stream_token', 50)->nullable();
            $table->integer('prize_alert')->default(30);
            $table->string('image')->nullable();
            $table->integer('viewers_count')->default(0);
            $table->integer('followers_count')->default(0);
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
        Schema::dropIfExists('streamers');
    }
}
