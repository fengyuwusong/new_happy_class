<?php
/**
 * Created by PhpStorm.
 * User: 风雨雾凇
 * Date: 2016/11/14
 * Time: 20:16
 */
namespace Home\Controller;

use Think\Controller;

class AdminController extends CommonController
{


    public function index()
    {
        $this->display();
    }

    public function add()
    {
        $this->display();
    }

    /*
     * 获取弹幕接口
     */
    public function getDanmu($class_id = 'all', $method = 'video')
    {
        $Danmu = D("Danmu");
        $res = $Danmu->getDanmu($class_id, $method);
        if ($method == 'video') {
            $first = 0;
            $danmu = '[';
            foreach ($res as $key => $val) {
                if ($first) {
                    $danmu .= ",";
                }
                $first = 1;
                $danmu .= "'" . $val['danmu'] . "'";
            }
            $danmu .= ']';
            $danmu = str_replace("&quot;", '"', $danmu);
            exit($danmu);
        } else if ($method == 'admin') {
            $i = 0;
            foreach ($res as $key => $val) {
                $content[$key] = array(
                    'order_id' => count($res) - $i,
                    'content' => str_replace("&quot;", '"', $val['danmu']),
                    'class_name' => $this->getClassName($val['class_id']),
                    'time' => $val['time'],
                    'id'=> $val['id']
                );
                $i++;
            }
            $res = array(
                'danmu' => $content,
                'Status' => 200
            );
            $this->ajaxReturn($res);
        }
    }

    /*
     * 添加弹幕接口
     * $danmu json { text:"这是弹幕" ,color:"white",size:1,position:0,time:2}
     */
    public function addDanmu()
    {
        $danmu = I('post.danmu');
        $class_id=I('get.class_id');
        $Danmu = D("Danmu");
        $Danmu->addDanmu($danmu, $class_id);
        exit($danmu);
    }

    public function delDanmu(){
        $danmu_id = I('post.danmu_id');
        if($danmu_id==''){
            $res=array(
                'Status'=>1,
                'Mes'=>'参数不能为空'
            );
            $this->ajaxReturn($res);
        }
        $Danmu = D("Danmu");
        $Danmu->delDanmu($danmu_id);
        $res=array(
            'Status'=>200,
            'Mes'=>'删除成功'
        );
        $this->ajaxReturn($res);
    }
    /*
     * 弹幕筛选
     * key_word 关键字
     */
    public function filterDanmu(){
        $key_word = I('post.key_word');
        if($key_word==''){
            $res=array(
                'Status'=>1,
                'Mes'=>'参数不能为空'
            );
            $this->ajaxReturn($res);
        }
        $Danmu = D("Danmu");
        $res=$Danmu->filterDanmu($key_word);
        if($res==null){
            $res = array(
                'Status' => 0,
                'Mes'=>'没有关于该关键字的弹幕'
            );
            $this->ajaxReturn($res);
        }
        $i = 0;
        foreach ($res as $key => $val) {
            $content[$key] = array(
                'order_id' => count($res) - $i,
                'content' => str_replace("&quot;", '"', $val['danmu']),
                'class_name' => $this->getClassName($val['class_id']),
                'time' => $val['time'],
                'id'=> $val['id']
            );
            $i++;
        }
        $res = array(
            'danmu' => $content,
            'Status' => 200,
            'Mes'=>'获取成功！'
        );
        $this->ajaxReturn($res);
    }

    /*
      * 添加班级
      * name 班级名
      * info 班级介绍
      * cover_key 封面key
      * video_key 视频key
      * image_key 宣传图key
      */
    public function addClass()
    {
        $name = I('post.name');
        $info = I('post.info');
        if ($name == '' || $info == '') {
            $res = array(
                'Status' => "1",
                'Mes' => "参数不能为空！"
            );
            $this->ajaxReturn($res);
        } else {
            $class = D('class');
            $class->addClass($name, $info);
            $res = array(
                'Status' => "200",
                'Mes' => "添加成功！"
            );
            $this->ajaxReturn($res);
        }
    }

    //上传封面
    public function uploadMainCover()
    {
        $config = array(
            'maxSize' => 104857600,
            'rootPath' => './Public/Uploads/',// 设置附件上传根目录
            'savePath' => '',// 设置附件上传（子）目录
            'saveName' => 'mainCover',
            'exts' => array('jpg'),// 设置附件上传类型
            'autoSub' => true,//自动使用子目录保存上传文件 默认为true
            'subName' => iconv("UTF-8", "gb2312", I("post.name")) . '/',
            'callback' => true,
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功

        }
    }

    //上传视频封面
    public function uploadVideoCover()
    {
        $config = array(
            'maxSize' => 104857600,
            'rootPath' => './Public/Uploads/',// 设置附件上传根目录
            'savePath' => '',// 设置附件上传（子）目录
            'saveName' => 'videoCover',
            'exts' => array('jpg'),// 设置附件上传类型
            'autoSub' => true,//自动使用子目录保存上传文件 默认为true
            'subName' => iconv("UTF-8", "gb2312", I("post.name")) . '/',
            'callback' => true,
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功

        }
    }

    //上传视频
    public function uploadVideo()
    {
        $config = array(
            'maxSize' => 104857600,
            'rootPath' => './Public/Uploads/',// 设置附件上传根目录
            'savePath' => '',// 设置附件上传（子）目录
            'saveName' => 'video',
            'exts' => array('mp4'),// 设置附件上传类型
            'autoSub' => true,//自动使用子目录保存上传文件 默认为true
            'subName' => iconv("UTF-8", "gb2312", I("post.name")) . '/',
            'callback' => true,
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功

        }
    }
}