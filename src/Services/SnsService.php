<?php
namespace Zijinghua\Zwechat\Services;

use Overtrue\Socialite\AuthorizeFailedException;
use Overtrue\Socialite\InvalidArgumentException;
use \Zijinghua\Zwechat\AccessToken\AuthorizeCache;
use Zijinghua\Zwechat\Exception\InvalidAuthorizeScopeException;

/**
 * 获取微信open id、unionid
 * Class SnsService
 */
class SnsService extends \Overtrue\Socialite\Providers\WeChatProvider
{
    use AuthorizeCache;

    protected $code;

    public function __construct($appId)
    {
        $config = \Zijinghua\Zwechat\WechatTrait::getConfigByAppId($appId);
        if (!isset($config['app_secret'])) {
            throw new \Overtrue\Socialite\InvalidArgumentException('请wechat.php中配置app_id:'.$appId.'对应的app_secret');
        }
        parent::__construct(request(), $appId, $config['app_secret']);
        $this->setAppId($appId);
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
     * @return string
     */
    public function getOpenId($code)
    {
        $this->code = $code;
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
     * @param null $openId
     * @param null $code
     * @return array
     * @throws InvalidAuthorizeScopeException
     */
    public function getUnionId($openId=null, $code=null)
    {
        if (!$openId && !$code) {
            throw new InvalidArgumentException('参数openId和code不能同时为空');
        }
        $this->code = $code;
        $cache = $this->get()?:[];
        $token = null;
        if (!empty($cache) && $openId) {
            $openId && $cache['openid'] = $openId;
            $token = new \Overtrue\Socialite\AccessToken($cache);
        }

        $user = $this->user($token);
        $this->put($user->getOriginal());
        isset($user->getOriginal()['scope']) && $this->invalidAuthorizeScopeException($user->getOriginal()['scope']);
        return $user->getOriginal();
    }
}