<?php

Route::middleware(['api'])->prefix('api/zijinghua/wechat')->group(function () {
    Route::get('open-id', 'Zijinghua\Zwechat\Http\Controllers\Api\SnsController@openId');
    Route::get('union-id', 'Zijinghua\Zwechat\Http\Controllers\Api\SnsController@unionId');
    Route::get('jssdk-config', 'Zijinghua\Zwechat\Http\Controllers\Api\JssdkController@jssdkConfig');
});