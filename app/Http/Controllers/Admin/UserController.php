<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends BaseController
{
    /**
     * 每个页面必须继承BaseController传递各模块(菜单)配置$menu
     *
     * 个人设置也通过配置文件改(因为一般不需要改动)
     */
    public function index(Request $request){
        $userOptions = config('userOptions');
        return view('admin/user/index', ['menu' => $this->menu , 'userOptions' => $userOptions]);
    }

    /**
     * 修改密码
     *
     * @param Request $request
     *
     * @return $json
     */
    public function password(Request $request){
        if($request->isMethod('get')){
            return view('admin/user/password', ['menu' => $this->menu]);
        }else{
            $user = Auth::user();
            $old_password = $request->input('old_password');
            $new_password = $request->input('new_password');
            $this->validate($request, [
                'old_password' => 'required|min:6|max:255',
                'new_password' => 'required|min:6|max:255',
            ]);
            if(!Hash::check($old_password, $user->password)){
                return ['msg' => '旧密码错误！', 'status' => 'error'];
            }
            $user->password = bcrypt($new_password);
            $user->save();
            session()->flush();
            return ['msg' => '密码设置成功！', 'status' => 'success'];
        }


    }

}