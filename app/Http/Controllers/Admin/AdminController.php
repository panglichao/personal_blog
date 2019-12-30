<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modles\Admin\User;
use App\Modles\Admin\Category;
use App\Modles\Admin\Article;
use App\Modles\Admin\Comment;
use App\Modles\Admin\Visit;

class AdminController extends BaseController
{
    //每个页面必须继承BaseController传递各模块(菜单)配置$menu
    public function index(Request $request)
    {
        return view('admin/home/index', ['menu' => $this->menu]);

        //统计数据
//        $category = Category::count();
//        $article = Article::count();
//        $comment = Comment::count();
//        $visit = Visit::count();
//        $count = ['category' => $category, 'article' => $article, 'comment' => $comment, 'visit' => $visit];;

        //当前登录用户数据
//        $user = Auth::user();

        //调用getUV获取UV
        //$uv = $this->getUV();

        //绑定参数渲染视图
        //return view('admin/home/index', ['menu' => $this->menu, 'count' => $count, 'uv' => '$uv'])
    }

    //访客量UV变化趋势图(默认week,日期选择器)
//    public function getUV(){
//
//    }

    //访客数据表格(默认week,日期选择器)
//    public function getVisit(){
//
//    }

}