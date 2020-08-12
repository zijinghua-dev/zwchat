<?php
return [
    //appid
    'apps' => json_decode(env('WECHAT_APPS'), true)? json_decode(env('WECHAT_APPS'), true):[],
    'api' => [
        'sns' => 'https://api.weixin.qq.com/sns'
    ],
    'jssdk' => [
        'debug' => env('WECHAT_JSSDK_DEBUG', false)
    ],
    'errors' => [
        40029 => 'invalid_oauth_code',
        40003 => 'invalid_open_id',
        41008 => 'miss_oauth_code'
    ]
];
