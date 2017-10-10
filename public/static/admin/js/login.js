/**
 * 前端登录业务类
 */
function login() {
    //获取登录页面中的用户名
    var username = $('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    /*if (!username) {
        dialog.error('用户名不能为空');
    }
    if (!password) {
        dialog.error('密码不能为空');
    }*/

    var url = "/admin/login/login";
    var data = {'username':username,'password':password};
    //执行异步请求
    $.post(url,data,function(result){
        console.log(result.code);
        if(result.code === 0){
            return dialog.error(result.msg);
        } else if(result.code === 200){
            return dialog.success(result.msg, '/admin/index');
        }
    }, 'JSON');
}