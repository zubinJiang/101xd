$(document).ready(function(){
       $('.getmess').click(function(){
            var this_a = $(this);
            var user_name=$("input[name=name]").val();
            var user_tel = $("input[name=tel]").val();
            if(user_tel==""){
                alert("请输入您的账号绑定的手机号码");
                return false;
            } 

            this_a.append('<img src="../../../images/loading.gif" width="16" height="16" border="0">');
            $.getJSON("retrieveuser",{action:"getmess", tel:user_tel, name:user_name},function(data){
                this_a.html('获取短信');
                if(data.id==1) {
                    $(".get_again").show();
                    $("input[name=user_id]").val(data.uid);
                } else {
                    alert(data.result);
                }
            });
            return false;
        });

        $(".pinless").click(function(){
                var news_tel = $("input[name=news_tel]").val();
                var news_pass = $("input[name=news_pass]").val();
                var news_pass_again = $("input[name=news_pass_again]").val();
                if(news_tel==''){
                    $("input[name=news_tel]").focus();
                    alert("绑定手机不能空");
                    return false;
                }
                if(news_pass==''){
                    $("input[name=news_pass]").focus();
                    alert("登录密码不能空");
                    return false;
                }
                if(news_pass!=news_pass_again){
                    $("input[name=news_pass]").focus();
                    $("input[name=news_pass]").val("");
                    $("input[name=news_pass_again]").val("");
                    alert("确认密码不一致");
                    return false;
                }
                return true;
        });

        $(".step_login").click(function(){
        

                var tel = $("input[name=tel]").val();
                if(tel==''){
                    alert("获取验证码的手机不能空");
                    return false;
                } 

                var code = $("input[name=code]").val();
                if(code==''){
                    alert("验证码不能空");
                    return false;
                }
                return true;
        });

        
});
