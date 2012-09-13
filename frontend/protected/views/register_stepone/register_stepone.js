$(document).ready(function() {
        
        //用户名
        $('#registerstep .basic input[name="username"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写用户名，不少于2个字符');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />用户名不能为空。');
                    //$(this).focus();
                } else if(value.length>=2) {
                    span.html('<img src="../../../images/loading.gif" width="16" height="16" />');
                    $.getJSON('register',{action:'checkusername',username:value},function(data){
                        if(parseInt(data.result)==1) {
                            span.attr('class','green');
                            span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                        } else {
                            span.attr('class','red');
                            span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />');       
                            span.append(data.msg);
                        }
                    });
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" /> 用户名不少于2个汉字');
                }
                span.show();
            }
        });

        //企业名
        $('#registerstep .basic input[name="usercom"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写企业名称，不少于2个字符');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />企业名称不能为空。');
                    //$(this).focus();
                } else if(value.length>=2) {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />企业名称不能少于2个字符');
                }
                span.show();
            }
        });

        //密码
        $('#registerstep .basic input[name="userpass"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.addClass('mc');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />密码由6-16个英文字母或数字组成，建议采用易记、难猜的英文数字组合。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />密码不能为空。');
                    //$(this).focus();
                } 
                if(value.length>=6 && value.length<=16) {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                }
                if(value.length<6 || value.length>16) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />密码位数在6-16位之间。');
                }
                span.show();
            }
        });
        $('#registerstep .basic input[name="userpassconf"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.addClass('mc');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请再次输入密码。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                var pass  = $('#registerstep .basic input[name="userpass"]').val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />密码不能为空。');
                    //$(this).focus();
                } 
                if(value==pass) {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />两次密码输入的不一致。');
                }
                span.show();
            }
        });

        //email
        $('#registerstep .basic input[name="useremail"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.addClass('mc');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />邮箱是您找回密码的方式之一，请您正确填写。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                var reg=/^\w{3,}@\w+(\.\w+)+$/;  
                if(reg.test(value)){        
                    $.getJSON('register',{action:'checkemail',email:value},function(data){
                        if(parseInt(data.result)==1) {
                            span.attr('class','green');
                            span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                            //$('#registerstep .basic .zc').attr('disabled','false');
                        } else {
                            span.attr('class','red');
                            span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />邮箱已被使用。');
                            //$('#registerstep .basic .zc').attr('disabled','true');
                        }
                    });
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />邮箱格式有误。');
                    //$('#registerstep .basic .zc').attr('disabled','true');
                    //$(this).focus();
                }
                span.show();
            }
        });

        //tel usertel
        $('#registerstep .basic input[name="usertel"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.addClass('td');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写手机来获取验证码。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length!=11){        
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />手机号码有误。');
                } else {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                    //$(this).focus();
                }
                span.show();
            }
        });
        $('#registerstep .basic input[name="usercode"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写验证短信中的验证码。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length!=6){        
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />验证码输入有误。');
                } else {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                    //$(this).focus();
                }
                span.show();
            }
        });

        function countdown() {
            var MyInterval=setInterval(function(){
                    var button = document.getElementById('getcode');
                    s = button.name;
                    --s;
                    button.value = '重发验证短信['+s+']';
                    button.disabled = true;
                    button.name = s;
                    if(s==0) {
                        button.value = '重发验证短信';
                        button.disabled = false;
                        button.name=59;
                        clearInterval(MyInterval);
                    }
                },1000);
        }

        $('#registerstep .basic #getcode').click(function(){
            var tel = $('#registerstep .basic input[name="usertel"]').val();
            if(tel.length>0) {
                if((/^1[3|4|5|8][0-9]\d{4,8}$/.test(tel))) {
                    var MyInterval=setInterval(function(){
                        var button = document.getElementById('getcode');
                            s = button.name;
                            --s;
                            button.value = '重发验证短信['+s+']';
                            button.disabled = true;
                            button.name = s;
                            if(s==0) {
                                button.value = '重发验证短信';
                                button.disabled = false;
                                button.name=59;
                                clearInterval(MyInterval);
                            }
                        },1000);
                    $.getJSON('register',{action:'sendsms',mobile:tel},function(data){
                        if(parseInt(data.result)!=1) {
                            clearInterval(MyInterval);
                            var span = $('#registerstep .basic input[name="usertel"]').parent().find('span').eq(2);
                            span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />手机号码已注册或系统故障');
                            span.attr('class','red');
                            span.show();
                        } 
                    });
                }
            } else {
                var span  = $(this).parent().find('span').eq(2);
                span.attr('class','red');
                span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />请先填写手机号码。');
                span.show();
            }
        });

        function validate(name,msg,pro) {
            var $obj = $("#registerstep .basic input[name='"+name+"']");
            var value = $obj.val();
            if(value.length<=0){
                var span = $obj.parent().find('span').eq(2);
                span.attr('class','red');
                span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />' + msg +'');
                span.show();
                return false;
            }
            return true;
       }

       $('#registerstep .basic .zc').click(function(){
           if(!validate('username','用户名不能空')){
                return false;
           } 
           if(!validate('usercom','企业公司名称不能为空')){
                return false;
           }     
           if(!validate('userpass','密码不能空')){
                return false;
           } 
           if(!validate('userpassconf','确认密码不能为空')){
                return false;
           }     
           if(!validate('useremail','邮件不能空')){
                return false;
           } 
           if(!validate('usertel','手机号不能为空')){
                return false;
           }
           if(!validate('usercode','手机号不能为空')){
                return false;
           }          

           return true;
       });
});
