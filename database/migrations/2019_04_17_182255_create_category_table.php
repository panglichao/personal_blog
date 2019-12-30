<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->comment('父栏目');
            $table->string('name',32)->comment('栏目名');
            $table->enum('type', ['page', 'list'])->default('list')->comment('栏目类型');
            $table->enum('is_show', ['yes', 'no'])->default('yes')->comment('是否显示');
            $table->string('thumb')->nullable()->comment('栏目图');
            $table->string('keywords')->comment('关键词');
            $table->integer('sort_id')->nullable()->comment('排序');
            $table->text('description')->comment('简介');
            $table->longText('content')->comment('内容');
            $table->timestamps();
            $table->softDeletes();
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
