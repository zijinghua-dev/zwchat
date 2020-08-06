<?php
namespace Zijinghua\Zwechat\Http\Controllers\Api;

use Overtrue\Socialite\AuthorizeFailedException;
use Zijinghua\Zwechat\Http\Request\Wechat\OpenIdRequest;
use Zijinghua\Zwechat\Http\Request\Wechat\UnionIdRequest;
use Zijinghua\Zwechat\Services\SnsService;

/**
 * Class SnsController
 * @package Zijinghua\Zwechat\Http\Controllers\Api
 */
class SnsController extends \Illuminate\Routing\Controller
{
    /**
     * 获取微信openid
     * @param OpenIdRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function openId(OpenIdRequest $request)
    {
        try {
            $service = new SnsService(request('app_id'));
            return response()->json(['open_id' => $service->getOpenId(request('code'))]);
        } catch (AuthorizeFailedException $e) {
            $body = $e->body;
            $response = [
                'message' => @$body['errmsg'],
                'errors' => [
                    'code' => config('wechat.errors.'.@$body['errcode']),
                    'message' => @$body['errmsg']
                ]
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * 获取微信用户信息，包含nickname、sex、language、city、province、country、headimgurl、unionid
     * @param UnionIdRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Zijinghua\Zwechat\Exception\InvalidAuthorizeScopeException
     */
    public function unionId(UnionIdRequest $request)
    {
        try {
            $service = new SnsService(request('app_id'));
            return response()->json($service->getUnionId(null, request('code')));
        } catch (AuthorizeFailedException $e) {
            $body = $e->body;
            $response = [
                'message' => @$body['errmsg'],
                'errors' => [
                    'code' => config('wechat.errors.'.@$body['errcode']),
                    'message' => @$body['errmsg']
                ]
            ];
            return response()->json($response, 500);
        }
    }


}
