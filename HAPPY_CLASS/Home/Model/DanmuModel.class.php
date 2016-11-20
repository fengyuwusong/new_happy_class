<?php
/**
 * Created by PhpStorm.
 * User: 风雨雾凇
 * Date: 2016/11/13
 * Time: 14:48
 */
namespace Home\Model;

use Think\Model;

class DanmuModel extends Model
{
    /*
     * 添加弹幕
     * danmu json
     */
    public function addDanmu($danmu, $class_id)
    {
        $Danmu = M("danmu");
        $add['danmu'] = $danmu;
        $add['class_id'] = $class_id;
        $add['time'] = time();
        $Danmu->add($add);
    }

    /*
     * 获取弹幕
     */
    public function getDanmu($class_id, $method)
    {
        $Danmu = M("danmu");
        if ($class_id != 'all') {
            $map['class_id'] = $class_id;
        }
        if ($method == 'admin') {
            $res = $Danmu->order('id desc')->where($map)->select();
        } else {
            $res = $Danmu->where($map)->field('time', true)->order('id desc')->select();
        }
        return $res;
    }

    /*
     * 删除弹幕
     * danmu_id 弹幕id
     */
    public function delDanmu($danmu_id)
    {
        $Danmu = M("danmu");
        $map['id'] = $danmu_id;
        $Danmu->where($map)->delete();
    }

    /*
     * 弹幕筛选
     * key_word 关键字
     */
    public function filterDanmu($key_word)
    {
        $Danmu = M("danmu");
        $map['danmu'] = array('like', array('{ &quot;text&quot;:&quot;%'.$key_word.'%&quot;,&quot;color%'), 'OR');
        $res = $Danmu->order('id desc')->where($map)->select();
        return $res;
    }
}