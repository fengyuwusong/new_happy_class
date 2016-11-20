<?php
namespace Home\Controller;
use Think\Controller;
class YxhoutaiController extends Controller {
    //埋点函数，点击一次按钮则触发一次事件
    function up_button()
    {
    	$id=intval(I('post.id'));
    	$button= new \Home\Model\buttonModel();
    	$button->add($id);
    }
    function timedata()
    {
    	$this->display();
    }
    public function alldata(){
        $this->show();
    }
    public function showdata(){
        $back = new \Home\Model\backModel();
        $time=strtotime(I('get.date'));
        $class_id=intval(I('get.id'));
        $data = $back->returndata($time,$class_id);
        $data1=$data['num'];
        $companys=$data['time'];
        $datay=$data1; //纵坐标数据 
        $datax=$companys; //横坐标数据 
        vendor("jpgraph-4.jpgraph.jpgraph");
        vendor("jpgraph-4.jpgraph.jpgraph_bar");
        // Create the graph. These two calls are always required 
        $graph = new \Graph(800,600); //图像高宽 
        $graph->SetScale('textint',0,100); 
        $graph->xaxis->SetTickLabels($datax); 
        $graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10); 
        $graph->xaxis->SetLabelAngle(30); 
        $graph->yaxis->scale->SetGrace(20); 
        $graph->xaxis->scale->SetGrace(20); 
        // Add a drop shadow 
        $graph->SetShadow(); 
        // Adjust the margin a bit to make more room for titles 
        $graph->img->SetMargin(40,30,20,40); 
        $graph->graph_theme = null;
        // Create a bar pot 
        $bplot = new \BarPlot($datay); 
        // Adjust fill color 
        $bplot->SetFillColor('blue'); 
        $bplot->value->Show(true); 
        $bplot->value->SetFont(FF_SIMSUN,FS_BOLD,10); 
        $bplot->value->SetAngle(45); 
        $bplot->value->SetFormat('%d');
        // $bplot->value->show(true);
        $graph->Add($bplot); 
        // Setup the titles 
        $graph->title->Set('投票曲线表'); 
        $graph->xaxis->title->Set('5分钟一个节点'); 
        $graph->yaxis->title->Set('增长的票数'); 
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 
        $graph->title->SetFont(FF_SIMSUN,FS_BOLD); 
        // Display the graph 
        $graph->Stroke();  
    }
    public function showday(){
        $back = new \Home\Model\backModel();
        $time=strtotime(I('get.date'));
        $class_id=intval(I('get.id'));
        $data = $back->returnday($time,$class_id);
        $data1=$data['num'];
        $companys=$data['time'];
        $datay=$data1; //纵坐标数据 
        $datax=$companys; //横坐标数据 
        vendor("jpgraph-4.jpgraph.jpgraph");
        vendor("jpgraph-4.jpgraph.jpgraph_bar");
        // Create the graph. These two calls are always required 
        $graph = new \Graph(1200,600); //图像高宽 
        $graph->SetScale('textint',0,1000); 
        $graph->xaxis->SetTickLabels($datax); 
        $graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10); 
        $graph->xaxis->SetLabelAngle(30); 
        $graph->yaxis->scale->SetGrace(20); 
        $graph->xaxis->scale->SetGrace(20); 
        // Add a drop shadow 
        $graph->SetShadow(); 
        // Adjust the margin a bit to make more room for titles 
        $graph->img->SetMargin(40,30,20,40); 
        $graph->graph_theme = null;
        // Create a bar pot 
        $bplot = new \BarPlot($datay); 
        // Adjust fill color 
        $bplot->SetFillColor('blue'); 
        $bplot->value->Show(true); 
        $bplot->value->SetFont(FF_SIMSUN,FS_BOLD,10); 
        $bplot->value->SetAngle(45); 
        $bplot->value->SetFormat('%d');
        // $bplot->value->show(true);
        $graph->Add($bplot); 
        // Setup the titles 
        $graph->title->Set('投票曲线表'); 
        $graph->xaxis->title->Set('一小时一个节点'); 
        $graph->yaxis->title->Set('增长的票数'); 
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 
        $graph->title->SetFont(FF_SIMSUN,FS_BOLD); 
        // Display the graph 
        $graph->Stroke();  
    }
    function changedata(){
        $this->show();
    }
    //获取票数的函数
    function getnum(){
        $id=intval(I('post.id'));
        $class = new \Home\Model\ClassModel();
        $num=$class->getnum($id);
        $this->ajaxReturn($num);
    }
    //改变票数的函数
    public function change()
    {
        $id=intval(I('post.id'));
        $change=intval(I('post.num'));
        $class = new \Home\Model\ClassModel();
        $data=$class->change($id,$change);
        $this->ajaxReturn($data);
    }
    //显示原始票数的函数
    public function showsource(){
        $id=intval(I('post.id'));
        $class = new \Home\Model\ClassModel();
        $data=$class->showsource($id);
        $this->ajaxReturn($data);
    }
    //初始化back表
    public function iniback(){
        $back = new \Home\Model\backModel();
        if($back->ini()==1){
            echo "初始化完成";
        }
    }
    function demo(){
        $day=date("Y-m-d",time());
        $this->assign('day',$day);
        $time=date("Y-m-d H:i",time()-3600);
        $this->assign('time',$time);
        $this->display();
    }
}