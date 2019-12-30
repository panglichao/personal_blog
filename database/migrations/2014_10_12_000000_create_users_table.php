<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',32)->comment('用户名');
            $table->string('email')->comment('邮箱');
            $table->string('password')->comment('密码');
            $table->rememberToken();
            $table->enum('status', ['active', 'forbidden'])->default('active')->comment('确认');
            $table->enum('is_admin', ['yes', 'no'])->default('yes')->comment('管理员');
            $table->timestamp('last_login')->nullable()->comment('上次登录时间');
            $table->string('request_ip',20)->comment('上次登录ip');
            $table->timestamp('deleted_at')->nullable()->comment('软删除');
            $table->timestamps();
            $table->unique(['username','email']);
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
