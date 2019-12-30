@extends('admin/layouts/base')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <blockquote class="layui-elem-quote">
        密码设置
    </blockquote>
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">旧密码</label>
            <div class="layui-input-block">
                <input type="password" name="old_password" value="" id="old_password" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
                <input type="password" name="new_password" value="" id="new_password" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认新密码</label>
            <div class="layui-input-block">
                <input type="password" name="confirm_password" value="" id="confirm_password" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <span class="layui-btn" lay-submit="" lay-filter="submit">保存</span>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
    <script>
        $(function () {
            layui.use(['form'], function () {
                var form = layui.form;
                var json = {};
                form.on('submit(submit)', function(e){
                    var old_password = $('#old_password').val();
                    var new_password = $('#new_password').val();
                    var confirm_password = $('#confirm_password').val();
                    if(!old_password || !new_password || !confirm_password){
                        layer.msg('请输入密码！',{icon: 5});
                        return false;
                    }
                    if(new_password != confirm_password){
                        layer.msg('密码输入不一致！',{icon: 5});
                        return false;
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/admin/user/password',
                        data: {old_password:old_password, new_password:new_password, confirm_password:confirm_password},
                        dataType: 'json',
                        async: 'false',
                        success: function (res) {
                            if(res.status == 'success'){
                                layer.msg('设置成功！',{icon: 6});
                                setTimeout(function(){
                                    location.reload();
                                    }, 2000);
                            }else{
                                layer.msg('设置失败！',{icon: 5});
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
@endsection