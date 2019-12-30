@extends('admin/layouts/base')

@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th>标签名</th>
                <th>标签描述</th>
                <th>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="add()">
                        <i class="layui-icon">&#xe608;</i> 添加
                    </button>
                </th>
            </tr>
            </thead>
            <tbody id="td">
            @if(!empty($tags))
                @foreach($tags as $key => $value)
                        <tr>
                            <td>{{$value->name}}</td>
                            <td>{{$value->description}}</td>
                            <td>
                                <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="edit('{{$value->id}}')"><i class="layui-icon"></i></button>
                                <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="del('{{$value->id}}')"><i class="layui-icon"></i></button>
                            </td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        {{$tags->links()}}
    </div>
@endsection
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script>
    function add(){
        var url;
        var title;
        url = '/admin/tag/add';
        title = '添加标签';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','300px'],
                title: title,
                content: url
            });
        });
    }

    function edit(id) {
        var url;
        var title;
        url = '/admin/tag/edit?id='+id;
        title = '编辑标签';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','300px'],
                title: title,
                content: url
            });
        });
    }

    function del(id) {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定删除该标签？', {icon: 3, title:'提示'}, function(index) {
                $.getJSON('/admin/tag/del',{id:id , _token:'{{csrf_token()}}'} , function (res) {
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

</script>