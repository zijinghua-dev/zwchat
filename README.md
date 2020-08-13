#初始化工作

>(1) 使用php artisan vendor:pulish --provider='Zijinghua\Zwechat\ServiceProvider'发布包

>(2) 根据实际需要，在.env中增加WECHAT_APPS配置，格式如下:

 > - WECHAT_APPS='[{"app_id":"微信app id","app_secret":"微信app secret"}]'
 
>(3) Zijinghua\Zwechat\Jobs\RefreshAccessToken可用于定时检查、刷新网页授权access_token

>(4) 异常code
 > - invalid_oauth_code:无效的code
 > - invalid_open_id:无效的openid
 > - miss_oauth_code:缺失授权code

#目前提供如下API接口，在使用以下API接口时，依然要执行上述步骤(1)(2)
(1) 接口：获取微信openid，uri：api/zijinghua/wechat/open-id。
>- 请求方式：GET。
>- 请求参数：
>- app_id：应用的app id；
>- code：微信授权code
>- 正常返回：{"openid":"openid"}
>- 异常返回：{"message":"message", "errors":{"code":"异常code","message":"message"}}

(2) 接口：获取微信unionid，uri：api/zijinghua/wechat/union-id。
>- 请求方式：GET。
>- 请求参数：
>- app_id：应用的app id；
>- code：微信授权code；
>- open_id：微信openid，code和open_id可以二选一
>- 正常返回：
```json
{
     "openid": "openid",
     "nickname": "昵称",
     "sex": 1,
     "language": "zh_CN",
     "city": "city",
     "province": "province",
     "country": "country",
     "headimgurl": "微信头像",
     "privilege": [],
     "unionid": "unionid"
 }
```
>- 异常返回：{"message":"message", "errors":{"code":"异常code","message":"message"}}

(3) 接口：获取微信jssdk配置，uri：api/zijinghua/wechat/jssdk-config。
>- 请求方式：GET。
>- 请求参数：
>- >- app_id：应用的app id；
>- >- url：调用微信jssdk所在页面对应的URL
>- 正常返回：
```json
{
    "debug": false,
    "beta": false,
    "jsApiList": [],
    "appId": "appId",
    "nonceStr": "eEoJwxRBFi",
    "timestamp": 1597213070,
    "url": "url",
    "signature": "e094e67b7b37484f1507ab342d969dd1dedce04c"
}
```
