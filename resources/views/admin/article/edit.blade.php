<link rel="stylesheet" href="/layui/css/layui.css">
<link rel="stylesheet" href="{{asset('css/app.css')}}">
<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
<script src="/layui/layui.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .layui-form-checkbox span{
        max-height: 18px;
    }
</style>
<div style="padding: 30px;">
    <form class="layui-form layui-form-pane">
        <input type="hidden" value="{{$article->id}}" id="id">
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" value="{{$article->title}}" id="title" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>栏目</label>
            <div class="layui-input-block">
                <select name="category_id" lay-filter="category_id" id="category_id">
                    <option value=""></option>
                    @if(!empty($data))
                        @foreach($data as $key => $value)
                            <option value="{{$value->id}}" @if($article->category_id == $value->id) selected @endif> @if($value->parent_id != 0)├─{{str_repeat('─',$value['level']*2).$value->name}}@else{{$value->name}}@endif</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        @if(!empty($tags))
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">标签</label>
                <div class="layui-input-block">
                    <!--打开页面显示标签选中-->
                    @foreach($tags as $tag)
                        <input type="checkbox" name="tag_id" value="{{$tag->id}}" title="{{$tag->name}}" <?php if(in_array($tag->id,$tag_ids)){echo 'checked';} ?> lay-skin="primary">
                    @endforeach
                </div>
            </div>
        @endif
        <div class="layui-form-item" pane="">
            <label class="layui-form-label"><font color="red">*</font>显示</label>
            <div class="layui-input-block">
                <input type="checkbox" id="is_show" name="is_show" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" @if($article->is_show == 'yes') checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="thumb">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
                @if($article->thumb)
                    <a href="http://personal_blog.com/{{$article->thumb}}" target="_blank">{{$article->thumb}}</a>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>关键词</label>
            <div class="layui-input-block">
                <input type="text" name="keywords" value="{{$article->keywords}}" id="keywords" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>介绍</label>
            <div class="layui-input-block">
                <input type="text" name="description" value="{{$article->description}}" id="description" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <!--这是我规定的一个隐藏域。用来获取服务器传过来的数据，并且通过js，把服务器传过来的数据显示在页面上-->
        <input class="input-xlarge focused" style="float:left;" name="mycontent" type="hidden" id="mycontent" value="{{$article->content}}" >
        <!---->
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><font color="red">*</font>内容</label>
            <div class="layui-input-block">
                <!--这里最外围的editor是编辑器-->
                <!--info是通过js赋值的部分。这里不能直接把数据库的值通过innerHTML赋值给编辑器，不然的话，编辑器会显示不出来，所以这里就新建了一个空的div，用来存放解析数据库的html代码-->
                <div id="editor">
                    <div id="info"></div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="text-align: center">
            <button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </form>
</div>
<script type="text/javascript" src="/wangEditor-3.1.1/release/wangEditor.min.js"></script>
    <script>
        $(function () {
            var host = 'http://'+location.host+'/';
            var E = window.wangEditor;
            var editor = new E('#editor');
            editor.customConfig.uploadImgServer = '/api/upload'; // 配置服务器端地址
            editor.customConfig.uploadFileName = 'file'; // 设置文件的name值
            // 上传文件监听
            editor.customConfig.uploadImgHooks = {
                customInsert: function (insertImg, result) {
                    var url = host+result.path;
                    //上传图片回填富文本编辑器
                    insertImg(url);
                }
            };
            editor.create();

            layui.use('upload', function(){
                var upload = layui.upload;
                var uploadInst = upload.render({
                    elem: '#thumb' //绑定元素
                    ,type : 'images' //文件类型(可省默认images)
                    ,exts: 'jpg|png|gif|jpeg' //文件格式
                    // ,data: {width:200,height:200} //可选项。额外的参数
                    ,url: '/api/upload' //上传接口
                    ,multiple: false //单图片
                    ,number: 1 //同时上传个数
                    ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        layer.load(); //上传loading
                    }
                    ,done: function(res){
                        layer.closeAll('loading'); //关闭loading
                        //上传完毕回调
                        if(res.msg == 'success'){
                            layer.msg('上传成功！',{icon: 6});
                            $('a').remove();//移除旧元素
                            $('#thumb').parent('.layui-input-block').append('<a target="_blank" href="http://personal_blog.com/'+res.path+'">'+res.path+'</a>');
                        }else if(res.msg == 'error'){
                            layer.msg('格式有误！',{icon: 5});
                        }else{
                            layer.msg('上传失败！',{icon: 5});
                        }
                    }
                    ,error: function(){
                        //请求异常回调（一般为网络异常、URL 404等）。返回两个参数，分别为：index（当前文件的索引）、upload（重新上传的方法）。详见下文
                        layer.closeAll('loading');
                        layer.msg('网络异常，请稍后重试！');
                    }
                });
            });

            layui.use(['form'], function () {
                var form = layui.form;
                form.on('submit(submit)', function(e){
                    // 读取 html
                    var content = editor.txt.html();
                    //读取的时候把父级div=info也带入了，所以想去掉这个div
                    content = content.slice(15);
                    var title = $("#title").val();
                    var category_id = $("#category_id").val();
                    var keywords = $("#keywords").val();
                    var description = $("#description").val();
                    var tag_ids = new Array();
                    @if(!empty($tags))
                    $("input[name='tag_id']:checkbox").each(function(){
                        if($(this).attr("checked")){
                            tag_ids.push($(this).val());
                        }
                    });
                    @endif
                    if($('#is_show').is(':checked')){
                        var is_show = 'yes';
                    }else{
                        var is_show = 'no';
                    }
                    if($('a').text()){
                        var thumb = $('a').text();
                    }else{
                        var thumb = '';
                    }
                    if(!name || !keywords || !description || !content || !category_id){
                        layer.msg('请填写完整数据！',{icon: 5});
                        return false;
                    }
                    var json = {
                        title:title,
                        category_id:category_id,
                        is_show:is_show,
                        thumb:thumb,
                        keywords:keywords,
                        description:description,
                        content:content,
                        tag_ids:tag_ids,
                        id:'{{$article->id}}'
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/admin/article/edit',
                        data: json,
                        dataType: 'json',
                        async: 'false',
                        success: function (res) {
                            if(res.msg == 'success'){
                                layer.msg('编辑成功！',{icon: 6},function (index) {
                                    layer.close(index);
                                });
                                parent.location.reload();
                            }else if(res.msg == 'error'){
                                layer.msg('图片更新出错！没有找到原图！',{icon: 5});
                            }else{
                                layer.msg('编辑失败！文章标题重复！',{icon: 5});
                            }
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });
                    return false;
                });

            });

        });

        //从服务器数据库返回我们的html代码都成字符串了，也难怪不解析html代码
        window.onload=function()
        {
            //第一步是先获取服务器传过来的图文信息值
            var mycontent = document.getElementById("mycontent").value;
            //把图文信息的值通过innerHTML赋值给编辑器
            document.getElementById("info").innerHTML = mycontent;
        }

    </script>