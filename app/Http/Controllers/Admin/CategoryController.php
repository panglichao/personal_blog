<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modles\Admin\Category;

class CategoryController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $category = new Category;
        $data = $category->getCategory(Category::orderBy('sort_id','asc')->get());
        return view('admin/category/index', ['menu' => $this->menu, 'data' => $data]);
    }

    public function add(Request $request){
        $category = new Category;
        if($request->isMethod('get')){
            $data = $category->getCategory(Category::all());
            return view('admin/category/add', ['menu' => $this->menu, 'data' => $data]);
        }else{
            if(Category::where('name',$request->input('name'))->first()){
                return ['msg' => 'fail'];
            }else{
                $data = $request->all();
                $category->name         = $data['name'];
                $category->parent_id    = $data['parent_id'];
                $category->type         = $data['type'];
                $category->is_show      = $data['is_show'];
                $category->thumb        = $data['thumb'];
                $category->keywords     = $data['keywords'];
                $category->description  = $data['description'];
                $category->content      = $data['content'];
                $category->sort_id      = 99;
                $category->save();
                return ['msg' => 'success'];
            }
        }
    }

    public function edit(Request $request){
        if($request->isMethod('get')){
            $id = $request->input('id');
            $category = Category::find($id);
            $data = $category->getCategory(Category::all());
            return view('admin/category/edit', ['menu' => $this->menu, 'data' => $data, 'category' => $category]);
        }else{
            $data = $request->all();
            $num = Category::where('name',$data['name'])->count();
            if($num>1){
                return ['msg' => 'fail'];
            }else{
                $category = Category::find($data['id']);
                //删除旧图
                if($data['thumb'] != $category->thumb){
                    if($this->unlinkOld($category->thumb)){
                        return ['msg' => 'error'];
                    }
                }
                $category->name         = $data['name'];
                $category->parent_id    = $data['parent_id'];
                $category->type         = $data['type'];
                $category->is_show      = $data['is_show'];
                $category->thumb        = $data['thumb'];
                $category->keywords     = $data['keywords'];
                $category->description  = $data['description'];
                $category->content      = $data['content'];
                $category->save();
                return ['msg' => 'success'];
            }
        }
    }

    //因模型配置了软删除，实际执行的是软删除
    public function del(Request $request){
        $id = $request->input('id');
        $category = Category::find($id);
        if($category){
            $ids = $category->getIds($id);
            array_push($ids,$id);
            Category::destroy($ids);
            return ['result' => true];
        }
    }

    //删除旧图
    public function unlinkOld($thumb){
        if(file_exists($thumb)){
            unlink($thumb);
        }else{
            return false;
        }
    }

    //即时排序
    public function sort(Request $request){
        $id = $request->input('id');
        $sort_id = $request->input('sort_id');
        $category = Category::find($id);
        $category->sort_id = $sort_id;
        $category->save();
        return ['result' => true];
    }

    //切换显示状态
    public function switch(Request $request){
        $id = $request->input('id');
        $category = Category::find($id);
        if($category){
            $category->is_show = ($category->is_show == 'yes' ? 'no' : 'yes') ;
            $category->save();
            return ['result' => true];
        }
    }

    //批量选中后操作
    public function batch(){
        //暂不做
    }

}