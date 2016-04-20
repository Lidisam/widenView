<?php

namespace App\Http\Requests\Admin\Tuser;

use App\Http\Requests\Admin\Request;

class TuserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'max:25|required',
            'password' => 'max:100',
        ];
    }

    public function messages()
    {
        return [
            'username.max' => '用户名最多25个字符',
            'username.required' => '用户名不能为空',
            'password.max' => '密码最多100字符'
        ];
    }
}
