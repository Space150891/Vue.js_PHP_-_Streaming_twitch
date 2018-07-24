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
            $table->string('address')->nullable();
            $table->integer('referal')->default(0);
            $table->boolean('Phone_verified')->default(false);
            $table->integer('alert_type_id')->nullable();
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
