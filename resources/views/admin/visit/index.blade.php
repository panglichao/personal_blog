@extends('admin/layouts/base')

@section('content')
    <div class="layui-form">
        <table class="layui-table" lay-skin="row" >
            <thead>
            <tr>
                <th>序号</th>
                <th>客户ip</th>
                <th>国家标识</th>
                <th>设备</th>
                <th>系统</th>
                <th>系统版本</th>
                <th>浏览器</th>
                <th>浏览器版本</th>
                <th>当日首访时间</th>
                <th>当日末访时间</th>
                <th>操作（加入/移出黑名单）</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($visits))
                <?php  $startNum = ($visits->currentPage() - 1) * $visits->perPage();?>
                @foreach($visits as $key => $value)
                        <tr>
                            <td>{{++$startNum}}</td>
                            <td>{{$value->ip}}</td>
                            <td>{{$value->country_code}}</td>
                            <td>{{$value->device}}</td>
                            <td>{{$value->platform}}</td>
                            <td>{{$value->platform_version}}</td>
                            <td>{{$value->browser}}</td>
                            <td>{{$value->browser_version}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>{{$value->updated_at}}</td>
                            <td class="black{{$value->id}}">
                                @if($value->is_black == 'no')
                                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="black('{{$value->ip}}','yes')">加入黑名单</button>
                                @else
                                    <button class="layui-btn layui-btn-primary layui-btn-sm" onclick="black('{{$value->ip}}','no')">移出黑名单</button>
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
    function black(ip,type){
        var msg;
        if(type == 'yes')
            msg = '确认将此IP加入黑名单？';
        else
            msg = '确认将此IP移出黑名单？';
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm(msg, {icon: 3, title:'提示', btn: ['是','否']}, function(index) {
                $.getJSON('/admin/visit/switch', {ip:ip, type:type, _token:'{{csrf_token()}}'}, function (res) {
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
</script>