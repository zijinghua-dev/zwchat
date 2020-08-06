<?php
namespace Zijinghua\Zwechat\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Zijinghua\Zwechat\AccessToken\AuthorizeCache;

class RefreshAccessToken
{
    use Dispatchable, InteractsWithQueue, SerializesModels, AuthorizeCache;

    public function handle()
    {
        foreach (config('wechat.apps') as $app) {
            if (isset($app['app_id'])) {
                $this->setAppId($app['app_id'])->get();
            }
        }
    }
}
