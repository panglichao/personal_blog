@extends('admin/layouts/base')

@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th>友链名</th>
                <th>友链地址</th>
                <th>是否显示</th>
                <th>Logo图</th>
                <th>友链描述</th>
                <th>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="add()">
                        <i class="layui-icon">&#xe608;</i> 添加
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($links))
                @foreach($links as $key => $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->url}}</td>
                            <td>
                                @if($value->is_show =='yes')
                                    是
                                @else
                                    否
                                @endif
                            </td>
                            <td>
                                @if($value->thumb)
                                    <?php
                                    $thumb = substr($value->thumb, 0, -1);
                                    $thumbs = explode(',',$thumb);
                                    echo count($thumbs).'张';
                                    ?>
                                @else
                                    无图
                                @endif
                            </td>
                            <td>{{$value->description}}</td>
                            <td>
                                <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="edit('{{$value->id}}')"><i class="layui-icon"></i></button>
                                <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="del('{{$value->id}}')"><i class="layui-icon"></i></button>
                                @if($value->is_show == 'yes')
                                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="checkStatus('{{$value->id}}',0)"><i class="layui-icon">&#xe643;</i></button>
                                @else
                                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="checkStatus('{{$value->id}}',1)"><i class="layui-icon">&#xe63f;</i></button>
                                @endif

                            </td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
<script>
    function add(){
        var url;
        var title;
        url = '/admin/link/add';
        title = '添加友链';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','450px'],
                title: title,
                content: url
            });
        });
    }

    function edit(id) {
        var url;
        var title;
        url = '/admin/link/edit?id='+id;
        title = '编辑友链';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','450px'],
                title: title,
                content: url
            });
        });
    }

    function del(id) {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定删除该友链？', {icon: 3, title:'提示'}, function(index) {
                $.getJSON('/admin/link/del',{id:id , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result){
                        layer.msg('删除成功！',{icon: 6},function (index) {
                            location.reload();
                        });
                    } else {
                        layer.msg('删除失败！请稍后再试！',{icon: 5});
                    }
                })
                layer.close(index);
            });
        });
    }

    function checkStatus(id,type){
        var msg;
        if(type)
            msg = '是否显示该友链？';
        else
            msg = '是否隐藏该友链？';
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm(msg, {icon: 3, title:'提示', btn: ['是','否']}, function(index) {
                $.post('/admin/link/switch',{id:id , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result)
                        location.reload();
                    else
                        layer.msg('切换显示失败！请稍后再试！',{icon: 5});
                });
                layer.close(index);
            });
        });
    }

</script>