<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>{{ config('app.name', 'Laravel_Blog') }}登录</title>
  <link rel="stylesheet" href="/layui/css/layui.css">
  <script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
<style>
	body{
		background: #f1f1f1;
		background-image:url('https://ss0.bdstatic.com/l4oZeXSm1A5BphGlnYG/skin/19.jpg');
		background-size: 100%;
		background-repeat:no-repeat;
	}
	.window{
		width: 400px;
		position: absolute;
		margin-left: -200px;
		margin-top: -80px;
		top: 40%;
		left: 50%;
		display: block;
		z-index: 2000;
		background: #fff;
		padding: 20px 0;
	}
</style>
</head>
<body>
	<div class="window">
		<form class="layui-form">
			<div class="layui-form-item" >
				<div style="text-align: center;">
					<h2>Login</h2>
				</div>
			</div>
			<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
			<div class="layui-form-item" style="margin-right: 100px;margin-top: 20px;">
				<label class="layui-form-label">邮箱：</label>
				<div class="layui-input-block">
					<input type="text" name="email" id="email" required  lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">密码：</label>
				<div class="layui-input-inline">
					<input type="password" name="password" id="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item" pane="">
				<div class="layui-input-block">
					<input type="checkbox" name="remember" id="remember" lay-skin="primary" title="记住我">
				</div>
			</div>
			<div class="layui-form-item" >
				<div style="text-align: center;">
					<button type="button" class="layui-btn" lay-submit lay-filter="login">登&nbsp;录</button>
				</div>
			</div>
		</form>
	</div>
	<script src="/layui/layui.js"></script>
	<script type="text/javascript">
        $(function  () {
            layui.use('form', function () {
                var form = layui.form;
                var remember = false;
                if($("#remember").is(":checked")){
                    var remember = true;
                }
                var json = {
                    email:$("#email").val(),
                    password:$("#password").val(),
                    remember:remember,
                    _token:$("#_token").val()
                };
                form.on('submit(login)', function(data){
                    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                    if(!reg.test($("#email").val()))
                    {
                        layer.msg("邮箱格式有误！请核对！",{icon: 5});
                        return false;
                    }
                    $.ajax({
                        url:'/admin/login',
                        data:data.field,
                        dataType:'json',
                        type:'post',
                        success:function (data) {
                            if(data.msg == 'success'){
                                location.href = data.referer;
							} else if(data.msg == 'fail'){
                                layer.msg('登录失败！该用户被禁用！',{icon: 5});
                            } else if(data.msg == 'error'){
                                layer.msg('登录失败！邮箱或密码错误！',{icon: 5});
                            }
                        }
                    });
                    return false;
                });
            })
		});
	</script>
</body>
</html>