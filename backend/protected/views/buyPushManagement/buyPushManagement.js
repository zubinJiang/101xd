$(document).ready(function(){
        
        //全选
        $('#all_select').click(function(){
            var value = $(this).attr("checked");
            $('input[type="checkbox"]').each(function(){
                $(this).attr("checked", value);
            });
        });

        //删除
        $(".delete_id").click(function(){
            var p_id = $(this).attr('id');
            jConfirm('确认删除？','确认删除？',function (r){
                if(r){
                    $.getJSON('services/buyPushManagement.php', {id:p_id}, function(data) {
                        if(data){
                            $(".obj_"+p_id).hide();
                            alert("删除成功");
                        } else {
                            alert("删除失败");
                        }
                    });   
                }
            });
        });

        // 获取选中状态id
        function getCheckValue() {
            var str_id = '';
            $('input[name="checkbox"]').each(function(){
                var sta = $(this).attr("checked");
                if(sta) {
                    str_id = str_id + ($(this).val()) + ',';
                }
            });
            if(str_id.length>0) {
                str_id = str_id.substring(0,(str_id.length-1));
            }
            return str_id;
        }

        //批量删除
        $('#delete').click(function(){
            var str_id = getCheckValue();
            if(str_id.length==0) {
                jAlert('勾选后才能执行操作。')
            } else {
                jConfirm('确认删除？','确认删除？',function (r){
                if (r){
                $.getJSON('services/buyPushManagement.php', {action:'all_delete',id:str_id}, function(data) {
                    if(data) {
                        var id_arr = str_id.split(",");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $('.obj_'+id_arr[i]).hide();
                        }
                    }
                }); 
            }})}
            return false;
        });
        
});
