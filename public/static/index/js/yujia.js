

$(function() {
    //关闭click.bs.dropdown.data-api事件，使顶级菜单可点击
    $(document).off('click.bs.dropdown.data-api');
    //导航下拉菜单自动展开
    $('.nav .dropdown').mouseenter(function(){
        $(this).addClass('open');
    });
    //导航下拉菜单自动关闭
    $('.nav .dropdown').mouseleave(function(){
        $(this).removeClass('open');
    });

    //证件滚动
    var timer='';//设置一个定时器
    var $box1=$('#scroll').children().clone(true);/*克隆box1的子元素*/
    $('#scroll2').append($box1);//将复制的元素插入到#box2中
    var $left=parseInt($('.license').css('left'));//获取.box的left值
    var scroll=function(){
        $left-=1;//设置滚动速度为1
        $('.license').css('left',$left+'px');//left赋值
        if($left<-800){//当box值小于-1500px时，重置.box left值为0；
            $('.license').css('left','0');
            $left=0;
        }
        timer =setTimeout(scroll,30);
    }
    setTimeout(scroll,100);
    $('.wrap').hover(function(){
        clearTimeout(timer);
    },function(){
        setTimeout(scroll,100);
    });

});
/*弹层*/
function layerout(url,w,h){
    if (url == null || url == '') {
        url="404.html";
    };
    if (w == null || w == '') {
        w=1200;
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };
    layer.open({
        type: 2,
        area: [w+'px', h +'px'],
        fix: false, //不固定
        maxmin: true,
        shade:0.4,
        shadeClose: true, //点击遮罩关闭
        content: url
    });
}

/*表单验证*/
function validate(id) {
    if (id == "name") {
        var name = $("#name").val();
        if (name == "") {
            $("#notice_name").parent().addClass('has-error');
            $("#notice_name").css('display','inline');
            $("#submitBtn").attr('disabled',true);
        } else {
            $("#notice_name").parent().removeClass('has-error');
            $("#notice_name").css('display','none');
            $("#submitBtn").removeAttr('disabled');
        }
    } else if (id=="email") {
        var email = $("#email").val();
        if (email == "") {
            $("#notice_email").parent().addClass('has-error');
            $("#notice_email").css('display','inline');
            $("#notice_correct_email").parent().removeClass('has-error');
            $("#notice_correct_email").css('display','none');
            $("#submitBtn").attr('disabled',true);
        } else if (!email.match(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn)$/)) {
            $("#notice_email").parent().removeClass('has-error');
            $("#notice_email").css('display','none');
            $("#notice_correct_email").parent().addClass('has-error');
            $("#notice_correct_email").css('display','inline');
            $("#submitBtn").attr('disabled',true);
        } else{
            $("#notice_email").parent().removeClass('has-error');
            $("#notice_email").css('display','none');
            $("#notice_correct_email").parent().removeClass('has-error');
            $("#notice_correct_email").css('display','none');
            $("#submitBtn").removeAttr('disabled');
        }
    } else if (id=="subscribe") {
        var subscribe = $('#subContent').val();
        if (!subscribe.match(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn)$/)) {
            $("#notice_correct_subscribe").parent().addClass('has-error');
            $("#notice_correct_subscribe").css('display', 'block');
            $("#notice_subscribe").parent().removeClass('has-error');
            $("#notice_subscribe").css('display', 'none');
        } else {
            $("#notice_correct_subscribe").parent().removeClass('has-error');
            $("#notice_correct_subscribe").css('display', 'none');
            $("#notice_subscribe").parent().removeClass('has-error');
            $("#notice_subscribe").css('display', 'none');
        }
    }
}
