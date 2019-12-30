<link rel="stylesheet" href="/layui/css/layui.css">
<link rel="stylesheet" href="{{asset('css/app.css')}}">
<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
<script src="/layui/layui.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="padding: 30px;">
    <form class="layui-form layui-form-pane">
        <input type="hidden" value="{{$link->id}}" id="id">
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>友链名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$link->name}}" id="name" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>域名地址</label>
            <div class="layui-input-block">
                <input type="text" name="url" value="{{$link->url}}" id="url" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label"><font color="red">*</font>显示</label>
            <div class="layui-input-block">
                <input type="checkbox" id="is_show" name="is_show" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" @if($link->is_show == 'yes') checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="thumb">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                </button>
                @if($link->thumb)
                    <a>{{$link->thumb}}</a>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" value="{{$link->description}}" id="description" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item" style="text-align: center">
            <button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </form>
</div>
    <script>
        $(function () {
            layui.use('upload', function(){
                var upload = layui.upload;
                var uploadInst = upload.render({
                    elem: '#thumb' //绑定元素
                    ,type : 'images' //文件类型(可省默认images)
                    ,exts: 'jpg|png|gif|jpeg' //文件格式
                    // ,data: {width:200,height:200} //可选项。额外的参数
                    ,url: '/api/upload' //上传接口
                    ,done: function(res){
                        //上传完毕回调
                        if(res.msg == 'success'){
                            layer.msg('上传成功！',{icon: 6});
                            $('a').remove();//移除旧元素
                            $('#thumb').parent('.layui-input-block').append('<span>'+res.path+','+'</span>');
                        }else if(res.msg == 'error'){
                            layer.msg('格式有误！',{icon: 5});
                        }else{
                            layer.msg('上传失败！',{icon: 5});
                        }
                    }
                    ,error: function(){
                        //请求异常回调（一般为网络异常、URL 404等）。返回两个参数，分别为：index（当前文件的索引）、upload（重新上传的方法）。详见下文
                    }
                });
            });

            layui.use(['form'], function () {
                var form = layui.form;
                var json = {};
                // form.render();重新渲染
                form.on('submit(submit)', function(e){
                    var name = $("#name").val();
                    var url = $("#url").val();
                    var description = $("#description").val();
                    var id = $("#id").val();
                    if($('#is_show').is(':checked')){
                        var is_show = 'yes';
                    }else{
                        var is_show = 'no';
                    }
                    if($('a').text() || $('span').text()){
                        //thumb所有同级的元素文本值(多图)
                        var thumb = $("#thumb").siblings().text();
                    }else{
                        var thumb = '';
                    }
                    if(!name || !url || !description){
                        layer.msg('请填写完整数据！',{icon: 5});
                        return false;
                    }
                    json = {
                        name:name,
                        url:url,
                        is_show:is_show,
                        thumb:thumb,
                        description:description,
                        id:id
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/admin/link/edit',
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
                                layer.msg('编辑失败！友链重复！',{icon: 5});
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
    </script>