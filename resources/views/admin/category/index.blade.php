@extends('admin/layouts/base')

@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th>排序</th>
                <th>栏目名</th>
                <th>类型</th>
                <th>显示</th>
                <th>banner图</th>
                <th>关键词</th>
                <th>介绍</th>
                <th>内容</th>
                <th>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="add()">
                        <i class="layui-icon">&#xe608;</i> 添加
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $key => $value)
                        <tr>
                            <td>
                                <input type="text" name="sort_id" id="{{$value->id}}" value="{{$value->sort_id}}" autocomplete="off"
                                       class="layui-btn layui-btn-primary layui-btn-sm" style="width:41px;cursor:text"
                                       oninput="if(value>99)value=99;if(value.length>2)value=value.slice(0,2);if(value<0)value=0"
                                       onfocus="submitFocus('{{$value->sort_id}}')" onblur="submitBlur('{{$value->id}}')">
                            </td>
                            <td>
                                @if($value->parent_id != 0)
                                    ├{{str_repeat('─',$value['level']*3).$value->name}}
                                @else
                                    {{$value->name}}
                                @endif
                            </td>
                            <td>
                                @if($value->type =='page')
                                    封面
                                @else
                                    列表
                                @endif
                            </td>
                            <td>
                                @if($value->is_show =='yes')
                                    是
                                @else
                                    否
                                @endif
                            </td>
                            <td>
                                @if($value->thumb)
                                    <img style="cursor: pointer;" title="点击查看" width="100%" height="50px" src="http://personal_blog.com/{{$value->thumb}}" onclick="showimg(this)"/>
                                @else
                                    无图
                                @endif
                            </td>
                            <td>{{$value->keywords}}</td>
                            <td>{{$value->description}}</td>
                            <td>{{$value->content}}</td>
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
        url = '/admin/category/add';
        title = '添加栏目';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','800px'],
                title: title,
                content: url
            });
        });
    }

    function edit(id) {
        var url;
        var title;
        url = '/admin/category/edit?id='+id;
        title = '编辑栏目';

        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type: 2,
                area: ['800px','800px'],
                title: title,
                content: url
            });
        });
    }

    function del(id) {
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定删除该栏目及其所有子栏目？', {icon: 3, title:'提示'}, function(index) {
                $.getJSON('/admin/category/del',{id:id , _token:'{{csrf_token()}}'} , function (res) {
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

    //光标移入事件
    function submitFocus(sort_id){
        //不使用var 定义全局变量
        old_sort_id = sort_id;
    }

    //光标移出事件
    function submitBlur(id){
        var new_sort_id = $('#'+id).val();
        if(new_sort_id == old_sort_id || new_sort_id ==''){
            return false;
        }else{
            $.post( '/admin/category/sort', {sort_id : new_sort_id, id:id, _token : '{{csrf_token()}}'},function(res){
                if(res.result){
                    //location.reload();
                    //改手动刷新
                }else{
                    layer.msg(res.msg,{icon: 5});
                }
            },'json');
        }
    }

    function checkStatus(id,type){
        var msg;
        if(type)
            msg = '是否显示该栏目？';
        else
            msg = '是否隐藏该栏目？';
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm(msg, {icon: 3, title:'提示', btn: ['是','否']}, function(index) {
                $.post('/admin/category/switch',{id:id , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result)
                        location.reload();
                    else
                        layer.msg('切换显示失败！请稍后再试！',{icon: 5});
                });
                layer.close(index);
            });
        });
    }

    function showimg(that) {
        layui.use('layer', function(){
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                area: ['50%','50%'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: '<img style="display: inline-block; width: 100%; height: 100%;" src="'+that.src+'">'
            });
        });
    }

</script>