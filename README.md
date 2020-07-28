#当前包提供获取微信open id、unionid的方法。请按照以下步骤\
(1)使用php artisan vendor:pulish --provider='Zijinghua\Zwechat\ServiceProvider'发布包\
(2)在config目录下的wechat.php的apps配置中添加你的app_id、app_secret\
(3) 实例化$snsService = new Zijinghua\Zwechat\Services\SnsService($appId, $code)。
调SnsService的getOpenId方法可获取openid。调用getUnionId可获取unionid,如果已经有openid，建议传入openid，
避免调两次微信接口 

#目前提供如下API接口，在使用一下API接口时，依然要执行上述步骤(1)(2)\
(1) uri：api/zijinghua/wechat/open-id。请求方式GET。请求参数：app_id：应用的app id；code：微信授权code\
(2) uri：api/zijinghua/wechat/union-id。请求方式GET。
请求参数：
app_id：应用的app id；
code：微信授权code；
open_id：微信openid，code和open_id可以二选一
