$(document).ready(function(){

        checkinput();
        function checkinput(){

            $('input[name="name"]').focus(function(){
                $(this).val('');
                $(this).css('color','#000000');

                $("ul li.username img").remove();
                if('red'==$(this).attr('class')) {
                    $(this).removeClass('red');
                    $('#img_name_w').hide();
                }  
            });

            $('input[name=pass]').focus(function(){
                $(this).css('color','#000000');
                $("ul li.userpass img").remove();
                if('red'==$(this).attr('class')) {
                    $(this).removeClass('red');
                    $('#img_pass_w').hide();
                }
            });

            $('input[name=pass]').blur(function(){
                if (!$(this).val()){
                    $(this).addClass('red');
                    $("ul li.userpass img").remove();
                    $('#img_pass_w').html('密码不能为空！').show();
                } else {
                    $(this).after('<img src="../../../images/smallright0.gif" class="right">');
                }
            });

             $('input[name=name]').blur(function(){
                 if (!$(this).val()){
                    $(this).addClass('red');
                    $("ul li.username img").remove();
                    $('#img_name_w').html('用户名不能为空！').show();
                } else {
                    $(this).after('<img src="../../../images/smallright0.gif" class="right">');
                }
            });
        }

        $('form[name=form]').submit(function(){
                
            var name = $('input[name=name]').val();
            var pass = $('input[name=pass]').val();

            if(name=='请输入用户登陆名' || name.length==0) {
                $('input[name=name]').addClass('red');
                $('#img_name_w').html('<img src="../../../images/smallwrong.gif">请输入用户名！').show();

                checkinput();
                return false;
            }

            if(pass.length==0) {
                $('input[name=pass]').addClass('red');
                $('#img_pass_w').html('<img src="../../../images/smallwrong.gif">请输入密码！').show();
                checkinput();
                return false;
            }

            if(name.length>0 && pass.length>0) {
                return true;
            }

            return false;
        });
});
