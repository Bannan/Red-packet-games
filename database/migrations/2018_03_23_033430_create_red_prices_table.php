<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedPricesTable extends Migration
{
    /**
     * 红包金额
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('red_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('screening_id')->index()->comment('所属游戏大厅');
            $table->string('thumb')->comment('红包缩略图');
            $table->string('title', 20)->comment('名称，如1元玩法');
            $table->unsignedDecimal('value')->comment('初始系统发送红包金额，如：1.00');
            $table->unsignedDecimal('service_fee')->comment('服务费比例，如：5.00%');
            $table->decimal('min')->comment('可抢最小金额');
            $table->decimal('max')->comment('可抢最大金额');
            $table->timestamps();

            $table->foreign('screening_id')->references('id')->on('screenings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('red_prices');
    }
}
