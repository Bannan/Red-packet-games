<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * 会员
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 32)->unique()->index()->comment('微信id');
            $table->string('mobile')->unique()->comment('手机号');
            $table->string('password')->comment('密码');
            $table->string('safety_code')->comment('安全码');
            $table->string('nickname', 30)->nullable()->comment('昵称');
            $table->string('api_token', 64)->nullable()->comment('token认证');
            $table->string('parent_id')->nullable()->index()->comment('推荐人id');
            $table->text('link_id')->nullable()->comment('下属人员id，多个以逗号隔开');
            $table->unsignedTinyInteger('robot')->default(0)->index()->comment('机器人');
            $table->unsignedDecimal('balance', 10, 4)->default(0)->comment('余额');
            $table->rememberToken()->comment('记住我');
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
        Schema::dropIfExists('users');
    }
}
