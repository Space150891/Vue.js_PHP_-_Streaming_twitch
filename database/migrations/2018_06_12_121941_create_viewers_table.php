<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name')->default('');
            $table->integer('level_points')->default(0);
            $table->integer('current_points')->default(0);
            $table->integer('diamonds')->default(0);
            $table->integer('promoted_gamecard_id')->nullable();
            $table->string('phone')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('local_address')->nullable();
            $table->text('hide_fields')->nullable();
            $table->integer('referal')->default(0);
            $table->boolean('phone_verified')->default(false);
            $table->integer('alert_type_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('adress_details')->nullable();
            $table->string('state')->nullable();
            $table->string('social_twitch')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_instagram')->nullable();
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
        Schema::dropIfExists('viewers');
    }
}
