$(document).ready(function(){

        $('.revamp input[name="again_pass"]').focusout(function(){
            var new_pass = $('.revamp input[name="news_pass"]').val();
            if(new_pass.length>0) {
                if($(this).val()!=new_pass) {
                    alert('确认密码与新密码不一样，请确认。');
                }
            } else {
                alert('请先填写新密码。');
            }
        });

        $('.conserve').click(function(){
            var newpass = $('input[name="news_pass"]').val();   
            var conpass = $('input[name="again_pass"]').val();   
            var oldpass = $('input[name="old_pass"]').val();   
            if(oldpass.length==0){
                alert('旧密码不能为空！');
                return false;
            }
            if(newpass.length<6 || newpass.length>16){
                alert('新密码长度不正确！');
                return false;
            }

            if(newpass==conpass) {
                $.getJSON('account',{action:'password',old_pass:oldpass,news_pass:newpass,again_pass:conpass},function(data){
                    var error = $('.error');
                    if(data.id==1) {
                        error.css("color","green");
                    } else {
                        error.css("color","red");
                    }
                    error.show();
                    error.html(data.result);
                });

                return false;
            } else {
                alert('确认密码与新密码不一致');
                return false;
            }

            return false;
        });

});

