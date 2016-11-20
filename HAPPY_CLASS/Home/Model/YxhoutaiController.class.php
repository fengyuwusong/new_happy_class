<?php
namespace Home\Controller;
use Think\Controller;
class YxhoutaiController extends Controller {
    public function demo(){
    	$this->show();
    }
    function up_button()
    {
    	$id=intval(I('post.id'));
    	$button= new \Home\Model\buttonModel();
    	$button->add($id);
    }
    function sentdata()
    {
    	$this->show();
    }
    public function alldata(){
        $this->show();
    }
    public function showdata(){
		// $time=I('post.da');
    	$back = new \Home\Model\backModel();
    	$time=strtotime(I('get.date'));
    	$class_id=intval(I('get.id'));
    	$data1 = $back->returndata($time,$class_id);
    	// print_r($data1);



    	vendor("jpgraph-4.jpgraph.jpgraph");
    	vendor("jpgraph-4.jpgraph.jpgraph_line");
    	//必须要引用的文件  
		//包含曲线图文件
		// $data1 = array(523,634,371,278,685,587,490,256,398,545,367,577); //第一条曲线的数组  
		// $data1 = array(1,3,4,21,32,55,77,99,111,123,234,235,236);
		$graph = new \Graph(600,400);//设置图片宽高  
		$graph->SetScale("textlin");
		$graph->SetShadow();     
		$graph->img->SetMargin(60,30,30,70); //设置图像边距  
		$graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效  
		$lineplot1=new \LinePlot($data1); //创建设置两条曲线对象  
		$lineplot1->value->SetColor("red");  
		$lineplot1->value->Show();
		$graph->Add($lineplot1);  //将曲线放置到图像上  
		   
		$graph->title->Set("投票曲线表");   //设置图像标题  
		$graph->xaxis->title->Set("时间（小时）"); //设置坐标轴名称  
		$graph->yaxis->title->Set("票数");  
		$graph->title->SetMargin(10); //距离图片顶部magin 
		$graph->xaxis->title->SetMargin(10);//横线下的标注距离横线margin
		$graph->yaxis->title->SetMargin(10);//垂线下的标注距离垂线margin
		   
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体  
		$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);  
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);   
		// $graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());//以月份显示x轴  
		  
		$graph->Stroke();  //输出图像 
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
    public function test1(){
        $a='-100';
        echo intval($a);
    }
}