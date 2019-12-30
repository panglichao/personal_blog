@extends('admin/layouts/base')

@section('content')
    <blockquote class="layui-elem-quote">
        欢迎使用laravel_blog管理系统。
    </blockquote>
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">栏目数</div>
                <div class="layui-card-body">
                    12
                </div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">文章数</div>
                <div class="layui-card-body">
                    28
                </div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">评论数</div>
                <div class="layui-card-body">
                    72
                </div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">访客数</div>
                <div class="layui-card-body">
                    198
                </div>
            </div>
        </div>
    </div>
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li class="layui-this">标题一</li>
            <li>标题二</li>
            <li>标题三</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">内容1</div>
            <div class="layui-tab-item">内容2</div>
            <div class="layui-tab-item">内容3</div>
        </div>
    </div>
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header" style="background-color: #f2f2f2;">系统信息</div>
                <div class="layui-card-body">
                    服务器：linux+nginx+mysql+php<br>
                    PHP版本：php7.1<br>
                    MYSQL版本：5.63<br>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header" style="background-color: #f2f2f2;">登录信息</div>
                <div class="layui-card-body">
                    登录者：plc<br>
                    登录IP：192.168.1.39<br>
                    最后时间：2019-4-18 20:08:30<br>
                </div>
            </div>
        </div>
    </div>
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>昵称</th>
            <th>加入时间</th>
            <th>签名</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        <tr>
            <td>许闲心</td>
            <td>2016-11-28</td>
            <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
        </tr>
        <tr>
            <td>贤心</td>
            <td>2016-11-29</td>
            <td>人生就像是一场修行</td>
        </tr>
        </tbody>
    </table>
@endsection