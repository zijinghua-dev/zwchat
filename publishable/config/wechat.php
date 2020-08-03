<?php
return [
    //appid
    'apps' => [
        [
            'app_id' => '',
            'redirect_uri' => '',
            'app_secret' => ''
        ]
    ],
    'api' => [
        'sns' => 'https://api.weixin.qq.com/sns'
    ],
    'jssdk' => [
        'debug' => env('WECHAT_JSSDK_DEBUG', false)
    ]
];