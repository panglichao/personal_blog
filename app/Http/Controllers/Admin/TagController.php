<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modles\Admin\Tag;

class TagController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $tags = Tag::orderBy('updated_at','desc')->paginate(15);
        return view('admin/tag/index', ['menu' => $this->menu, 'tags' => $tags]);
    }

    public function add(Request $request){
        if($request->isMethod('get')){
            return view('admin/tag/add', ['menu' => $this->menu]);
        } else{
            if(Tag::where('name',$request->input('name'))->first()){
                return ['msg' => 'fail'];
            }else{
                $data = $request->all();
                $tag = new Tag();
                $tag->name         = $data['name'];
                $tag->description  = $data['description'];
                $tag->save();
                return ['msg' => 'success'];
            }
        }
    }

    public function edit(Request $request){
        if($request->isMethod('get')){
            $id = $request->input('id');
            $tag = Tag::find($id);
            return view('admin/tag/edit', ['menu' => $this->menu, 'tag' => $tag]);
        }else{
            $data = $request->all();
            $num =Tag::where('name',$data['name'])->count();
            if($num>1){
                return ['msg' => 'fail'];
            }else{
                $tag = Tag::find($data['id']);
                $tag->name        = $data['name'];
                $tag->description  = $data['description'];
                $tag->save();
                return ['msg' => 'success'];
            }
        }
    }

    //因模型配置了软删除，实际执行的是软删除
    public function del(Request $request){
        $id = $request->input('id');
        $tag = Tag::find($id);
        $tag->delete();
        return ['result' => true];
    }

}