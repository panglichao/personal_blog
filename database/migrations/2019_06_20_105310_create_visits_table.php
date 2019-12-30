<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip',20)->comment('请求客户端ip');
            $table->char('country_code')->comment('请求客户端ip所对应的国家代码');
            $table->string('userAgent')->comment('请求客户端userAgent');
            $table->string('platform',10)->comment('请求客户端操作系统');
            $table->string('platform_version',20)->comment('请求客户端操作系统版本号');
            $table->string('browser',10)->comment('请求客户端浏览器');
            $table->string('browser_version',20)->comment('请求客户端浏览器版本号');
            $table->string('device',10)->comment('请求客户端设备');
            $table->enum('is_black', ['yes', 'no'])->default('no')->comment('是否黑名单用户');
            $table->timestamps();
            $table->index(['ip','country_code','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
