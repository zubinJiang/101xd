$(document).ready(function(){
        
        $('#sms input[type="submit"]').click(function(){
            
            var tel = $('#sms #mobile').val();
            var content = $('#sms #content').val();
            
            if(tel.length<11) {
                alert('手机号码为空或输入错误,请检查后再发布！');
                return false;
            }

            if(content.length==0) {
                alert('短信内容不允许为空！');
                return false;
            }
            return true;
        });
});
