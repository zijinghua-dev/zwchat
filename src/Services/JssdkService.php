<?php
namespace Zijinghua\Zwechat\Services;

use EasyWeChat\Factory;
use function GuzzleHttp\Psr7\str;

class JssdkService
{
    /**
     * 获取微信公众号调微信js sdk之前需要的配置
     * @param $appId
     * @param $jsApiList
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function getJssdkConfig($appId, array $jsApiList, string $url=null)
    {
        $config = \Zijinghua\Zwechat\WechatTrait::getConfigByAppId($appId);
        if (!is_array($config) || !isset($config['app_secret'])) {
            throw new \Overtrue\Socialite\InvalidArgumentException('请wechat.php中配置app_id、app_secret');
        }

        $config['response_type'] = 'array';
        $config['secret'] = $config['app_secret'];
        $app = Factory::officialAccount($config);
        if ($url) {
            $app->jssdk->setUrl(strstr($url, '#', true)?: $url);
        }

        return $app->jssdk->buildConfig($jsApiList, config('wechat.jssdk.debug'), false, false);
    }
}