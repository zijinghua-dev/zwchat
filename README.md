#当前包提供获取微信open id、unionid的方法。请按照一下步骤
(1)使用php artisan vendor:pulish --provider='Zijinghua\Zwechat\ServiceProvider'发布包\
(2)在config目录下的wechat.php的apps配置中添加你的app_id、app_secret\
(3) 实例化$snsService = new Zijinghua\Zwechat\Services\SnsService($appId, $code)。
调SnsService的getOpenId方法可获取openid。调用getUnionId可获取unionid,如果已经有openid，建议传入openid，
避免调两次微信接口 
