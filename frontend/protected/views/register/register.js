$(document).ready(function(){

       $('#register input[name="user_type"]').click(function(){   //user type
           var value = $(this).val();
           var reg   = $('#register');
           $('input[name=user_type_hidden]').val(value);

           if(parseInt(value)==1) {
                $('input[name="com_url"]').val('http://');
                reg.find('.comurl').hide();

                $('input[name="gro_name"]').val('');
                $('input[name="gro_url"]').val('http://');
                reg.find('.siteurl').show();
                reg.find('.sitename').show();
           } else {
           
                $('input[name="gro_url"]').val('http://');
                $('input[name="gro_name"]').val('');
                reg.find('.siteurl').hide();
                reg.find('.sitename').hide();

                $('input[name="com_url"]').val('http://');
                reg.find('.comurl').show();
           }
       }); 

       var wrongleft = "<img src='../../../images/smallwrong.gif' width='14' height='14' ><font style='color:red;line-height:14px;'>"; 
       var wrongright = "</font>";
       var imgringt = "<img src='../../../images/smallright.gif'>";
       $("input[name='user_name']").blur(function(){   //当用户栏失去焦点时验证用户名的唯一性，和格式
            var tinput= $(this);
            var value = tinput.val();
            if (!value) {
                $(this).next().html(wrongleft+"用户名不能为空！"+wrongright);
            } else {
                value = escape(value);
                $.get('services/register.php',{action:'getname',name:value},function(data){
                    if(data>0) {
                        tinput.next().html(wrongleft+"该用户名已被使用！"+wrongright);
                    } else {
                        tinput.next().html(imgringt);
                    }
                });
            }
       });

       function validateInput(name, msg) {
           $('input[name="'+name+'"]').blur(function(){
                var value = $(this).val();       
                if (!value) {
                    $(this).next().html(wrongleft+msg+wrongright);
                    //$(this).focus();
                } else {
                    if(name=='user_pass') {
                        if(value.length<6 || value.length>30) {
                            $(this).next().html(wrongleft+'密码必须为6到30个字符'+wrongright);
                        } else {
                            $(this).next().html(imgringt);
                        }
                    } else {
                        $(this).next().html(imgringt);
                    }
                }
           });
       }

       validateInput('add_text', '企业详细地址不能为空！');
       validateInput('user_pass', '密码不能为空！');
       validateInput('com_name', '企业名称不能为空！');
       validateInput('cag_text', '经营范围不能为空！');

       $("input[name=auth_code]").blur(function(){
            var auth_code = $(this).val();
            if(auth_code==''){
                $(this).next().html(wrongleft+"验证码不能为空！"+wrongright);
                /*$(this).focus(function(){
                    $(this).next().html('');
                });*/
            }
       });
       
       $("input[name=user_cell]").blur(function(){
           var user_cell = $(this).val();
           if(user_cell==''){
                $(this).next().html(wrongleft+"获取验证码的手机不能空"+wrongright);
                /*$(this).focus(function(){
                    $(this).next().html("<font color='#FF0000'>必填</font> <a href='####' class='GetCode'>免费获取验证码</a>");
                    getCode();
                });*/
           } else {
                $(this).next().html("<font color='#FF0000'>必填</font><a href='####' class='GetCode'>免费获取验证码</a>");
                getCode();
           }
        });

       $('input[name=user_email]').blur(function(){
        var user_email = $(this).val();
        if(user_email==''){
             $(this).next().html(wrongleft+"邮箱不能空"+wrongright);
        } else {
            var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
            if(!reg.test(user_email)){
                $(this).next().html(wrongleft+"你输入的邮箱格式不正确"+wrongright);
                $(this).focus();
            } else {
                $(this).next().html(imgringt);                        
            }
          }
       });

       $('input[name="user_confirm_pass"]').blur(function(){
            var value = $(this).val();       
            if (!value) {
                $(this).next().html(wrongleft+"确认密码不能为空！"+wrongright);
            } else {
                var pass = $('input[name="user_pass"]').val();
                if(value!==pass) {
                    $(this).next().html(wrongleft+"两次密码输入不一样！"+wrongright);
                    $(this).val('');
                } else {
                    $(this).next().html(imgringt);
                }
            }
       });

       function submit(name,msg,pro){
            var obj = $("input[name="+name+"]");
            var value = obj.val();
            if(value.length<=0){
                 $(obj).next().html(wrongleft+msg+wrongright);
                 to_location(pro);
                 return false;
            }
            return true;
       }

       $('#register .register').click(function(){

           if(!submit('user_name','用户名不能空','pro_name')){
                return false;
           }
           if(!submit('user_pass','密码不能空','pro_pass')){
                return false;
           }
           if(!submit('user_confirm_pass','确认密码名不能空','pro_confirm_pass')){
                return false;
           }
           if(!submit('user_email','email不能空','pro_email')){
                return false;
           }

           if(!submit('user_cell','获取验证码得手机不能空','pro_cell')){
                return false;
           }

           if(!submit('auth_code','验证码不能为空！','pro_code')){
                return false;
           } 

           if(!submit('com_name','企业名称不能为空','pro_com_name')){
                return false;
           }
           if(!submit('cag_text','经营范围不能空','pro_cag')){
                return false;
           }
           if(!submit('add_text','企业详细地址不能为空','pro_add')){
                return false;
           }
           return true;
        });

        $('.province_id').change(function(){
            var str_id = $(this).val();
            $.get('services/register.php',{action:'getarea', id:str_id},function(data){
                $('.area_id').html(data);
            });
        });

        function addCookie(objName,objValue,objHours){
            var str = objName + "=" + escape(objValue);
            if(objHours > 0){
                var date = new Date();
                var ms = objHours*3600*1000;
                date.setTime(date.getTime() + ms);
                str += "; expires=" + date.toGMTString();
            }
            document.cookie = str;
        }

        function getCookie(objName){
            var arrStr = document.cookie.split("; ");
            for(var i = 0;i < arrStr.length;i ++){
                var temp = arrStr[i].split("=");
                if(temp[0] == objName) return unescape(temp[1]);
            }
        }

        function getCode(){

        $(".GetCode").click(function(){
            var $cell = $("input[name=user_cell]");
            var cell = $cell.val();
            if(cell==''){
                alert("获取验证的手机号不能空");
                return false;
            }

            /*var error_num = getCookie('error_num');
            if(isNaN(error_num)) {
                error_num = 0;
            } else {
                error_num = parseInt(error_num);
            }

            if(error_num>=2) {
                $cell.next().html(wrongleft+"获取验证码的次数错误已经达到3次"+wrongright);
                $cell.unbind('focus');
                $cell.attr('readonly', 'true');
                return false;
            } else {
                error_num = error_num + 1;
                addCookie('error_num', error_num, 24);

                if(cell.length!=11 || isNaN(cell)){
                    $cell.next().html(wrongleft+"获取验证码的手机不合法"+wrongright);
                    $cell.focus(function(){
                        $cell.next().html("<font color='#FF0000'>必填</font> <a href='####' class='GetCode'>免费获取验证码</a>");
                        getCode();
                    });

                    return false;
                } 
            }*/

            $(this).append('<img src="../../../images/loading.gif" width="16" height="16" border="0">');
            $.getJSON('register',{action:'getcode', tel:cell},function(data){
                $(".GetCode img").hide();
                $cell.val(cell);
                if(data.id==1) {
                    $cell.next().html("<span style='color:green;'>"+data.result+"</span>");
                    $("#mess_code").show();
                } else {
                    $cell.next().html("<span style='color:red;'>"+data.result+"</span>");
                }
            });
            return false;
        });
        }
        getCode();
        function to_location(a) {
            var url = location.href;
            var t = '';
            if(url.indexOf('#')>0) {
                url   = url.substring(0, url.lastIndexOf('#'));
            } 

            t   = url + '#' + a;
            location.href = t; 
            return false;
        }
   

});
