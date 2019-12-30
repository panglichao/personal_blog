<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDelete;

class ArticleToTag extends Model {

    protected $table = 'articles_to_tags';

    protected $dates = ['deleted_at'];
}
