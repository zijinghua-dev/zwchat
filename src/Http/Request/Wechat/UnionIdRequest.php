<?php
namespace Zijinghua\Zwechat\Http\Request\Wechat;

use \Illuminate\Foundation\Http\FormRequest;

class UnionIdRequest extends FormRequest
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
                'required_without:open_id'
            ],
            'open_id' => [
                'required_without:code'
            ],
        ];
    }

    public function messages()
    {
        return [
            'app_id.required' => '微信appid必填',
            'app_id.in' => '无效的微信appid',
            'code.required' => '微信授权code必填',
            'code.required_without' => 'code和open_id不能同时为空',
            'open_id.required_without' => 'code和open_id不能同时为空',
        ];
    }
}