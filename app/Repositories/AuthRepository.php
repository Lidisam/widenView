<?php
/**
 * Created by PhpStorm.
 * User: 迪山
 * Date: 2016/4/30
 * Time: 19:22
 */

namespace App\Repositories;


class AuthRepository
{
    /**
     * @param $userId (验证用户自增id)
     * @return int
     */
    public function checkUserId($userId)
    {
        return (preg_match('/^\d{1,5}$/', $userId))?1:0;
    }

    /**
     * @param $mobile
     * @return int
     */
    public function checkMobile($mobile)
    {
        return (preg_match('/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/', $mobile))?1:0;
    }

    /**
     * @param $authCode
     * @return int
     */
    public function checkAuth($authCode)
    {
        return (preg_match('/^\d{6}$/', $authCode))?1:0;
    }

    /**
     * @desc 检验用户密码
     * @param $password
     * @return int
     */
        public function checkPwd($password)//以字母或数字开头，长度在6~18之间，只能包含字母、数字和下划线
    {
        return (preg_match('/^[a-zA-Z0-9]\w{5,17}$/', $password))?1:0;
    }
}