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
            $table->unsignedInteger('screening_id')->index()->comment('所属游戏场次');
            $table->string('title', 20)->comment('名称，如1元');
            $table->unsignedDecimal('value')->comment('金额大小，如：1.00');
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
