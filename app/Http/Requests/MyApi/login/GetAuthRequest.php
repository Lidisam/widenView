<?php

namespace App\Http\Requests\MyApi\login;

use App\Http\Requests\Admin\Request;

class GetAuthRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.regex' => '该手机格式错误'
        ];
    }
}
