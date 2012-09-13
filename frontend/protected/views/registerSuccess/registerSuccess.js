$(document).ready(function(){

       var wrongleft = "<img src='../../../images/smallwrong.gif' width='14' height='14' ><font style='color:red;line-height:14px;'>"; 
       var wrongright = "</font>";
       var imgringt = "<img src='../../../images/smallright.gif'>";

       $('.province_id').change(function(){
            var str_id = $(this).val();
            $.get('services/register.php',{action:'getarea', id:str_id},function(data){
                $('.area_id').html(data);
                $("#area_mess").html(imgringt);
            });
       });
       //产品关键字每个最多5个汉字
       $("#input[name=key]").each(function(){
           var value = $(this).val();
           if(value.length>5){
                return false;
           }
       });

       function validateInput(name, msg) {
           $('input[name="'+name+'"]').blur(function(){
                var value = $(this).val();       
                if (!value) {
                    //$(this).next().html(wrongleft+msg+wrongright);
                } else {
                    $(this).next().html(imgringt);
                }
           });
       }

       validateInput('add_text', '');
       validateInput('contact_name', '');
       validateInput('cag_text', '');
       validateInput('postcode', '');
       validateInput('contact_tel', '');
       validateInput('QQ', '');
       validateInput('youbian', '');
       validateInput('gro_url', '');
       validateInput('com_desc', '');
       validateInput('position', '');

       $(".gj").click(function(){
    
            var value = $(this).attr('value');

            if(value){
                $("#key_tishi").html("").hide();
                $("#key_mess").html(imgringt);
            }

       });

       $("#com_desc").click(function(){
    
            //var value = document.getElementById("com_desc").value;
            var value = $(this).val();
            if(value){
                $("#com_desc_mess").html(imgringt);
            }
       });

       $("#category").change(function(){
            $("#category_tishi").html("").hide();
            $("#category_mess").html(imgringt);
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
});

