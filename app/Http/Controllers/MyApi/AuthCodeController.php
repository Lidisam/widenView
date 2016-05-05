<?php

namespace App\Http\Controllers\MyApi;

use App\Http\Requests\MyApi\login\GetAuthRequest;
use App\Models\Video;
use App\Repositories\AuthRepository;
use App\Tuser;
use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthCodeController extends Controller
{
    /**
     * @desc 验证操作函数
    **/
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @param AuthRepository $auth
     */
    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @desc 获取验证码
     * @req 用户注册信息
     * @res 成功信息或错误代码
     * @param GetAuthRequest $request
     */
    public function index(GetAuthRequest $request) {
        $user = new Tuser();          //用户信息表
        $data = $request->only(['mobile']);
        if(preg_match('/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/', $data['mobile'])){
            //生成验证码并请求
            $num = "";
            for($i = 1; $i <= 6; $i++){
                $num .= rand(0,9);
            }
            //调用自定义的发送短信helper函数
            $result = sendCode($data['mobile'], $num, Config::get("authcode.templateId") ,  Config::get("authcode.appId"),  Config::get("authcode.apiKey"));
            if($result['result'] == 'SUCCESS'){  //成功的状态下
                $user->password = "1";        //再生成接口时给 1 默认值
                $user->authCode = $num;
                if ($user->save()) {
                    $arr = array(            //返回当前用户注册的验证码和用户id
                        'userId' => $user->id
                    );
                    echo json_encode($arr);         //发送验证码成功
                }else{
                    echo json_encode(array('returnType'=>'0'));        //数据库保存失败
                }
            }else{
                echo json_encode(array('returnType'=>'1'));   //短信发送失败
            }
        }else{
            echo json_encode(array('returnType'=>'3'));   //手机格式错误
        }
    }

    /**
     * @desc 注册接口
     * @param Request $request
     */
    public function register(Request $request){
        $user = new Tuser();
        $data = $request->only(['userId','mobile','authCode','password']);
        $userIdRes = $this->auth->checkUserId($data['userId']);//正确返回1,否则0
        $mobileRes = $this->auth->checkMobile($data['mobile']);
        $authCodeRes = $this->auth->checkAuth($data['authCode']);
        $pwdRes = $this->auth->checkPwd($data['password']);//以字母或数字开头，长度在6~18之间，只能包含字母、数字和下划线
        if($userIdRes&&$mobileRes&&$authCodeRes&&$pwdRes){ //验证均合法通过
            $authCode = $user->where('id', $data['userId'])->pluck('authCode');  //获取验证码
            if($authCode['0'] != $data['authCode']){
                echo json_encode(array('returnType'=>'1'));  //验证码错误
            }else{//进行注册操作
                $user = $user::find($data['userId']);
                $user->password = bcrypt($data['password']);
                $user->number = $data['mobile'];
                if($user->save()){
                    echo json_encode(true);  //注册成功
                }else{
                    echo json_encode(array('returnType'=>'2'));  //数据保存失败
                }
            }
        }else{
            echo json_encode(array('returnType'=>'0'));  //数据验证不通过
        }
    }

    /**
     * @desc 登录接口
     * @param Request $request
     * @return string
     */
    public function login(Request $request){
        $user = new Tuser();
        $data = $request->only(['mobile', 'password', 'type','openId']);//获取数据
        if($data['type'] == '0'){  //使用第三方登录
            echo "你选择了第三方登录";
            $user->password = $data['openId'];  //在第三方认证时
            $user->isOther = 1; //改为第三方认证
        }elseif($data['type'] == '1'){  //使用本站账号登录
            $pwdRes = $this->auth->checkPwd($data['password']);
            $mobileRes = $this->auth->checkMobile($data['mobile']);
            if($pwdRes&&$mobileRes){ //表单信息验证通过
                $pwd = $user->where("number",array($data['mobile']))->pluck('password');
                $uId = $user->where("number",array($data['mobile']))->pluck('id');
                if(Hash::check($data['password'], $pwd['0'])){  //匹配密码成功
                    //这里返回主页的前10条信息以及access_token码
                    $token = md5(md5($data['mobile'].$data['password'].md5(time())));
                    $login = Tuser::find($uId);  //获取对象
                    $expires_in = intval(strtotime($login->updated_at));  //token上次生成时间
                    if(($expires_in != '0') && (time() - $expires_in < 3600*4)){//过期时间为四小时   如果第一次使用为0肯定为空 会远远超过
                        // 如果没过时就直接返回上次token
                        $access_token = $login->accessToken;     //上次最新的token
                    }else{
                        $access_token = $token; //时间过期，返回最新的token
                    }
                    $login->accessToken = $access_token;
                    if(!$login->save()) {
                        echo json_encode(array('returnType'=>'2'));  //服务器生成token失败
                    }else{ //返回token和前二十条视频信息
                        $videos = new Video();
                        $video_info = $videos->limit(10)->orderBy('id', 'desc')->get()->toArray();
                        $arr = array(
                            'access_token' => $access_token,
                            'msg' => $video_info
                        );
                        //数据展示方式
//                        dd($arr['msg']['0']['name']);
//                        dd($arr['msg']['1']['name']);
                        echo json_encode($arr);  //返回成功，这里参数待定
                    }
                }else{
                    echo json_encode(array('returnType'=>'1'));  //密码匹配失败
                }
            }else{
                echo json_encode(array('returnType'=>'0'));  //表单信息验证不合法
            }
        }

    }
}
