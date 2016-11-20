<?php 
namespace Home\Model;
use Think\Model;
class backModel extends Model {
	//设置写入条件函数5分钟内票数超过50票记录一次，5分钟刷新一次时间点
	function judge($id){
		$result['class_id']=$id;
		$result2['id']=$id;
		$record=$this->where($result)->order('id DESC')->limit(1)->select();
		$class = new \Home\Model\ClassModel();
		$record2=$class->where($result2)->select();
		// print_r($record2);
		$people = new \Home\Model\peopleModel();
		$record3=$people->where($result)->order('id DESC')->limit(1)->select();
		// echo $record2[0]['num']-$record[0]['num'];
		// echo $record3[0]['time']-$record[0]['time'];
		if(($record2[0]['num']-$record[0]['num'])>=50||($record3[0]['time']-$record[0]['time'])>=300){
			$information['class_id']=$id;
			$information['num']=$record2[0]['num'];
			$information['time']=time();
			$this->data($information)->add();
		}
	}
	//初始化函数，因为第一函数需要拥有先制数据才可运作
	function ini(){
		$class=D('Class');
		$data=$class->select();
		// print_r($data);
		for ($i=0; $i < count($data); $i++) {
		 	$information['class_id']=$data[$i]['id'];
			$information['num']=0;
			$information['time']=time();
			$this->data($information)->add();
		}
		return 1;
	}
	//$time为时间戳，应为某天12点的时间戳，class_id为班级id确定需要统计哪个班的票数图
	public function returndata($time,$class_id)
	{
		$sql['class_id']=intval($class_id);
		$data=$this->where($sql)->order('time asc')->select();
		// echo $time;
		$datatime=$time;
		$i=0;
		$f=0;
		while ( $i< 14) {
			$judge=0;
			if($i==0){
				$time=$time-300;
			}
			// else if($i==1)
			// 	$time=$time+3000;
			else
				$time=$time+300;
				// echo "<br/>".date("Y-m-d H:i:s",$time);
			if ($time<=time()) {
				while($f<count($data)+1){
					if ($data[$f]['time']==null) {
						$judge=1;
						break;
					}
					if ($data[$f]['time']==$time) {
						break;
					}
					elseif ($data[$f]['time']>$time) {
						$judge=1;
						break;
					}
					$f++;
				}
				// echo $time>=$data[$f]['time'];
				// echo $f;
				if ($judge==1) {
					// echo "aaa".($f-1);
					$return[$i]=$data[$f-1]['num'];
				}
				else {
					// echo "aaa".$f;
					$return[$i]=$data[$f]['num'];
				}
			}
			else{
				break;
			}
			$i++;
		}
		// $data=$this->where($sql)->select();
		for($i= 0;$i< 13; $i++){ 
			// $str= $data[$i];
			if ($i!=0) {
			 	$datatime=$datatime+300;
			 } 
			// $returndata['time'][$i]=date("Y-m-d H:i:s",$datatime);
			 $returndata['time'][$i]=date("H:i",$datatime);
		} 
		// for($i= 0;$i< count($return); $i++){ 
		// 	$returndata['num'][$i]=intval($return[$i]);
		// }
		for($i= 1;$i< count($return); $i++){ 
			$returndata['num'][$i-1]=intval($return[$i]-$return[$i-1]);
		}
		// dump($data);
		// dump($return);

		return $returndata;
	}
	public function returnday($time,$class_id)
	{
		$sql['class_id']=intval($class_id);
		$data=$this->where($sql)->order('time asc')->select();
		// echo $time;
		$datatime=$time;
		$i=0;
		$f=0;
		while ( $i< 26) {
			$judge=0;
			if($i==0){
				$time=$time-3600;
			}
			// else if($i==1)
			// 	$time=$time+3000;
			else
				$time=$time+3600;
				// echo "<br/>".date("Y-m-d H:i:s",$time);
			if ($time<=time()) {
				while($f<count($data)+1){
					if ($data[$f]['time']==null) {
						$judge=1;
						break;
					}
					if ($data[$f]['time']==$time) {
						break;
					}
					elseif ($data[$f]['time']>$time) {
						$judge=1;
						break;
					}
					$f++;
				}
				// echo $time>=$data[$f]['time'];
				// echo $f;
				if ($judge==1) {
					// echo "aaa".($f-1);
					$return[$i]=$data[$f-1]['num'];
				}
				else {
					// echo "aaa".$f;
					$return[$i]=$data[$f]['num'];
				}
			}
			else{
				break;
			}
			$i++;
		}
		// $data=$this->where($sql)->select();
		for($i= 0;$i< 26; $i++){ 
			// $str= $data[$i];
			if ($i!=0) {
			 	$datatime=$datatime+3600;
			 } 
			// $returndata['time'][$i]=date("Y-m-d H:i:s",$datatime);
			 $returndata['time'][$i]=date("H:i",$datatime);
		} 
		// for($i= 0;$i< count($return); $i++){ 
		// 	$returndata['num'][$i]=intval($return[$i]);
		// }
		for($i= 1;$i< count($return); $i++){ 
			$returndata['num'][$i-1]=intval($return[$i]-$return[$i-1]);
		}
		// dump($data);
		// dump($return);

		return $returndata;
	}
}
 ?>