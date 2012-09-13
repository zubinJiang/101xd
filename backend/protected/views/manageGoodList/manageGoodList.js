$(document).ready(function(){
        del();
        // 获取选中状态id
        function getCheckValue() {

            var str_id = '';
            $('li[class="checkbox"] input[class="checkbox"]').each(function(){
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

        // 过期
        $('#expired').click(function(){
            
            var str_id = getCheckValue();
            if(str_id.length==0) {
               jAlert('确定？','请勾选后才能执行操作。')
            } else {
                $.getJSON('services/batch_manage_product.php', {action:'all_expired',id:str_id}, function(data) {
                    if(data.result) {
                        //alert('操作成功。')
                        var id_arr = str_id.split(",");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $('ul[id="'+id_arr[i]+'"]').hide();
                        }
                    }
                }); 
            }
        });

        //批量重发
        $('#republish').click(function(){
            
            var str_id = getCheckValue();
            if(str_id.length==0) {
                jAlert('确认？','勾选后才能执行操作。')
            } else {
                $.getJSON('services/batch_manage_product.php', {action:'all_again',id:str_id}, function(data) {
                    if(data.result) {
                        jAlert('确认？','重发信息成功。')
                    }
                }); 
            }
        });

        //批量删除
        $('#delete').click(function(){
            var str_id = getCheckValue();
            if(str_id.length==0) {
                jAlert('勾选后才能执行操作。')
            } else {
                jConfirm('确认删除？','确认删除？',function (r){
                if (r){
                $.getJSON('services/batch_manage_product.php', {action:'all_delete',id:str_id}, function(data) {
                    if(data.result) {
                        var id_arr = str_id.split(",");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $('ul[id="'+id_arr[i]+'"]').hide();
                        }
                    }
                }); 
            }})}
            return false;
        });

        //全选
        $('#all_select').click(function(){
            var value = $(this).attr("checked");
            $('#manageGoodList input[type="checkbox"]').each(function(){
                $(this).attr("checked", value);
            });
        });
        
        //删除
        function del(){
        $('a.delete_id').each(
                function(){
            $(this).click(function(){
            var str_id=$(this).attr('rel');
            jConfirm('确认删除？','确认删除？',function (r){
                if (r){
                    $.getJSON('services/manage_product.php', {action:'delete',id:str_id}, function(data) {
                    if(data.result) {
                        $('ul[id="'+str_id+'"]').hide();
                            }       
                        }); 
                    }
                
                })

         return false;
        });})}

        //重发
        $('#manageGoodList #again_id').click(function(){
            var str_id=$(this).attr('rel');

            $.getJSON('services/manage_product.php', {action:'again',id:str_id}, function(data) {
                if(data.result) {
                    jAlert('确认？','重发成功');
                }
            }); 

            return false;
        });

        function change_num() {

            var this_font = $('#manageGoodList ol a.shop font');  //自减 小数字
            var this_num  = this_font.text();
            var the_num = (parseInt(this_num)-1)>0 ? (parseInt(this_num)-1) : 0;
            this_font.text(the_num);

            var tips  = $('#manageGoodList .material font'); // 提示语
            tips.text(the_num);
        }
        
        //下架
        shelf();
        function shelf() {
            $('#manageGoodList #shelf_id').click(function(){
                var str_id=$(this).attr('rel');
                jConfirm('确认将商品下架？','确认下架？',function (r){
                if (r){
                    $.getJSON('services/manage_product.php', {action:'shelf',id:str_id}, function(data) {
                        if(data.result) {
                            $('ul[id="'+str_id+'"]').hide();
                            change_num();
                            var font = $('#manageGoodList ol #xiajia font');// 下架数据
                            var num  = font.text();
                            font.text(parseInt(num)+1);
                        }
                    }); 
                }
                });
                return false;
            });
        }

        //上架
        $('#manageGoodList a.shelves_id').click(function(){
            var this_a = $(this);
            var str_id = this_a.attr('rel');
            jConfirm('确认将商品上架？','确认上架？',function (r){
                if (r){
                    $.getJSON('services/manage_product.php', {action:'shelves',id:str_id}, function(data) {
                        if(data.result) {

                            $('ul[id="'+str_id+'"]').hide();

                            change_num();

                            var font = $('#manageGoodList ol #fabu font');// 发布上网数据
                            var num  = font.text();
                            font.text(parseInt(num)+1);
                        }
                    }); 
                }
            });
            return false;
        });
});
