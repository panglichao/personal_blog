<?php

namespace App\Http\Controllers\Admin;

use App\Modles\Admin\Link;
use Illuminate\Http\Request;

class LinkController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $links = Link::orderBy('updated_at','desc')->paginate(15);
        return view('admin/link/index', ['menu' => $this->menu, 'links' => $links]);
    }

    public function add(Request $request){
        if($request->isMethod('get')){
            return view('admin/link/add', ['menu' => $this->menu]);
        } else{
            if(Link::where('name',$request->input('name'))->where('url',$request->input('url'))->first()){
                return ['msg' => 'fail'];
            }else{
                $data = $request->all();
                $link = new Link();
                $link->name         = $data['name'];
                $link->url         = $data['url'];
                $link->is_show      = $data['is_show'];
                $link->thumb        = $data['thumb'];
                $link->description  = $data['description'];
                $link->save();
                return ['msg' => 'success'];
            }
        }
    }

    public function edit(Request $request){
        if($request->isMethod('get')){
            $id = $request->input('id');
            $link = Link::find($id);
            return view('admin/link/edit', ['menu' => $this->menu, 'link' => $link]);
        }else{
            $data = $request->all();
            $num = Link::where('name',$data['name'])->where('url',$data['url'])->count();
            if($num>1){
                return ['msg' => 'fail'];
            }else{
                $link = Link::find($data['id']);
                //删除旧图(包含多图)
                if($data['thumb'] != $link->thumb){
                    if($this->batchUnlink($link->thumb)){
                        return ['msg' => 'error'];
                    }
                }
                $link->name         = $data['name'];
                $link->url          = $data['url'];
                $link->is_show      = $data['is_show'];
                $link->thumb        = $data['thumb'];
                $link->description  = $data['description'];
                $link->save();
                return ['msg' => 'success'];
            }
        }
    }

    //因模型配置了软删除，实际执行的是软删除
    public function del(Request $request){
        $id = $request->input('id');
        $link = Link::find($id);
        $link->delete();
        return ['result' => true];
    }

    //删除旧图(包含多图，批量)
    public function batchUnlink($thumb){
        $thumbs = substr($thumb, 0, -1);
        $thumbs = explode(',',$thumbs);
        $thumbs = array_filter($thumbs);
        foreach ($thumbs as $key => $value){
            if(file_exists($value)){
                unlink($value);
            }else{
                return false;
            }
        }
    }

    //切换显示状态
    public function switch(Request $request){
        $id = $request->input('id');
        $link = Link::find($id);
        if($link){
            $link->is_show = ($link->is_show == 'yes' ? 'no' : 'yes') ;
            $link->save();
            return ['result' => true];
        }
    }

}