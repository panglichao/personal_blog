<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->comment('标题');
            $table->integer('category_id')->comment('栏目');
            $table->integer('user_id')->comment('小编');
            $table->integer('click')->comment('点击量');
            $table->enum('is_show', ['yes', 'no'])->default('yes')->comment('是否显示');
            $table->string('thumb')->nullable()->comment('标题图');
            $table->string('keywords')->comment('关键词');
            $table->text('description')->comment('简介');
            $table->longText('content')->comment('内容');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['title']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
