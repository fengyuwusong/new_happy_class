<?php 
/**
 * 输出二次验证结果,本文件示例只是简单的输出 Yes or No
 */
// error_reporting(0);
require_once dirname(dirname(__FILE__)) . '/src/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/src/config.php';
session_start();
if($_POST['type'] == 'pc'){
    $GtSdk = new GeetestLib("CAPTCHA_ID", "08771a431d03e784400ba33f86a46300");
}elseif ($_POST['type'] == 'mobile') {
    $GtSdk = new GeetestLib("0381469592a53bcada9e7b6fda2b07d8", "08771a431d03e784400ba33f86a46300");
}

$user_id = $_SESSION['user_id'];
if ($_SESSION['gtserver'] == 1) {   //服务器正常
    $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $user_id);
    if ($result) {
        echo '{"status":"success"}';
    } else{
        echo '{"status":"fail"}';
    }
}else{  //服务器宕机,走failback模式
    if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
        echo '{"status":"success"}';
    }else{
        echo '{"status":"fail"}';
    }
}
?>
