<?php

namespace App\Http\Controllers\Admin;

use App\Modles\Visit;
use App\Modles\Admin\BlackIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Excel;

class BlackIpController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $blackIps = BlackIp::orderBy('created_at','desc')->paginate(15);
        return view('admin/blackip/index', ['menu' => $this->menu, 'blackIps' => $blackIps]);
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
                'ip' => 'required|ip',
            ],[
                'ip.required' => 'IP不能为空',
                'ip.ip' => 'IP无效'
            ]
        );
        if ( $validator->fails() ) {
            return ['msg' => $validator->getMessageBag()->first()];
        }
        $blackIp = BlackIp::where('ip',$request->ip)->first();
        if($blackIp){
            return ['msg' => '此IP已存在'];
        }
        BlackIp::create(['ip' => $request->ip]);
        DB::update(DB::raw("UPDATE visits SET is_black = 'yes' WHERE ip = '$request->ip'"));
        return ['msg' => 'success'];
    }

    public function del(Request $request){
        $blackIp = BlackIp::find($request->id);
        DB::update(DB::raw("UPDATE visits SET is_black = 'no' WHERE ip = '$blackIp->ip'"));
        $blackIp->delete();
        return ['result' => true];
    }

    public function import(Request $request){
        $file = $request->file('file');
        $filePath = $file->getPathname();
        $fileType = $file->getClientOriginalExtension();
        $res = [];
        $allowed_extensions = ["xlsx", "xls", "crv","excel"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ['msg' => 'error'];
        }
        Excel::load($filePath, function ($reader) use (&$res) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
            $blackIps = self::getBlackIps();
            $success = 0;
            $repeat = 0;
            $all = count($res)-1;
            for($i = 1;$i<count($res);$i++){
                if(in_array($res[$i][0],$blackIps)){
                    $repeat = $repeat+1;
                    continue;
                }else{
                    //判断是否是合法IP
                    if(filter_var($res[$i][0], FILTER_VALIDATE_IP)) {
                        $data = [
                            'ip' => $res[$i][0],
                            'created_at' => date('Y-m-d H:i:s', time()),
                            'updated_at' => date('Y-m-d H:i:s', time())
                        ];
                        $id = BlackIp::insertGetId($data);
                        if($id){
                            $success = $success+1;
                        }
                    }
                }
            }
            $error = $all-$success;
            $problem = $error-$repeat;
            if($error == 0){
                echo  json_encode(array('status' => 'ok', 'msg' => '全部导入成功共'.$success.'条'));
            }else{
                echo  json_encode(array('status' => 'ok',
                    'msg' => '导入成功'.$success.'条'.'失败'.$error.'条;其中重复'.$repeat.'条,问题'.$problem.'条'));
            }
        });
    }

    public static function getBlackIps(){
        $array = [];
        $blackIps = BlackIp::all();
        if($blackIps){
            foreach ($blackIps as $blackIp){
                $array[] = $blackIp->ip;
            }
            return $array;
        }else{
            return $array;
        }
    }
}