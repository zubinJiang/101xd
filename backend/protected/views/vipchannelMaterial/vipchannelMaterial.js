$(document).ready(function(){

    document.getElementById("user_name").disabled=true;
    document.getElementById("user_tel").disabled=true;
    
    //根据省份ID获取地区List 
    function get_area_by_province_id() {
        $('.province_id').change(function(){
            var str_id = $(this).val();
            $.get('services/goldroll.php',{action:'get', id:str_id},function(data){
                $('.area_id').html(data);
            })
        });
    }
    get_area_by_province_id();
    
    //update tel
    $("#update_tel").click(function(){
        document.getElementById("user_tel").disabled=false;
        $("input[name='usertel']").val('');
        $("#update_tel").html("").hide();
        $("#getcode").show();
        $("#usercode").show();
        $("input[name='set_code']").val('1');

    });
    //usertel blur
    $('input[name="usertel"]'). blur(function(){
        var value = $(this).val();
        if(value==''){
            alert("重心绑定的手机号不能空");
        }else if(/^1[3|4|5|8][0-9]\d{4,8}$/.test(value)==false){
            alert("重心绑定的手机号不合法");
        }
    });

    //验证码
    $('input[name="usercode"]').blur(function(){
    
            var value = $(this).val();
            if(value==''){
                alert("验证码不能空");
            }else if(value.length!=6 || isNaN(value)){
                alert("验证码有误");
            }
    });

    //免费发信息
    $('#getcode').click(function(){
            var tel = $('input[name="usertel"]').val();
            if(tel.length>0){
                if(/^1[3|4|5|8][0-9]\d{4,8}$/.test(tel)){
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
                    $.getJSON('vipchannelMaterial',{action:'sendsms',mobile:tel},function(data){
                        if(parseInt(data.result)!=1) {
                            clearInterval(MyInterval);
                            var span = $('#input[name="usertel"]').parent().find('span').eq(2);
                            alert("手机号码已注册或系统故障");
                            span.attr('class','red');
                            span.show();
                        } 
                    });
                }
            } else {
                var span  = $(this).parent().find('span').eq(2);
                span.attr('class','red');
                alert("请先填写手机号码");
                span.show();
            }
        });

        function submit(){
        
            $("#submit").click(function(){
                var set_code = $("input[name='set_code']").val();

                if(set_code==1){
                    var usertel = $("input[name='usertel']").val();
                    if(usertel==''){
                        alert("对不起绑定手机号不能空");
                        return false;
                    } 
                    var usercode = $("input[name='usercode']").val();
                    if(usercode==''){
                        alert("验证码不能空");
                        return false;
                    }
                } 
            });
        }
        submit();
        
});

