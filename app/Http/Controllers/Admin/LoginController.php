<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modles\Admin\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login()
    {
        $referer = url()->previous();
        if($referer == url()->full() || empty($referer) || empty(url()->full())){
            $referer = $_SERVER['REQUEST_URI'].'/admin';
        }
        session(['referer' => $referer]);
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('admin/login/login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->status == 'active') {
                $user = User::find(Auth::user()->id);
                $user->request_ip = $request->getClientIp();;
                $user->last_login = Carbon::now()->toDateTimeString();
                $user->save();
                return array('msg' => 'success', 'referer' => session('referer'));
            } else {
                Auth::logout();
                return array('msg' => 'fail');
            }
        } else {
            return array('msg' => 'error');
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flush();
        return redirect('/admin/login');
    }
}