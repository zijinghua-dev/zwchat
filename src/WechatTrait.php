<?php
namespace Zijinghua\Zwechat;

trait WechatTrait
{
    /**
     * @param $appId
     * @return array|mixed
     */
    public static function getConfigByAppId($appId)
    {
        foreach (config('wechat.apps') as $config) {
            if ($appId === @$config['app_id']) {
                return $config;
            }
        }

        return [];
    }
}