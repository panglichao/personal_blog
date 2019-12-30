<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    /**
     * 图片上传接口
     *
     * @param Request $request
     *
     * @return string $json
     */
    public function upload(Request $request){
        $data = $request->all();
        // 文件对象
        $thumb = $data['file'];
        // 验证图片的类型
        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
        if ($thumb->getClientOriginalExtension() && !in_array($thumb->getClientOriginalExtension(), $allowed_extensions)) {
            return ['msg' => 'error'];
        }
        // public 文件夹下面建 uploads 文件夹
        $destinationPath = 'uploads/';
        // 获取来源（上一次的地址）
        $referer = url()->previous();
        // 调用获取目录的方法
        $folder = $this->getFolder($referer);
        // 匹配指定目录
        $destinationPath = $destinationPath.$folder.'/';
        // 上传文件的后缀
        $extension = $thumb->getClientOriginalExtension();
        // 设置文件名称
        $fileName = str_random(random_int(6,18)).'.'.$extension;
        // 移动文件到对应位置
        $thumb->move($destinationPath, $fileName);
        // 返回图片地址
        $filePath = $destinationPath.$fileName;
        // 如果限制了图片宽度、高度，就进行裁剪 （多用于头像裁剪）
        // 接收前端接口传参
        if(array_key_exists('width',$data) && array_key_exists('height',$data)){
            if($data['width'] && $data['height']){
                // 先实例化，传参是文件的磁盘物理路径，进行大小调整的操作
                $image = Image::make($filePath)->resize($data['width'], $data['height']);
                // 对图片修改后进行保存
                $image->save($filePath);
            }
        }
        if($filePath){
            return ['msg' => 'success', 'path' => $filePath];
        }else{
            return ['msg' => 'fail'];
        }
    }

    /**
     * 区分目录
     *
     * @param string $url
     *
     * @return string $folder
     */
    public function getFolder($referer){
        if(strpos($referer,'category') !== false){
            return 'category';
        }elseif (strpos($referer,'article') !== false){
            return 'article';
        }elseif (strpos($referer,'link') !== false) {
            return 'link';
        }elseif (strpos($referer,'user') !== false) {
            return 'user';
        }else{
            return 'other';
        }
    }


}