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
        <input type="hidden" value="{{$tag->id}}" id="id">
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>标签名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$tag->name}}" id="name" class="layui-input" autocomplete="off" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><font color="red">*</font>描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" value="{{$tag->description}}" id="description" class="layui-input" autocomplete="off" lay-verify="required">
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
            layui.use(['form'], function () {
                var form = layui.form;
                form.on('submit(submit)', function(e){
                    var name = $("#name").val();
                    var description = $("#description").val();
                    if(!name || !description){
                        layer.msg('请填写完整数据！',{icon: 5});
                        return false;
                    }
                    var json = {
                        name:name,
                        description:description,
                        id:'{{$tag->id}}'
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/admin/tag/edit',
                        data: json,
                        dataType: 'json',
                        async: 'false',
                        success: function (res) {
                            if(res.msg == 'success'){
                                layer.msg('编辑成功！',{icon: 6},function (index) {
                                    layer.close(index);
                                });
                                parent.location.reload();
                            }else{
                                layer.msg('编辑失败！标签名重复！',{icon: 5});
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