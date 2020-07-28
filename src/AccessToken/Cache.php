<?php
namespace Zijinghua\Zwechat\AccessToken;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Overtrue\Socialite\AccessToken;
use Overtrue\Socialite\AccessTokenInterface;
use \Illuminate\Support\Facades\Cache as LaravelCache;

trait Cache
{
    protected $appId = null;
    protected $prefix = 'wechat.access_token.';
    protected $baseUrl = 'https://api.weixin.qq.com/sns';
    /**
     * @param null $appId
     */
    public function setAppId($appId): self
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * 判断access_token是否过期
     * @return bool
     */
    protected function isExpired()
    {
        if (!LaravelCache::has($this->prefix.$this->appId)){
            return true;
        }

        $token = json_decode(LaravelCache::get($this->prefix.$this->appId), true);
        if (!isset($token['expired_at'])) {
            return false;
        }

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $token['expired_at']);
        return !$carbon->gte(Carbon::now());
    }

    protected function has()
    {
        return LaravelCache::has($this->prefix.$this->appId) && !$this->isExpired();
    }

    public function put(array $token)
    {
        if (isset($token['expires_in'])) {
            $token['expired_at'] = Carbon::now()->addSeconds($token['expires_in'])->format('Y-m-d H:i:s');
        }

        return LaravelCache::put($this->prefix.$this->appId, json_encode($token));
    }

    protected function getRefreshToken()
    {
        $token = json_decode(LaravelCache::get($this->prefix.$this->appId), true);
        return @$token['refresh_token'];
    }

    /**
     * 调微信接口刷新access token
     * @return array
     */
    protected function refreshAccessToken()
    {
        $response = (new Client())->get(config('wechat.api.sns').'/oauth2/refresh_token', [
            'query' => array_filter([
                'refresh_token' => $this->getRefreshToken(),
                'grant_type' => 'refresh_token',
                'appid' => $this->appId,
            ]),
        ]);

        $response = $response->getBody();
        LaravelCache::put($this->prefix.$this->appId, $response);
        return json_decode($response, true);
    }

    /**
     * @return array
     */
    public function get()
    {
        if ($this->isExpired()) {
            $this->refreshAccessToken();
        }

        return json_decode(LaravelCache::get($this->prefix.$this->appId), true);
    }
}