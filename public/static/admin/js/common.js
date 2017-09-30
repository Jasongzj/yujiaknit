/**
 * Created by Jason on 2017/7/15.
 */
/*页面 全屏-添加*/
function o2o_edit(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}

/*添加或者编辑缩小的屏幕*/
function o2o_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*-删除*/
function o2o_del(url, id){
    data = {};
    data['status'] = -1;

    if (id == undefined) {
        var ids = {};

        $("input[name=id]:checked").each(function(i) {
            ids[i] = $(this).val();
        });
        data['id'] = ids;
    } else {
        data['id'] = id;
    }

    layer.confirm('确认要删除吗？',function(index){
        console.log(data);
        set_status(url, data);
    });
}

/*修改状态*/
function set_status(url,data) {
    $.post(url, data, function (result) {
        if (result.code == 200) {
            return layer.msg(result.msg, {
                icon:1,
                time: 1500
            }, function () {
                window.location.reload();
            });
        } else {
            return layer.msg(result.msg, {
                icon:2,
                time: 1500
            }, function () {
                window.location.reload();
            });
        }
    }, 'JSON');
}

/* 排序功能ajax实现*/
$('.listorder input').blur(function () {
    //获取主键id
    var id = $(this).attr('attr-id');
    //获取排序的值
    var listorder = $(this).val();

    var postData = {
        'id': id,
        'listorder': listorder
    };
    var url = SCOPE.listorder_url;
    console.log(postData);
    //执行异步请求
    $.post(url, postData, function (result) {
        if(result.code == 200){
            location.href=result.data;
        } else {
            alert(result.msg);
        }
    }, 'json');
});
