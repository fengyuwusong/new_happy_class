// 点击图片
function clickPic(cover, name, id, num, info) {
    $('#' + cover).on('click', function (e) {
        showMask();
        document.documentElement.style.overflow = 'hidden';
        $('.putvidoe').html('<iframe src="'+iframe+'?id='+id+'&name='+name+'" scrolling="no" height="100%" width="60%" style="margin-left:20%">');
        var top = ($(window).height() - $("#hide").height()) / 2;
        var left = ($(window).width() - $("#hide").width()) / 2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        var width = $("#hide").width * 0.75 + 'px';
        var height = $("#hide").height * 0.2 + 'px';
        $("#hide").css({'top': top + scrollTop, "left": left + scrollLeft}).show();
        blue();
        $(".classname").text(name);
        $(".classnum").text(num + '票');
        $(".classsummary").text(info);
        $(".button").text("投票");
        $("#class_id").text(id);
    });
}

//获取班级信息并排版
function getClass(xy) {
    $(".container").show();
    $.ajax({
        type: "get",
        url: getClassUrl,
        data: {},
        dataType: "json",
        success: function (res) {
            // console.log(res);
            str='';
            //添加班级排版
            $("#classes").html('');
            for (var i = 0; i < res.data.length; i++) {
                str += '<div id="class' + i + '" class="class">' +
                    '<div class="pic">' +
                    '<img id="cover' + i + '" src="' + pub + '/Uploads/' + res.data[i].name + '/mainCover.jpg" style="width:100%;height:100%;margin:0 auto;">' +
                    '</div>' +
                    '<div class="name"><span id="name"' + res.data[i].id + '>' + res.data[i].name + '</span></div>' +
                    '</div>';
            }
            $("#classes").html(str);
            //每个班级添加点击事件
            var index;
            var ballot=new Array;//存储票数的数组
            for (var i = 0; i < res.data.length; i++) {
                clickPic("cover" + i, res.data[i].name,res.data[i].id,res.data[i].num,res.data[i].info);
                ballot.push(res.data[i].num);
            }
            var max=parseInt(Math.max.apply(null, ballot));//最大值
            var literal=75;
            var i=parseInt(max/literal);
            // alert(i);
            var first=100*(i+1);
            var two=75*(i+1);
            var third=50*(i+1);
            var four=25*(i+1);
            var topnum=first;
            $(".first").text(first);
            $(".two").text(two);
            $(".third").text(third);
            $(".four").text(four);
            // alert(position)
            //排行榜下的班级显示
            var str='';
            $('.voted_classes').html('');
            var columnH;
            var transparentH;
            for(var i = 0; i < res.data.length; i++){
                columnH=res.data[i].num/(topnum/4*5)*(xy*0.985);
                transparentH=(xy*0.985)-columnH;
                str+='<div class="voted_class class1">'+
                    '<div class="column">'+
                    '<div class="transparent" style="text-align:center;line-height:'+(transparentH*2-30)+'px;height:'+transparentH+'px;">'+res.data[i].num+'</div>'+
                    '<div class="white white'+i+'" style="height:'+columnH+'px;background-color:white;"></div></div>'+
                    '<div id="class">'+res.data[i].name +'</div>' +
                    '</div>';
            }
            // $(".white"+position).css({"background-color":"#ffff00"});
            $('.voted_classes').html(str);
            //关闭按钮添加隐藏事件
            $(".close").on("click",function(e){
                $("#hide").hide();
                document.documentElement.style.overflow='visible';
                hideMask();
                $('.putvidoe').html('');//取消弹幕插件的应用
            });
            $(".container").hide();
        }
    });
}

//点击投票后的方法
function vote(class_id) {
    //弹出验证框
    $("#dialog-form").dialog({
        autoOpen: true,
        modal: true,
        draggable: false,
        resizable: false,
        position: ['center'],
        width: 400,
        /*show: 'blind',
         hide: 'blind',*/
        // left:20,
        // top:20,
        // dialogClass: 'ui-dialog-osx',
        buttons: {
            "确定": function () {
                var dialog1 = $(this);
                //输入验证，点击确定后的事件
                $.ajax({
                    type: "post",
                    url: voteUrl,
                    data: {
                        class_id: class_id,
                        code: $("#pw").val(),
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.code == false)
                            alert(res.Mes);
                        else {
                            alert(res.Mes);
                            $(".button").text("已投");
                            $(".button").unbind();//消除点击投票的方法
                            dialog1.dialog("close");
                        }
                    }
                });
            },
            "取消": function () {
                $(this).dialog("close");
            }
        },

    });
}
//显示遮罩层
function showMask() {
    $("#mask").css("height", $(document).height());
    $("#mask").css("width", $(document).width());
    $("#mask").show();
}
//隐藏遮罩层  
function hideMask() {
    $("#mask").hide();
}
// 蓝色：滚动条消失时
function blue() {
    var width = (document.body.clientWidth);
    $(".blue-up").css({"border-left": width + "px solid transparent"});
    $(".blue-botton").css({"border-left": width + "px solid rgb(4,130,201)"});
}
$(document).ready(function () {
    //轮播图
    var W=$(".list").width();
    $("#list").css({"width":W*6,"left":-W});
    $("#list img").css({"width":W});
    var img=$('.banner a');
    var index=0;//索引
    $('#next').click(function(){
        index=(index+1)%3;
        img.eq(index).fadeIn().siblings().fadeOut();
    });
    $('#prev').click(function(){
        index=(index+1)%3;
        img.eq(index).fadeIn().siblings().fadeOut();
    });
    //设置定时播放
    var playtime=2000;//banner播放间隔时间
    play = function(){
        img.eq(index).fadeIn().siblings().fadeOut();
        index = (index+1)%3;
        mytime = setTimeout(play,playtime);
    }
    mytime = setTimeout(play,playtime);
    //设置鼠标放上停止播放
    $('#banner').hover(function(){
        clearTimeout(mytime);
    },function(){
        mytime = setTimeout(play,playtime);
    });
    //柱形图左边
    var xyheight=$(".xy").height();
    var windowH=$(window).height()*0.6;
    // alert(windowH);
    $("#hide").height(windowH);
    // var wid=$(".class").width();
    // alert(wid);
    // alert(xyheight)
    $(".left_num").css({"height":xyheight+'px'});
    $(".voted_classes").css({"margin-top":-xyheight+'px'});
    getClass(xyheight);
    $("#hide").hide();
    blue();
    //点击投票后触发的事件
    $(".button").on("click",function(e){
        vote($("#class_id").text());
    });

});

