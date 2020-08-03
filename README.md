#初始化工作\
(1)使用php artisan vendor:pulish --provider='Zijinghua\Zwechat\ServiceProvider'发布包\
(2)根据实际需要，在config目录下的wechat.php的apps配置中添加你的app_id、app_secret\

#目前提供如下API接口，在使用以下API接口时，依然要执行上述步骤(1)(2)\
(1) 接口：获取微信openid，uri：api/zijinghua/wechat/open-id。\
请求方式：GET。\
请求参数：\
app_id：应用的app id；\
code：微信授权code\
(2) 接口：获取微信unionid，uri：api/zijinghua/wechat/union-id。\
请求方式：GET。\
请求参数：\
app_id：应用的app id；\
code：微信授权code；\
open_id：微信openid，code和open_id可以二选一\
(3) 接口：获取微信jssdk配置，uri：api/zijinghua/wechat/jssdk-config。\
请求方式：GET。\
请求参数：\
app_id：应用的app id；\
url：调用微信jssdk所在页面对应的URL；\
js_apis：需要调用的微信jssdk，多个sdk之间用逗号隔开
