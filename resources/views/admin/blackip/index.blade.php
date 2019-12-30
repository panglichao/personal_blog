@extends('admin/layouts/base')
<script src="/layui/layui.js"></script>
<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th>序号</th>
                <th>黑名单ip</th>
                <th>加入时间</th>
                <th>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="add()">
                        <i class="layui-icon">&#xe608;</i> 添加
                    </button>
                    <button style="margin-left: 0px;" class="layui-btn layui-btn-primary layui-btn-sm" id="uploadExcel">
                        <i class="layui-icon">&#xe67c;</i>导入excel
                    </button>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="downloadExample()">
                        <i class="layui-icon">&#xe601;</i>下载excel模版
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($blackIps))
                <?php  $startNum = ($blackIps->currentPage() - 1) * $blackIps->perPage();?>
                @foreach($blackIps as $key => $value)
                        <tr>
                            <td>{{++$startNum}}</td>
                            <td>{{$value->ip}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>
                                <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="del('{{$value->id}}')">移出黑名单</button>
                            </td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
<script>
    function del(id){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定将此IP移出黑名单？', {icon: 3, title:'提示'}, function(index) {
                $.getJSON('/admin/blackip/del', {id:id, _token:'{{csrf_token()}}'}, function (res) {
                    if(res.result){
                        layer.msg('操作成功！',{icon: 6},function (index) {
                            location.reload();
                        });
                    } else {
                        layer.msg('操作成功！请稍后再试！',{icon: 5});
                    }
                });
                layer.close(index);
            });
        });
    }

    function add(){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.prompt({title: '请输入要限制的IP', formType: 2}, function(ip, index){
                if(ip.trim().length == 0){
                    layer.msg('请输入正确的IP！',{icon: 5});
                    return false;
                }
                $.getJSON('/admin/blackip/add', {ip:ip, _token:'{{csrf_token()}}'}, function (res) {
                    if(res.msg == 'success'){
                        layer.msg('操作成功！',{icon: 6},function (index) {
                            location.reload();
                        });
                    } else {
                        layer.msg(res.msg,{icon: 5});
                    }
                });
                layer.close(index);
            });
        });
    }

    $(function () {
        layui.use('upload', function(){
            var upload = layui.upload;
            var uploadInst = upload.render({
                elem: '#uploadExcel' //绑定元素
                ,url: '/admin/blackip/import' //上传接口
                ,method: 'POST'
                , type: "file"
                , accept: 'file'
                ,exts: 'xls|excel|xlsx|crv'
                ,headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                ,done: function(res){//上传完毕回调
                    if(res.status == 'ok'){
                        layer.msg(res.msg,{icon: 6},function (index) {
                            location.reload();
                        });
                    }
                }
                ,error: function(){//请求异常回调
                    layer.msg('网络异常，请稍后重试！');
                }
            });
        });
    });

    function downloadExample() {
        location.href = '/blackip.xlsx';
    }

</script>