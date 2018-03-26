<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * 会员等级
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('名称,如：会员级别');
            $table->unsignedDecimal('min')->comment('最小金额');
            $table->unsignedDecimal('max')->comment('最大金额');
            $table->unsignedDecimal('rebate')->comment('返点比例，如：0.05');
            $table->timestamps();

            $table->index(['min', 'max']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
