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
            $table->unsignedInteger('red_price_id')->index()->comment('所属红包房间');
            $table->enum('type', ['min', 'max'])->index()->comment('游戏类别，大|小');
            $table->unsignedInteger('self_id')->comment('用户id');
            $table->unsignedInteger('opponent_id')->comment('对手id');
            $table->unsignedDecimal('result')->comment('扣费前收入结果');
            $table->unsignedDecimal('result_real')->comment('扣费后收入结果');
            $table->unsignedTinyInteger('status')->index()->comment('胜负');
            $table->timestamp('battled_at')->comment('对战时间');
            $table->timestamps();

            $table->foreign('red_price_id')->references('id')->on('red_prices')->onDelete('cascade');
            $table->foreign('self_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('opponent_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['self_id', 'opponent_id']);
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
