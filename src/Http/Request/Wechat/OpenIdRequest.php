<?php
namespace Zijinghua\Zwechat\Http\Request\Wechat;

use \Illuminate\Foundation\Http\FormRequest;

class OpenIdRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_id' => [
                'required',
                'in:'.implode(',', array_column(config('wechat.apps'), 'app_id'))
            ],
            'code' => [
                'required'
            ],
        ];
    }

    public function messages()
    {
        return [
            'app_id.required' => '微信appid必填',
            'app_id.in' => '无效的微信appid',
            'code.required' => '微信授权code必填'
        ];
    }
}