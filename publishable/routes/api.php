<?php

Route::middleware(['api'])->prefix('api/zijinghua/wechat')->group(function () {
    Route::get('open-id', 'Zijinghua\Zwechat\Http\Controllers\Api\WechatController@openId');
    Route::get('union-id', 'Zijinghua\Zwechat\Http\Controllers\Api\WechatController@unionId');
});