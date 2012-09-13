$(document).ready(function(){

        $('#forget input[name="code"]').blur(function(){
            var value = $(this).val();
            if(!value) {
                $(this).next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />验证码不能为空！").css('color','red');
            } else {
                $(this).next().html("<img src='../../../images/smallright.gif' width='17' height='17' border='0' />");
            }
        });

        $("input[name=name]").blur(function(){
            var value = $(this).val();
            if(!value) {
                $(this).next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />账号不能为空！").css('color','red');
            } else {
               $.get("forget",{action:"getname", name:value},function(data){
                    if(data==''){
                       $("input[name=name]").next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />账号不存在！").css('color','red');      
                    } else {
                       $("input[name=name]").next().html("<img src='../../../images/smallright.gif' width='17' height='17' border='0' />"); 
                    }
               });
            }
        });

        $('#forget .kuang input[type="submit"]').click(function(){
            var name = $('#forget .kuang input[name="name"]').val();

            if(!name) {
                $('#forget .kuang input[name="name"]').next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />账号不能为空！").css('color','red');
                return false;
            }
            
            var code = $('#forget .kuang input[name="code"]').val();
            if(code.length<4) {
                $('#forget .kuang input[name="code"]').next().html("<img src='../../../images/smallwrong.gif' width='17' height='17' border='0' />验证码为空或少于4位！").css('color','red');
                return false;
            }
            
            return true;
        });

        $('#forget #reget').click(function(){
            var myDate = new Date();
            $('#forget li.lii span.spn img').attr('src', 'check.php?c=' + myDate.getTime());

            return false;
        });
});
