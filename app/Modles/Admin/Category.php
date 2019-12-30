<?php

namespace App\Modles\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {

    use SoftDeletes;

    protected $table = 'categories';

    protected $dates = ['deleted_at'];

    //使用递归获取分类
    public function getCategory($resource, $pid=0, $level=0){
        if(empty($resource)){
            return '';
        }
        static $list =[];
        foreach ($resource as $key => $value) {
            if($value->parent_id == $pid){
                $list[$key] = $value;
                $list[$key]['level'] = $level;
                $list[$key]['child'] = $this->getCategory($resource, $value->id, $level+1);
            }
        }
        return $list;
    }

    //获取所有的栏目
    public function getIds($id){
        $resource = self::all();
        return $this->getChildIds($resource,$id);
    }

    //使用递归获取该栏目的所有子栏目
    public function getChildIds($resource,$pid){
        static $items = [];
        foreach ($resource as $k=>$v){
            if($v->parent_id == $pid){
                $items[$k] = $v->id;
                $this->getChildIds($resource,$v->id);
            }
        }
        return $items;
    }

}
