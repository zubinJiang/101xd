$(document).ready(function() {
        
        //用户名
        $('#registerstep .basic input[name="username"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写用户名，不少于2个汉字。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />用户名不能为空。');
                    $(this).focus();
                } else if(value.length>=2) {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" /> 用户名不少于2个汉字。');
                }
                span.show();
            }
        });

        //企业名
        $('#registerstep .basic input[name="usercom"]').bind({
            focusin: function() {
                var span = $(this).parent().find('span').eq(2);
                span.attr('class','blue');
                span.html('<img src="../../../images/rsicon_3.gif" width="14" height="14" />请填写企业名称，不少于4个汉字。');
                span.show();
            },
            blur:function() {
                var span  = $(this).parent().find('span').eq(2);
                var value = $(this).val();
                if(value.length==0) {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />企业名称不能为空。');
                    $(this).focus();
                } else if(value.length>=4) {
                    span.attr('class','green');
                    span.html('<img src="../../../images/rsicon_2.gif" width="14" height="14" />');
                } else {
                    span.attr('class','red');
                    span.html('<img src="../../../images/rsicon_4.gif" width="14" height="14" />企业名称不能少于4个汉字。');
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
                    $(this).focus();
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
                    $(this).focus();
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
});
