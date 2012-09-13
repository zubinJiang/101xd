$(document).ready(function(){

        function findLocal() {
            var local = location.href;
            if(local.indexOf('#photo')>0) {
                $('#account .datum a').removeClass('current');
                $('#account #head').addClass('current');

                $("#account .metadata").hide();
                $("#account .portrait").show();
                $("#account .revamp").hide();
            }
        }

        findLocal();

        $('#account #head').click(function(){
            $('#account .datum a').removeClass('current');
            $(this).addClass('current');

            $("#account .metadata").hide();
            $("#account .portrait").show();
            $("#account .revamp").hide();

            return false;
        });


        $('#account #material').click(function(){
            $('#account .datum a').removeClass('current');
            $(this).addClass('current');
            $("#account .metadata").show();
            $("#account .portrait").hide();
            $("#account .revamp").hide();

            return false;
        });

        $('#account #password').click(function(){
            $('#account .datum a').removeClass('current');
            $(this).addClass('current');
            $("#account .portrait").hide();
            $("#account .metadata").hide();
            $("#account .revamp").show();

            return false;
        });

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

        $('.revamp .conserve').click(function(){
            var newpass = $('.revamp input[name="news_pass"]').val();   
            var conpass = $('.revamp input[name="again_pass"]').val();   
            var oldpass = $('.revamp input[name="old_pass"]').val();   
            if(oldpass.length==0){
                alert('旧密码不能为空！');
                return false;
            }
            if(newpass.length==0){
                alert('新密码不能为空！');
                return false;
            }
            if(conpass.length==0){
                alert('确认密码不能为空！');
                return false;
            }
            if(newpass==conpass) {
                $.getJSON('account',{action:'password',old_pass:oldpass,news_pass:newpass,again_pass:conpass},function(data){
                    var error = $('.revamp .error');
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
                alert('确认密码与新密码不一致，请重新填写。');
            }

            return false;
        });

        $('.metadata .conserve').click(function(){
                
                $('.metadata form').submit();
        });

});
