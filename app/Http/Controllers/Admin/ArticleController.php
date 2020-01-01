<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modles\Admin\Category;
use App\Modles\Admin\Article;
use App\Modles\Admin\Tag;
use App\Modles\Admin\ArticleToTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticleController extends BaseController
{
    //每个页面必须传递各模块(菜单)配置$menu
    public function index(Request $request){
        $articles = Article::orderBy('updated_at','desc')->paginate(15);
        return view('admin/article/index', ['menu' => $this->menu, 'articles' => $articles]);
    }

    public function add(Request $request){
        if($request->isMethod('get')){
            $category = new Category;
            $data = $category->getCategory(Category::all());
            $tags = Tag::all();
            return view('admin/article/add', ['menu' => $this->menu, 'data' => $data, 'tags' => $tags]);
        } else{
            if(Article::where('title',$request->input('title'))->first()){
                return ['msg' => 'fail'];
            }else{
                $data = $request->all();
                //文章表保存
                $article = new Article;
                $article->title        = $data['title'];
                $article->category_id  = $data['category_id'];
                $article->is_show      = $data['is_show'];
                $article->user_id      = Auth::id();
                $article->click        = 0;
                $article->thumb        = $data['thumb'];
                $article->keywords     = $data['keywords'];
                $article->description  = $data['description'];
                $article->content      = $data['content'];
                $article->save();
                $insertId = $article->id;
                //文章，标签中间表保存
                if(!empty($data['tag_ids'])){
                    $array = [];
                    $dateTime = Carbon::now()->toDateTimeString();
                    foreach ($data['tag_ids'] as $k => $v){
                        $array[$k]['article_id'] = $insertId;
                        $array[$k]['tag_id'] = $v;
                        $array[$k]['created_at'] = $dateTime;
                        $array[$k]['updated_at'] = $dateTime;
                    }
                    DB::table('articles_to_tags')->insert($array);
                }
                return ['msg' => 'success'];
            }
        }
    }

    public function edit(Request $request){
        if($request->isMethod('get')){
            $id = $request->input('id');
            $article = Article::find($id);
            $category = new Category;
            $data = $category->getCategory(Category::all());
            $tags = Tag::all();
            $tag_ids = [];
            //找到关联的标签id
            if(count($article->getTag)>0){
                foreach ($article->getTag as $value){
                    $tag_ids[] = $value['id'];
                }
            }
            return view('admin/article/edit', ['menu' => $this->menu, 'data' => $data, 'article' => $article,
                'tags' => $tags, 'tag_ids' => $tag_ids]);
        }else{
            $data = $request->all();
            $num = Article::where('title',$data['title'])->count();
            if($num>1){
                return ['msg' => 'fail'];
            }else{
                $article = Article::find($data['id']);
                //删除旧图(包含多图)
                if($data['thumb'] != $article->thumb){
//                    if($this->batchUnlink($article->thumb)){
                    if($this->unlinkOld($article->thumb)){
                        return ['msg' => 'error'];
                    }
                }
                $article->title         = $data['title'];
                $article->category_id    = $data['category_id'];
                $article->is_show      = $data['is_show'];
                $article->thumb        = $data['thumb'];
                $article->keywords     = $data['keywords'];
                $article->description  = $data['description'];
                $article->content      = $data['content'];
                $article->save();
                //文章，标签中间表
                if(!empty($data['tag_ids'])){
                    //找原来的关联中间表该文章所有标签数据
                    $articleToTag = ArticleToTag::where('article_id',$data['id'])->get();
                    //方法1、
                    //删除全部的该原关联数据再重新添加关联数据
                    $artToTagIds = $this->getArtToTagIds($articleToTag);
                    ArticleToTag::destroy($artToTagIds);
                    $array = [];
                    $dateTime = Carbon::now()->toDateTimeString();
                    foreach ($data['tag_ids'] as $k => $v){
                        $array[$k]['article_id'] = $data['id'];
                        $array[$k]['tag_id'] = $v;
                        $array[$k]['created_at'] = $dateTime;
                        $array[$k]['updated_at'] = $dateTime;
                    }
                    DB::table('articles_to_tags')->insert($array);
                    //方法2、
                    //取原来tag_id和post提交的tag_id数组的交集
                    //把获得的交集tag_id和原来的tag_id比，取差集
                    //根据差集tag_id和articleId删除该关联中间表数据
                    //把获得的交集tag_id和post的tag_id比，取差集
                    //判断得到的差集不为空写入数据库
                }

                return ['msg' => 'success'];
            }
        }
    }

    //因模型配置了软删除，实际执行的是软删除
    //单个删除
    public function del(Request $request){
        $id = $request->input('id');
        $article = Article::find($id);
        if($article){
            $article->delete();
            //删除对应的中间表关联数据
            $articleToTag = ArticleToTag::where('article_id',$id)->get();
            $artToTagIds = $this->getArtToTagIds($articleToTag);
            ArticleToTag::destroy($artToTagIds);
            return ['result' => true];
        }
    }

    //批量选中删除，执行软删除
    public function batchDel(Request $request){
        $ids = $request->input('ids');
        Article::destroy($ids);
        //删除对应的中间表关联数据
        $articleToTag = ArticleToTag::whereIn('article_id',$ids)->get();
        $artToTagIds = $this->getArtToTagIds($articleToTag);
        ArticleToTag::destroy($artToTagIds);
        return ['result' => true];
    }

    //切换显示状态
    public function switch(Request $request){
        $id = $request->input('id');
        $article = Article::find($id);
        if($article){
            $article->is_show = ($article->is_show == 'yes' ? 'no' : 'yes') ;
            $article->save();
            return ['result' => true];
        }
    }

    //批量选中切换显示状态
    public function batchSwitch(Request $request){
        $ids = $request->input('ids');
        $ids = implode(',',$ids);
        $sql = "UPDATE articles SET is_show = 
                CASE WHEN is_show = 'yes' THEN 'no'
                WHEN is_show = 'no' THEN 'yes'
                ELSE is_show
                END
                WHERE id IN ($ids)";
        DB::update(DB::raw($sql));
        return ['result' => true];
        //DB::table('xx')->whereIn('primaryKey',[1,3,5])->update(['status'=>1]);
    }

//    //删除旧图(包含多图，批量)
//    public function batchUnlink($thumb){
//        $thumbs = substr($thumb, 0, -1);
//        $thumbs = explode(',',$thumbs);
//        $thumbs = array_filter($thumbs);
//        foreach ($thumbs as $key => $value){
//            if(file_exists($value)){
//                unlink($value);
//            }else{
//                return false;
//            }
//        }
//    }

    //删除旧图
    public function unlinkOld($thumb){
        if(file_exists($thumb)){
            unlink($thumb);
        }else{
            return false;
        }
    }

    //通过得到的文章标签关联数据集合，拆分一维数组
    public function getArtToTagIds($articleToTag){
        $artToTagIds = [];
        foreach ($articleToTag as $v){
            $artToTagIds[] = $v->id;
        }
        return $artToTagIds;
    }

}