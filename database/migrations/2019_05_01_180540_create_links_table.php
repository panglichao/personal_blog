<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32)->comment('友链名');
            $table->string('url')->comment('友链地址');
            $table->string('thumb')->nullable()->comment('logo图');
            $table->enum('is_show', ['yes', 'no'])->default('yes')->comment('是否显示');
            $table->string('description')->comment('友链描述');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name','url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
