<?php

namespace App\Http\Controllers\Admin;

use App\Modles\Visit;
use App\Modles\Admin\BlackIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $visits = Visit::orderBy('updated_at','desc')->paginate(15);
        return view('admin/visit/index', ['menu' => $this->menu, 'visits' => $visits]);
    }

    public function switch(Request $request){
        $ip = $request->ip;
        $type = $request->type;
        DB::update(DB::raw("UPDATE visits SET is_black = '$type' WHERE ip = '$ip'"));
        if($type == 'yes'){
            BlackIp::create(['ip' => $ip]);
        }else{
            BlackIp::where('ip',$ip)->delete();
        }
        return ['result' => true];
    }

}