<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlesTable extends Migration
{
    /**
     * 对战
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('red_price_id')->index()->comment('所属红包玩法');
            $table->enum('type', ['min', 'max'])->index()->comment('游戏类别，大|小');
            $table->unsignedInteger('user_id')->index()->comment('用户id');
            $table->unsignedDecimal('result')->comment('扣费前收入结果');
            $table->unsignedDecimal('result_real')->comment('扣费后收入结果');
            $table->timestamps();

            $table->foreign('red_price_id')->references('id')->on('red_prices')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battles');
    }
}
