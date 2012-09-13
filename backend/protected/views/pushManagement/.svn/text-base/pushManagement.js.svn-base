$(document).ready(function(){

        //根据分类
        $(".category").change(function(){
        
            var str_id = $(this).attr("value");

            $.get('services/pushManagement.php', {action:'category',id:str_id}, function(data) {

                var str = data.split("|");

                $(".center").html(str['0']);

                $(".page").html(str['1']);
                page();
                refuse();
                pass();
            });
        });



        //根据推送用户
        $(".user_name").change(function(){
        
            var str_id = $(this).attr("value");

            $.get('services/pushManagement.php', {action:'user_name',id:str_id}, function(data) {

                var str = data.split("|");

                $(".center").html(str['0']);

                $(".page").html(str['1']);
                page();
                refuse();
                pass();
            });
        });

        //根据省份ID获取地区List 
        function get_area_by_province_id() {
            $('.province_id').change(function(){
                var str_id = $(this).val();
                $.get('services/goldroll.php',{action:'get', id:str_id},function(data){
                    $('.area_id').html(data);
                    page();
                    refuse();
                    pass();
                })
            });
        
        }

        get_area_by_province_id();

        
        $("input[name=key]").focus(function(){
        
                $(this).val("");
                
        });

        pass();
        function pass(){
        //通过
        $(".pass").click(function(){
        
            var str_id = $(this).attr("value");

            var p_title = $(this).attr("title");

            var p_name = $(this).attr("name");

            var p_uid = $(this).attr("id");

            jConfirm('确认通过？','确认通过？',function (r){

                if(r){

                    $.get('services/pushManagement.php', {action:'process', state:"1", id:str_id, title:p_title, name:p_name, uid:p_uid}, function(data) {

                        
                        if(data){
                            $("#auth_"+str_id).html("审核通过");
                            alert("审核通过成功");
                        } else {
                            alert("审核通过失败");
                        }
                    });
                }

            });
            return false;
        });
        }

        refuse();
        function refuse(){
        //拒绝
        $(".refuse").click(function(){

            var str_id = $(this).attr("value");

            var p_title = $(this).attr("title");

            var p_name = $(this).attr("name");

            var p_uid = $(this).attr("id");

            jPrompt('拒绝的理由:', '', '输入你的操作理由', function(r) {
                if(r=='' || r.length<3){
                    jAlert('输入理由长度不能少于3个字符！')
                    return false;
                }else{
                    
                    $.get('services/pushManagement.php', {action:'process', state:"2", id:str_id, msg:r, title:p_title, name:p_name, uid:p_uid}, function(data) {
                        if(data){
                            alert("拒绝成功");
                            $("#auth_"+str_id).html("拒绝");
                        } else {
                            alert("拒绝失败");

                        }

                    });
                }
            });
            return false;
        });

        }
        page();
        function page(){
            $(".page a").click(function(){
                var p_page = $(this).attr('href');
                p_page = p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);

                $.get("services/pushManagement.php",{action:"page", page:p_page},function(data){

                    var str = data.split('|');

                    $(".center").html(str['0']);

                    $(".page").html(str['1']);

                    page();
                    refuse();
                    pass();

                }); 
                return false;
            });
        }
});
