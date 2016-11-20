<?php
/**
 * Created by PhpStorm.
 * User: 风雨雾凇
 * Date: 2016/11/8
 * Time: 10:42
 */
namespace Home\Model;
use Think\Model;
class ClassModel extends Model{
    /*
     * 添加班级信息
     * name 班级名称
     * info 班级信息
     * cover 封面token url
     * image 宣传图token url
     * video 视频token url
     */
    public function addClass($name,$info){
        $add['name']=$name;
        $add['info']=$info;
        $class=M('class');
        $class->add($add);
    }
    /*
     * 获得班级信息
     */
    public function getClass(){
        $class=M('class');
        $res=$class->select();
        return $res;
    }
    //通过班级id获取班级名称
    public function getClassName($class_id){
        $class=M('class');
        $map['id']=$class_id;
        $name=$class->field('name')->where($map)->find();
        return $name;
    }
    //自增票数的函数
    function addnum($id){
        $result['id']=$id;
        $this->where($result)->setInc('num');
    }
    //获取当前票数的函数
    function getnum($id){
        $result['id']=intval($id);
        $data=$this->where($result)->select();
        if($data[0]['num']!=NULL)
            return intval($data[0]['num']);
        else
            return 0;
    }
    //改变票数的函数，数据库字段为10意味数据库在原有数据基础上加了10票，为-10意味数据库在原有数据基础上减10
    function change($id,$change){
        $result['id']=intval($id);
        $data=$this->where($result)->select();
        if($data[0]['change']==NULL){
            $this->where($result)->setDec('num',$change);
            $da['change']=-$change;
            $this->where($result)->save($da);
        }
        else{
            $this->where($result)->setDec('num',$change);
            $change=(-$change);
            $da['change']=$data[0]['change'].','.$change;
            $this->where($result)->save($da);
        }
        return 1;
    }
    //显示原票数的函数
    function showsource($id){
        $result['id']=intval($id);
        $data=$this->where($result)->select();
        $data1=explode(',',$data[0]['change']);
        $num=$data[0]['num'];
        for ($i=0; $i <count($data1); $i++) {
            $num=$num-$data1[$i];
        }
        return $num;
    }

}