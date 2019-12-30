@extends('admin/layouts/base')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <blockquote class="layui-elem-quote">
        基本资料
    </blockquote>
    <div class="layui-form">
        @foreach($userOptions as $k => $v)
            @if($k != 'gravatar')
                <div class="layui-form-item">
                    <label class="layui-form-label">{{$v['title']}}</label>
                    <div class="layui-input-block">
                        <input type="text" name="{{$k}}" value="{{$v['value']}}" class="layui-input" disabled>
                    </div>
                </div>
            @else
                <div class="layui-form-item">
                    <label class="layui-form-label">{{$v['title']}}</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$v['value']}}" class="layui-input" disabled>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">预览</label>
                    <div class="layui-input-block">
                        <img src="{{$v['value']}}" alt="{{$k}}" style="width: 72px;height: auto">
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection