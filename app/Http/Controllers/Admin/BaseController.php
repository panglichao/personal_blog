<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //获取各模块模块(菜单)配置
    public $menu;

    public function __construct()
    {
        return $this->menu = config('menu');
    }

}