<?php 
namespace Home\Model;
use Think\Model;
class peopleModel extends Model {
	//增加新的投票人信息
	function addpeople($id){
		$data['class_id']=$id;
		$data['time']=time();
		$data['ip']=get_client_ip();
		// echo $data['ip'];
		$this->data($data)->add();
	}
	//检测ip是否已被录入过
	function checkip($ip)
	{
		$result['ip']=$ip;
		if(count($this->where($result)->select())>=1)
			return 1;
		else return 0;
	}
}
 ?>