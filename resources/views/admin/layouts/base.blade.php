<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>@yield('title', 'Laravel_Blog')管理系统</title>
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">{{ config('app.name', 'Laravel_Blog') }}管理系统</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      @foreach($menu['top_left'] as $key => $value)
        @if($value['status'])
          @if(array_key_exists("options",$value))
            <li class="layui-nav-item">
              <a href="javascript:;">{{$value['title']}}</a>
              <dl class="layui-nav-child">
                @foreach($value['options'] as $k => $v)
                  @if($v['status'])
                    <dd><a href="{{$v['url']}}">{{$v['title']}}</a></dd>
                  @endif
                @endforeach
              </dl>
            </li>
          @else
            <li class="layui-nav-item"><a href="{{$value['url']}}">{{$value['title']}}</a></li>
          @endif
        @endif
      @endforeach
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          {{ Auth::user()->username ? Auth::user()->username : Auth::user()->email}}
        </a>
        <dl class="layui-nav-child">
          @foreach($menu['top_right'] as $k => $v)
            @if($v['status'])
              <dd><a href="{{$v['url']}}">{{$v['title']}}</a></dd>
            @endif
          @endforeach
        </dl>
      </li>
      <li class="layui-nav-item"><a href="{{ url('/admin/logout') }}">退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black" lay-shrink="all">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        @foreach($menu['left'] as $key => $value)
          @if($value['status'])
            <li class="layui-nav-item layui-nav-item">
              <a class="" href="javascript:;">{{$value['title']}}</a>
              <dl class="layui-nav-child">
                @foreach($value['options'] as $k => $v)
                  @if($v['status'])
                    <dd><a class="link" href="{{$v['url']}}">{{$v['title']}}</a></dd>
                  @endif
                @endforeach
              </dl>
            </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        @yield('content')
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    本系统基于 Larvael 5.5 开发。若需二开，请参考 laravel 文档。
  </div>
</div>
<script src="/layui/layui.js"></script>
<script>
//布局加载element模块，否则菜单无法操作
layui.use('element', function(){
  var element = layui.element;

});

//菜单选中
$('.link').each(function () {
    var url = $(this).attr('href');
    var href = window.location.toString();
    if (href.indexOf(url) >= 0) {
        $(this).parent('dd').addClass('layui-this');
        $(this).parent('dd').parent('dl').parent('li').addClass('layui-nav-itemed');
    }
});
</script>
</body>
</html>