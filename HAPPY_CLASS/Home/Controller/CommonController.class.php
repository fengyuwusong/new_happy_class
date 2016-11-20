<?php
/**
 * Created by PhpStorm.
 * User: 风雨雾凇
 * Date: 2016/11/15
 * Time: 17:11
 */
namespace Home\Controller;
use Think\Controller;
//通用方法控制器
class CommonController extends Controller{
    /*
     * 获取班级名称接口
     */
    public function apiGetClassName(){
        $class_id=I('post.class_id');
        if($class_id==''){
            $res=array(
                'Status'=>1,
                'Mes'=>'参数未定义'
            );
        }else{
            $class=D('Class');
            $name=$class->getClassName($class_id);
            $res=array(
                'name'=>$name,
                'Status'=>200,
                'Mes'=>'获取成功！'
            );
        }
        $this->ajaxReturn($res);
    }
    //获取班级名称
    public function getClassName($class_id){
        $class=D('Class');
        $name=$class->getClassName($class_id);
        return $name['name'];
    }
    // 设置验证码
    public function set_verify()
    {
        ob_clean();
        $config = array(
            'fontSize' => 30,    // 验证码字体大小
            'length' => 4,     // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    // 校检验证码           code验证码
    // 正确true 错误false
    public function check_verify()
    {
        $code=I('post.code');
        if($code==''){
            $res=array(
                    'Status'=>1,
                    'Mes'=>'参数不能为空',
                );
            $this->ajaxReturn($res);
        }
        $verify = new \Think\Verify();
        if ($verify->check($code)) {
            $res=array(
                    'Status'=>200,
                    'Mes'=>'验证成功！',
                );
            $this->ajaxReturn($res);
        } else {
            $res=array(
                    'Status'=>0,
                    'Mes'=>'验证失败！',
                );
            $this->ajaxReturn($res);
        }
    }

    //生成验证码
    public function setGeet()
    {
        if ($_GET['type'] == 'pc') {
            $GtSdk = new \Org\Util\Geetestlib(C('CAPTCHA_ID'), C('PRIVATE_KEY'));
        } elseif ($_GET['type'] == 'mobile') {
            $GtSdk = new \Org\Util\Geetestlib(C('MOBILE_CAPTCHA_ID'), C('MOBILE_PRIVATE_KEY'));
        }
        session_start();
        $user_id = "test";
        $status = $GtSdk->pre_process($user_id);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $user_id;
        echo $GtSdk->get_response_str();
    }

    //验证
    public function checkGeet()
    {
        session_start();
        if ($_POST['type'] == 'pc') {
            $GtSdk = new \Org\Util\Geetestlib(C('CAPTCHA_ID'), C('PRIVATE_KEY'));
        } elseif ($_POST['type'] == 'mobile') {
            $GtSdk = new \Org\Util\Geetestlib(C('MOBILE_CAPTCHA_ID'), C('MOBILE_PRIVATE_KEY'));
        }

        $user_id = $_SESSION['user_id'];
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $user_id);
            if ($result) {
                echo '{"status":"success"}';
            } else {
                echo '{"status":"fail"}';
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
                echo '{"status":"success"}';
            } else {
                echo '{"status":"fail"}';
            }
        }
    }

}