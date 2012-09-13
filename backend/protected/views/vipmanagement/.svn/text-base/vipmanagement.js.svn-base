$(document).ready(function(){

        //根据分类
        $(".category").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipmanagement.php', {action:'category',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
                EditProductCollect();
            });
        });

        //根据推送用户
        $(".user_name").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipmanagement.php', {action:'user_name',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
                EditProductCollect();
            });
        });

        //跟踪记录
        $("#trac").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipmanagement.php', {action:'trac',id:str_id}, function(data) {
                var str = data.split("|");
                $(".center").html(str['0']);
                $(".fy").html(str['1']);
                page();
                EditProductCollect();
            });
        });

        //商品状态
        $("#collect").change(function(){
            var str_id = $(this).attr("value");
            $.get('services/vipmanagement.php', {action:'collect',id:str_id}, function(data) {
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

        
        $("input[name=keyworde]").focus(function(){
                $(this).val("");
        });

        page();
        function page(){
            $(".page a").click(function(){
                var p_page = $(this).attr('href');
                p_page = p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);
                $.get("services/vipmanagement.php",{action:"page", page:p_page},function(data){
                    var str = data.split('|');
                    $(".center").html(str['0']);
                    $(".fy").html(str['1']);
                    page();
                    EditProductCollect();
                }); 
                return false;
            });
        }

        function EditProductCollect(){
            $('.default_trac_edit').click(function(){
                var default_trac = $(this).parent();
                var edit_trac = default_trac.next();
                default_trac.hide();
                edit_trac.show();
                edit_trac.find('.edit_trac_save').click(function(){
                    default_trac.show();
                    edit_trac.hide();
                    var select_value = edit_trac.find('.edit_trac_select option:selected').attr('value');
                    var pid = $(this).attr('pid');
                    $.get('/',{},function(data){
                        default_trac.show();
                        edit_trac.hide();
                        },'json')
                    })
            })
       }
       EditProductCollect();

       //update 跟踪记录
       $(".edit_trac_save").click(function(){
            var p_id = $(this).attr('value');
            var p_trac = $(".edit_trac_select_"+p_id).val();
            $.get('services/vipmanagement.php', {action:'set_trac',id:p_id, trac:p_trac}, function(data){
                if(p_trac=='1'){ $(".trac_data_"+p_id).html("跟踪中"); }
                if(p_trac=='2'){ $(".trac_data_"+p_id).html("已签合同"); }
                if(p_trac=='3'){ $(".trac_data_"+p_id).html("已上团"); }
                if(p_trac=='4'){ $(".trac_data_"+p_id).html("其它"); }
            })
       });

       
});
