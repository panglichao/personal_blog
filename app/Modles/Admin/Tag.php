<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model {

    use SoftDeletes;

    protected $table = 'tags';

    protected $dates = ['deleted_at'];

    public function getArticle(){
        return $this->belongsToMany('App\Modles\Admin\Article', 'articles_to_tags', 'tag_id', 'article_id');
    }

}
