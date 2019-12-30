<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model {

    use SoftDeletes;

    protected $table = 'links';

    protected $dates = ['deleted_at'];

}
