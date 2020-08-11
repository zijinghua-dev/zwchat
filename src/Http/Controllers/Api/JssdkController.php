<?php
namespace Zijinghua\Zwechat\Http\Controllers\Api;

use Zijinghua\Zwechat\Http\Request\Wechat\JssdkConfigRequest;
use Zijinghua\Zwechat\Services\JssdkService;

class JssdkController extends \Illuminate\Routing\Controller
{
    public function jssdkConfig(JssdkConfigRequest $request)
    {
        $config = JssdkService::getJssdkConfig(
            request('app_id'),
            explode(',', request('js_apis')),
            request('url')
        );

        return response()->json($config);
    }
}
