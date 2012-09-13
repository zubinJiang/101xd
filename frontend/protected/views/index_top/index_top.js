$(document).ready(function(){

        $('#top .topc form[name=form]').submit(function(){
                
            var name = $('input[name=name]').val();
            var pass = $('input[name=pass]').val();

            if(name=='请输入用户登陆名' || name.length==0) {
                alert("用户名不能为空");
                return false;
            }

            if(pass.length==0) {
                alert("密码不能为空");
                return false;
            }

            return true;
        });
});