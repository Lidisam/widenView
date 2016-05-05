<?php
/**
 * @desc 获取验证码
 * @param mobile(手机) num (验证码数字) templateId(模板id) appid apiKey
 *
 * @return mixed
 */
    function sendCode($mobile, $num, $templateId, $appId, $apiKey) {
        $param = $num.",24小时";
        $url = "https://sms.zhiyan.net/sms/template_send.json";
        $json_arr = array(
            "mobile" => $mobile,
            "param" => $param,
            "templateId"=>$templateId,
            "appId"=>$appId,
            "apiKey"=>$apiKey,
            "extend" => "",
            "uid" => ""
        );
        $array =json_encode($json_arr);
        //调用接口
        //初始化curl
        $ch = curl_init();
        //参数设置
        $res= curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec ($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        return $result;
    }