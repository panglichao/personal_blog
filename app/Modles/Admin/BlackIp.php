<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;

class BlackIp extends Model {

    protected $table = 'black_ip';

    protected $fillable = ['ip'];
}
