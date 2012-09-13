$(document).ready(function(){

        //根据分类
        $(".category").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipfavorites.php', {action:'category',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
            });
        });



        //根据推送用户
        $(".user_name").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipfavorites.php', {action:'user_name',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
            });
        });

        //跟踪记录
        $("#trac").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipfavorites.php', {action:'trac',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
                EditProductCollect();
            });
        });

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
        
        $("input[name=key]").focus(function(){
                $(this).val("");
        });

        page();
        function page(){
            $(".page a").click(function(){
                var p_page = $(this).attr('href');
                p_page = p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);
                $.get("services/vipfavorites.php",{action:"page", page:p_page},function(data){
                    var str = data.split('|');
                    $(".center").html(str['0']);
                    $(".fy").html(str['1']);
                    page();
                }); 
                return false;
            });
        }
});


