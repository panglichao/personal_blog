<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {

    use SoftDeletes;

    protected $table = 'articles';

    protected $dates = ['deleted_at'];

    public function getUser(){
        return $this->hasOne('App\Modles\Admin\User', 'id', 'user_id');
    }

    public function getCategory(){
        return $this->hasOne('App\Modles\Admin\Category', 'id', 'category_id');
    }

    public function getTag(){
        return $this->belongsToMany('App\Modles\Admin\Tag', 'articles_to_tags', 'article_id', 'tag_id');
    }

}
