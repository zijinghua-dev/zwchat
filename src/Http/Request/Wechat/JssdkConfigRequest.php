<?php
namespace Zijinghua\Zwechat\Http\Request\Wechat;

use Illuminate\Foundation\Http\FormRequest;

class JssdkConfigRequest extends FormRequest
{
    public function rules()
    {
        return [
            'js_apis' =>[
                'required'
            ],
            'app_id' => [
                'required'
            ],
            'url' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'js_apis.required' => '请传入您要调用的微信js sdk,多个sdk之间用,隔开',
            'app_id.required' => '请传入app_id',
            'url.required' => '请传入您调用微信js sdk所在页面的URL, url需要提前encode'
        ];
    }
}