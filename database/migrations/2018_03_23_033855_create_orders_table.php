<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * 订单
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['alipay', 'wechat'])->comment('支付类型');
            $table->enum('status', ['success', 'fail', 'close', 'wait', 'refund'])->default('wait')->comment('订单状态');
            $table->unsignedInteger('total_fee')->nullable()->comment('支付金额（分）');
            $table->string('out_trade_no', 32)->nullable()->comment('商家订单号');
            $table->string('transaction_id', 32)->nullable()->comment('交易号');
            $table->unsignedInteger('user_id')->index()->comment('所属用户');
            $table->timestamp('pay_at')->nullable()->comment('支付时间');
            $table->timestamps();

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
        Schema::dropIfExists('orders');
    }
}
