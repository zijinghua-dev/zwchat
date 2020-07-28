<?php
namespace Zijinghua\Zwechat\Services;

use Overtrue\Socialite\AuthorizeFailedException;
use \Zijinghua\Zwechat\AccessToken\Cache;
use Zijinghua\Zwechat\Exception\InvalidAuthorizeScopeException;

/**
 * 获取微信open id、unionid
 * Class SnsService
 */
class SnsService extends \Overtrue\Socialite\Providers\WeChatProvider
{
    use Cache;

    protected $code;

    public function __construct($appId, $code)
    {
        $config = \Zijinghua\Zwechat\WechatTrait::getConfigByAppId($appId);
        if (!isset($config['app_secret'])) {
            throw new \Overtrue\Socialite\InvalidArgumentException('请配置app_id:'.$appId.'对应的app_secret');
        }
        parent::__construct(request(), $appId, $config['app_secret']);
        $this->setAppId($appId);
        $this->code = $code;
    }

    /**
     * @param null $code
     * @return \Overtrue\Socialite\AccessToken|\Overtrue\Socialite\AccessTokenInterface
     * @throws AuthorizeFailedException
     */
    public function getAccessToken($code=null)
    {
        $accessToken = parent::getAccessToken($this->code);
        $this->put($accessToken->toArray());
        return $accessToken;
    }

    /**
     * 获取微信open id
     * @return string|null
     */
    public function getOpenId()
    {
        $accessToken = $this->getAccessToken($this->code);
        return $accessToken->openid;
    }

    protected function getCode()
    {
        return $this->code;
    }

    protected function invalidAuthorizeScopeException($scope)
    {
        if ($scope!=='snsapi_userinfo') {
            throw new InvalidAuthorizeScopeException(
                '当前授权作用域为'.$scope.'，无法获取unionid'
            );
        }
    }

    /**
     * @param string|null $openId
     * @return string
     * @throws InvalidAuthorizeScopeException
     */
    public function getUnionId($openId=null)
    {
        $cache = $this->get()?:[];
        $token = null;
        if (!empty($cache) && $openId) {
            $openId && $cache['openid'] = $openId;
            $token = new \Overtrue\Socialite\AccessToken($cache);
        }

        $user = $this->user($token);
        $this->put($user->getOriginal());
        isset($user->getOriginal()['scope']) && $this->invalidAuthorizeScopeException($user->getOriginal()['scope']);
        return @$user->getOriginal()['unionid'];
    }
}