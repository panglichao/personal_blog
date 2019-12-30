<?php

//控制各模块是否开启

return [
    'left' => [
        'category'   => [
            'status' => true,
            'title'  => '栏目管理',
            'url'    => '/category',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '栏目列表',
                    'name'   => 'list',
                    'url'    => '/admin/category/index',
                ]
            ]
        ],
        'article'    => [
            'status' => true,
            'title'  => '文章管理',
            'url'    => '/article',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '文章列表',
                    'name'   => 'list',
                    'url'    => '/admin/article/index',
                ]
            ]
        ],
        'comment'    => [
            'status' => true,
            'title'  => '评论管理',
            'url'    => '/comment',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '评论回复',
                    'name'   => 'list',
                    'url'    => '/admin/comment/index',
                ],
            ]
        ],
        'message'    => [
            'status' => true,
            'title'  => '留言管理',
            'url'    => '/comment',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '留言回复',
                    'name'   => 'list',
                    'url'    => '/admin/message/index',
                ],
            ]
        ],
        'tag'     => [
            'status' => true,
            'title'  => '标签管理',
            'url'    => '/tag',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '标签列表',
                    'name'   => 'list',
                    'url'    => '/admin/tag/index',
                ]
            ]
        ],
        'link' => [
            'status' => true,
            'title'  => '友链管理',
            'url'    => '/link',
            'options'=> [
                'list'   => [
                    'status' => true,
                    'title'  => '友链列表',
                    'name'   => 'list',
                    'url'    => '/admin/link/index',
                ]
            ]
        ],
        'config' => [
            'status' => true,
            'title'  => '设置中心',
            'url'    => '/config',
            'options'=> [
                'user'  => [
                    'status' => true,
                    'title'  => '基本资料',
                    'url'    => '/admin/user/index',
                ],
                'password'   => [
                    'status' => true,
                    'title'  => '密码设置',
                    'name'   => 'password',
                    'url'    => '/admin/user/password',
                ],
                'config'   => [
                    'status' => true,
                    'title'  => '站点配置',
                    'name'   => 'config',
                    'url'    => '/admin/config/index',
                ],
                'blackip'   => [
                    'status' => true,
                    'title'  => 'IP黑名单',
                    'name'   => 'config',
                    'url'    => '/admin/blackip/index',
                ]
            ]
        ],
        'count' => [
            'status' => true,
            'title'  => '数据统计',
            'url'    => '/count',
            'options'=> [
                'uv'   => [
                    'status' => true,
                    'title'  => '访客记录',
                    'name'   => 'log',
                    'url'    => '/admin/visit/index',
                ],
            ]
        ]
    ],
    'top_left' => [
        'home'  => [
            'status' => true,
            'title'  => '主页',
            'url'    => '/admin',
        ],
        'cache'  => [
            'status' => true,
            'title'  => '更新缓存',
            'url'    => '',
        ],
        'help'  => [
            'status' => true,
            'title'  => '帮助中心',
            'url'    => '',
        ],
        'other' => [
            'status' => true,
            'title'  => '其他系统',
            'url'    => '/other',
            'options'=> [
                'email'   => [
                    'status' => true,
                    'title'  => '邮件系统',
                    'name'   => 'email',
                    'url'    => '/admin/email/index',
                ],
                'notice'   => [
                    'status' => true,
                    'title'  => '消息系统',
                    'name'   => 'notice',
                    'url'    => '/admin/notice/index',
                ]
            ]
        ]
    ],
    'top_right' => [
        'user'  => [
            'status' => true,
            'title'  => '基本资料',
            'url'    => '/admin/user/index',
        ],
        'password'  => [
            'status' => true,
            'title'  => '密码设置',
            'url'    => '/admin/user/password',
        ]
    ]

];