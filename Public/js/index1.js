$(document).ready(function(){
    //banner滚动
    $('#next').click(function(){
        index=(index+1)%3;
        img.eq(index).fadeIn().siblings().fadeOut();
    });
    $('#prev').click(function(){
        index=(index+1)%3;
        img.eq(index).fadeIn().siblings().fadeOut();
    });
    //设置定时播放
    var playtime=5000;//banner播放间隔时间
    play = function(){
        img.eq(index).fadeIn().siblings().fadeOut();
        index = (index+1)%3;
        mytime = setTimeout(play,playtime);
    }
    mytime = setTimeout(play,playtime);

   /*用dilog*/
    function menu() {
    $("#dialog-form").dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        resizable: false,
        position: ['center'],
        /*show: 'blind',
         hide: 'blind',*/
        // left:20,
        // top:20,
        height:500,
        width: 900,
        // dialogClass: 'ui-dialog-osx',
        buttons: {
            // "取消": function () {
            //     $(this).dialog("close");
            // }
        },
    });
}
     /*循环输出班级*/
    function output_class(length){
        for(var i=0;i<length;i++){
            var str='<div id="class'+i+'" class="class">'
                    +'<div class="pic"><img  id="cover'+i+'" style="width:160px;height:200px;"></div>'
                    +'<div class="num"><span id="id'+i+'"></span></div></div>';
            $("#classes").append(str);
        menu();
        }
       

    }    
    function click(image,id,video){
        id.on("click",function(e){
            //打开dilog并加载图片
            $("#dialog-form").dialog("open");
            document.body.scroll = "no";
            $("#dialog-form").html('<div id="danmup" style="margin:0 auto;"></div>');
            $("#danmup").DanmuPlayer({
                src:video,       //视频源
                top:30,
                width:840,            //视频宽度
                height:414,            //视频高度
                // speed:20000,            //弹幕速度，这是数值指的是视频穿过672像素所需要的毫秒数
                // sumTime:65535,              //弹幕视频的总时间，可不填
                // danmuList:{},               //弹幕列表
                // defaultColor:"#ffffff",   //弹幕的默认字体颜色
                // fontSizeSmall:16,           //小弹幕的字号
                // FontSizeBig:24,             //大弹幕的字号
                // opacity:"1",            //弹幕默认透明度
                // topBottonDanmuTime:6000,  //底部及顶部弹幕存留的时间
                // urlToGetDanmu:"",     //用来接收弹幕信息的url  (稍后介绍)
                // urlToPostDanmu:"" ,   //用来存储弹幕信息的url  (稍后介绍)
                // maxCountInScreen: 40,   //屏幕上的最大的显示弹幕数目,弹幕数量过多时,优先加载最新的。
                // maxCountPerSec: 10      //每分秒秒钟最多的弹幕数目,弹幕数量过多时,优先加载最新的。
            });
               $("#dialog-form video").attr("poster",image);

        });
    }
    // $(".danmu-video").attr()
    /*获取数据*/
    function getClass() {
        $.ajax({
            type: "post",
            url :getClassUrl,
             data:{
             },
            dataType: "json",
            success: function (res) {
                output_class(res.data.length);
                $("#dialog-form").dialog({close: function(event, ui) {
                        $("#dialog-form").html("");
                    }
                });
                for(var i=0;i<res.data.length;i++){   
                    (function(){
                        $("#cover"+i).attr("src",res.data[i].cover);//显示封面
                        $("#id"+i).text(res.data[i].name+','+res.data[i].info);//显示班级和介绍
                        // 点击封面
                        var image=res.data[i].image;
                        var id=$("#cover"+i);
                        var video=res.data[i].video;
                        click(image,id,video);
                    })(i);   //闭包
                }             
            }
        });
    };
    getClass(); 

})

