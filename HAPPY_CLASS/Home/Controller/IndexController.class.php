<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function index1()
    {
        $this->display();
    }

    public function demo()
    {
        $this->display();
    }

    //danmuplayer页面
    public function danmuPlayer($id,$name){
        $this->assign('id',$id);
        $this->assign('name',$name);
        $this->display();
    }

    /*
     * 获得班级信息
     * 返回
     * {"data":[{"id":"13","name":"sdvfdsav","info":"sdfvsd","cover":"http:\/\/oga3de3p0.bkt.clouddn.com\/FmLpplRxhEsmt_q1nCbT4lyUOdib","image":"http:\/\/oga3de3p0.bkt.clouddn.com\/FgtXXppVedigRpgGFHouNHuXX61r","video":"http:\/\/oga3de3p0.bkt.clouddn.com\/lo_k2Bp5mxOBHrzTj5VtcDd1XheD"}],"Status":"200"}
     * data array 数据 id 编号 name 班级名 info 班级简介 cover 代表图片url image 封面图片url video 宣传视频url
     * Status 200成功
     */
    public function getClass()
    {
        $class = D('class');
        $data = $class->getClass();
        $res = array(
            'data' => $data,
            'Status' => "200",
            'Mes' => "获取成功！"
        );
        $this->ajaxReturn($res);
    }

    public function vote(){
        $id=1;
        $code=I('post.code');
        $verify = new \Think\Verify();
        $result['code']=$verify->check($code,$id);
        $result['Status']=200;
        if($result['code']==false){
            $result['Mes']="验证码错误";
            $this->ajaxReturn($result);
            return;
        }
        $back = new \Home\Model\backModel();
        $people = new \Home\Model\peopleModel();
        $class = new \Home\Model\ClassModel();
        $id=I('post.class_id');
        cookie('vote','no',3600);
        // $result['c']= cookie('vote');
        $value = cookie('vote');
        if($people->checkip(get_client_ip())==1||$value=='yes'){
            $result['Mes']="不能重复投票";
        }else{
            $people->addpeople($id);
            $class->addnum($id);
            $back->judge($id);
            cookie('vote','yes',36000000);
            $result['Mes']="投票成功";
        }
        $this->ajaxReturn($result);
    }
    public function verify(){
        $config =    array(
            'fontSize'    =>    30,
            // 验证码字体大小
            'length'      =>    4,
            // 验证码位数
            'useNoise'    =>    true,
            // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        // $Verify->codeSet = '0123456789';
        $Verify->entry(1);
    }
}