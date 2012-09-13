$(document).ready(function(){
        $('#pwdemail input[name="email"]').focusin(function() {
            $('#pwdemail .afresh_non').html('');
        });

        $('#pwdemail .next').click(function(){
            var t_email = $('#pwdemail input[name="email"]').val();
            var t_id    = $('#pwdemail .afresh_non').attr("id");
            t_id = parseInt(t_id);
            if(t_email==''){
                alert("邮箱不能空");
                return false;
            }
            if(t_id==0) { 
                alert('此邮箱不存在，请输入正确的邮箱！');
                return false;
            }
            $('#pwdemail .afresh_non').html('<img src="../../../images/loading.gif" width="16" height="16" border="0">');
            $.get('services/validateemail.php',{action:'getname',email:t_email,id:t_id},function(data){
                if(data<=0) {
                    $('#pwdemail .afresh_non').html('此邮箱不正确！');
                    return false;
                } else {
                    $('#pwdemail .afresh_non').html('');
                    $.get('services/validateemail.php',{action:'getpwd',email:t_email,id:t_id},function(data){
                        $('#pwdemail .afresh_non').html('');
                        $('#pwdemail .kuang6').hide();
                        $('#pwdemail').append(data);
                        toEmail();
                    }) ;
                }
            });
        });

        function toEmail() {
            $("#pwdemail .kuang7 input[type='botton']").click(function(){
                var email = $(this).attr('rel');                
                var start = email.indexOf('@');

                var tag = email.substring(start+1, email.length);
                if(tag=='gmail') {
                    tag = 'google.com';
                }
                location.href = 'http://mail.' + tag;
            });
        }

        $('.pwdemail .ll input[name="pass"]').blur(function(){
                var pass = $(this).val();
            if(pass.length<6 || pass.length>30) {
                $(this).next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />密码必须是6-30个字符！").removeClass('spa').css('color','red');
            } else {
                $(this).next().html("<img src='../../../images/smallright.gif' width='17' height='17' border='0' />").removeClass('spa');
            }
        });

        $('.pwdemail .ll input[name="conpass"]').blur(function(){
                var cpass = $(this).val();
            if(!cpass) {
                $(this).next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />确认密码不能为空！").css('color','red');
            } else {
                var pass= $('.pwdemail .ll input[name="pass"]').val();
                if(pass!=cpass) {
                    $(this).next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />两次密码不一致！").css('color','red');
                } else {
                    $(this).next().html("<img src='../../../images/smallright.gif' width='17' height='17' border='0' />");
                }
            }
        });

        $('.pwdemail .button').click(function(){
            var pass= $('.pwdemail .ll input[name="pass"]').val();
            var cpass= $('.pwdemail .ll input[name="conpass"]').val();

            if(!pass || pass.length<6 || pass.length>30) {
                $('.pwdemail .ll input[name="pass"]').next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />密码必须是6-30个字符！").removeClass('spa').css('color','red');
                return false;
            } 

            if(!cpass || cpass!=pass) {
                $('.pwdemail .ll input[name="conpass"]').next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />两次密码不一致！").css('color','red');
                return false;
            }

            return true;
        });
});
