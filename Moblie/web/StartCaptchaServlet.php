<?php 
/**
 * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
 * @author Tanxu
 */
//error_reporting(0);
require_once dirname(dirname(__FILE__)) . '/src/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/src/config.php';
if($_GET['type'] == 'pc'){
	$GtSdk = new GeetestLib("0381469592a53bcada9e7b6fda2b07d8", "08771a431d03e784400ba33f86a46300");
}elseif ($_GET['type'] == 'mobile') {
	$GtSdk = new GeetestLib("0381469592a53bcada9e7b6fda2b07d8", "08771a431d03e784400ba33f86a46300");
}
session_start();
$user_id = "test";
$status = $GtSdk->pre_process($user_id);
$_SESSION['gtserver'] = $status;
$_SESSION['user_id'] = $user_id;
echo $GtSdk->get_response_str();
 ?>