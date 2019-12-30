@extends('admin/layouts/base')

@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th style="width: 128px">
                    <a style="cursor: pointer;" onclick="choseAll()">全选/取消</a>
                    <a style="cursor: pointer;" onclick="revserAll()">反选</a>
                </th>
                <th>标题</th>
                <th>栏目</th>
                <th>小编</th>
                <th>标签</th>
                <th>点击量</th>
                <th>显示</th>
                <th>banner图</th>
                <th>关键词</th>
                <th>介绍</th>
                <th>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="add()">
                        <i class="layui-icon">&#xe608;</i> 添加
                    </button>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="batchDel()">
                        <i class="layui-icon">&#x1006;</i> 批量删除
                    </button>
                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="batchSwitch()">
                        批量<i class="layui-icon">&#xe643;</i>显示<i class="layui-icon">&#xe63f;</i>隐藏
                    </button>
                </th>
            </tr>
            </thead>
            <tbody id="td">
            @if(!empty($articles))
                @foreach($articles as $key => $value)
                        <tr>
                            <td>
                                <input type="checkbox" name="id" value="{{$value->id}}" lay-skin="primary" title="选中" style="display: block;width: 15px;height: 15px">
                            </td>
                            <td>{{$value->title}}</td>
                            <td>{{$value->getCategory->name}}</td>
                            <td>{{$value->getUser->username}}</td>
                            <td>
                                @if(count($value->getTag)>0)
                                    @foreach($value->getTag as $k => $v)
                                        @if($loop->last)
                                            {{$v['name']}}
                                        @else
                                            {{$v['name']}}，
                                        @endif
                                    @endforeach
                                @else
                                    无标签
                                @endif
                            </td>
                            <td>{{$value->click}}</td>
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
                            <td>{{$value->keywords}}</td>
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
        {{$articles->links()}}
    </div>
@endsection
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script>
    function add(){
        var url;
        var title;
        url = '/admin/article/add';
        title = '添加文章';

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
        url = '/admin/article/edit?id='+id;
        title = '编辑文章';

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
            layer.confirm('确定删除该文章？', {icon: 3, title:'提示'}, function(index) {
                $.getJSON('/admin/article/del',{id:id , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result){
                        layer.msg('删除成功！',{icon: 6},function (index) {
                            location.reload();
                        });
                    } else {
                        layer.msg('删除失败！请稍后再试！',{icon: 5});
                    }
                });
                layer.close(index);
            });
        });
    }

    function checkStatus(id,type){
        var msg;
        if(type)
            msg = '是否显示该文章？';
        else
            msg = '是否隐藏该文章？';
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm(msg, {icon: 3, title:'提示', btn: ['是','否']}, function(index) {
                $.post('/admin/article/switch',{id:id , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result)
                        location.reload();
                    else
                        layer.msg('切换显示失败！请稍后再试！',{icon: 5});
                });
                layer.close(index);
            });
        });
    }

    //全选/取消
    function choseAll(){
        if($("#td :checkbox").is(':checked')){
            $('#td :checkbox').prop('checked',false);
        }else{
            $("#td :checkbox").prop('checked',true);
        }
    }
    //反选
    function revserAll(){
        $('#td :checkbox').each(function (){
            var val = $(this).prop('checked')?false:true;
            $(this).prop('checked',val);
        })
    }

    //批量删除
    function batchDel() {
        var ids = new Array();
        $("input[name='id']:checkbox").each(function(){
            if($(this).attr("checked")){
                ids.push($(this).val());
            }
        });
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定删除选中的文章？', {icon: 3, title:'提示'}, function(index) {
                if(ids.length==0) {
                    layer.alert('没有任何选择数据！请选择后再试！',{icon: 5});
                    return false;
                }
                $.post('/admin/article/batchDel',{ids:ids , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result)
                        location.reload();
                    else
                        layer.msg('批量删除失败！请稍后再试！',{icon: 5});
                });
                layer.close(index);
            });
        });
    }

    //批量切换显示状态
    function batchSwitch() {
        var ids = new Array();
        $("input[name='id']:checkbox").each(function () {
            if ($(this).attr("checked")) {
                ids.push($(this).val());
            }
        });
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('确定切换选中的文章的显示状态？', {icon: 3, title:'提示'}, function(index) {
                if(ids.length==0) {
                    layer.alert('没有任何选择数据！请选择后再试！',{icon: 5});
                    return false;
                }
                $.post('/admin/article/batchSwitch',{ids:ids , _token:'{{csrf_token()}}'} , function (res) {
                    if(res.result)
                        location.reload();
                    else
                        layer.msg('批量切换显示状态失败！请稍后再试！',{icon: 5});
                });
                layer.close(index);
            });
        });
    }

</script>