//时间戳转换成四位时间 上午 10:10
function unix_to_datetime(uTime) {
    var myDate = new Date(uTime * 1000);
    var hours = myDate.getHours();
    var minutes = myDate.getMinutes();
    var day = myDate.getDate();
    var year = myDate.getFullYear();
    var month = myDate.getMonth();
    if (minutes == 0) {
        minutes = minutes + '0';
    }
    if (hours <= 12) {
        return year + '年' + (month + 1) + '月' + day + '日上午 ' + hours + ':' + minutes;
    }
    else {
        return year + '年' + (month + 1) + '月' + day + '日下午 ' + hours + ':' + minutes;
    }
}

function getDanmu(class_id) {
    $.ajax({
        type: "get",
        url: getDanmuUrl,
        data: {
            class_id: class_id,
            method: 'admin'
        },
        dataType: "json",
        success: function (res) {
            console.log(res);
            var str = '';
            var douhao, maohao;
            for (var i = 0; i < res.danmu.length; i++) {
                douhao = res.danmu[i].content.indexOf(',');
                maohao = res.danmu[i].content.indexOf(':');
                str += '<tr><td>' + res.danmu[i].order_id + '</td><td>' + res.danmu[i].content.substr(maohao + 2, douhao - maohao - 3)
                    + '</td><td>' + res.danmu[i].class_name + '</td><td>' + unix_to_datetime(res.danmu[i].time) + '</td><td>' +
                    '<span class="label label-danger" id="del" onclick="delDanmu(' + res.danmu[i].id + ')">删除</span></td>';
            }
            ;
            $(".showMes").html(str);
        }
    });
}
var flag = 0;
//筛选关键字
function filter() {
    flag = 1;
    if ($("#key_word").val() == '') {
        alert('参数不能为空！');
    } else {
        $.ajax({
            type: "post",
            url: filterDanmuUrl,
            data: {
                key_word: $("#key_word").val(),
            },
            dataType: "json",
            success: function (res) {
                console.log(res);
                if (res.Status == 0) {
                    alert('无该关键字的弹幕！');
                } else if (res.Status == 200) {
                    var str = '';
                    var douhao, maohao;
                    for (var i = 0; i < res.danmu.length; i++) {
                        douhao = res.danmu[i].content.indexOf(',');
                        maohao = res.danmu[i].content.indexOf(':');
                        str += '<tr><td>' + res.danmu[i].order_id + '</td><td>' + res.danmu[i].content.substr(maohao + 2, douhao - maohao - 3)
                            + '</td><td>' + res.danmu[i].class_name + '</td><td>' + unix_to_datetime(res.danmu[i].time) + '</td><td>' +
                            '<span class="label label-danger" id="del" onclick="delDanmu(' + res.danmu[i].id + ')">删除</span></td>';
                    }
                    ;
                    $(".showMes").html(str);
                }
            }
        });
    }
}
//删除弹幕方法
function delDanmu(danmu_id) {
    $.ajax({
        type: "post",
        url: delDanmuUrl,
        data: {
            danmu_id: danmu_id
        },
        dataType: "json",
        success: function (res) {
            if (res.Status == 200) {
                alert('删除成功!');
                if (flag == 1) {
                    filter();
                } else {
                    getDanmu('all');
                }
            }
        }
    });
}
$(document).ready(function () {
    getDanmu('all');
    $("#filter").on('click', function (e) {
        filter();
    });
})