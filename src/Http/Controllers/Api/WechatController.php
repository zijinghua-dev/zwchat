<?php
namespace Zijinghua\Zwechat\Http\Controllers\Api;

use Zijinghua\Zwechat\Http\Request\Wechat\OpenIdRequest;
use Zijinghua\Zwechat\Http\Request\Wechat\UnionIdRequest;
use Zijinghua\Zwechat\Services\SnsService;

class WechatController extends \Illuminate\Routing\Controller
{
    public function openId(OpenIdRequest $request)
    {
        $service = new SnsService(request('app_id'));
        return response()->json(['open_id' => $service->getOpenId(request('code'))]);
    }

    public function unionId(UnionIdRequest $request)
    {
        $service = new SnsService(request('app_id'));
        return response()->json(['union_id' => $service->getUnionId(request('open_id'), request('code'))]);
    }
}