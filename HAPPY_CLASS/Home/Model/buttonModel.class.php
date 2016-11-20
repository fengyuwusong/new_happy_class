<?php 
namespace Home\Model;
use Think\Model;
class buttonModel extends Model {
	//增加新的投票人信息
	function add($id){
		$result['id']=$id;
        $this->where($result)->setInc('num');
	}
}
?>