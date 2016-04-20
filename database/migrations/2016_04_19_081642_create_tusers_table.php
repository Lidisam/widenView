<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);//用户户名
            $table->string('password', 100);//密码，如果是第三方应用登陆可空
            $table->string('interlink', 200);//头像连接
            $table->integer('salt');//密码令牌
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
        Schema::drop('tusers');
    }
}
