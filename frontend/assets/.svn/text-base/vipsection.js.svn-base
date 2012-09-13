$(document).ready(function(){

        $("#submit").click(function(){
        
            var value = $(this).attr('name');

            var user_id = $("input[name=user_id]").val();

            if(user_id==''){
            
                alert("对不起您不是登陆状态，不能推送商品，请先登陆！");

                location.href="/login?action=tijiao&id="+value;
            }else{ 

            
            $.get("vipsection",{action:'Complete'},function(data){

                  
                if(data==false){


                    alert("对不起您的资料还没完善，不能推送商品，请先完善资料！");
                    
                    location.href="registerSuccess?act=complete&id="+value;
                    
               
                } else {
                    
                    location.href="vipsupplystepone?id="+value;
                    
                }
                   
            });

            }

                return false;
        });
});
