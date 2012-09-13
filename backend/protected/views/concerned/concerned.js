$(document).ready(function(){
       
        //全选
        $('.concerned #all_select').click(function(){
            var value = $(this).attr("checked");
            $('.concerned input[type="checkbox"]').attr("checked",value);
            });
        
        $('.concerned #all_cancel').click(function(){
            var str_id = '';
            $('input[class="id"]').each(function(){
                var sta = $(this).attr("checked");
                if(sta) {
                    str_id = str_id + ($(this).val()) + '-';
                }
            });
            if(str_id.length>0) {
                str_id = str_id.substring(0,(str_id.length-1));
            }

            if(str_id.length==0) {
                jAlert('勾选后才能执行操作','需要勾选')
            } else {
                    jConfirm ('确认批量操作？','将要批量操作',function (r){
                
                    if (r){
                    $.getJSON('services/attention_publishers.php', {action:'all_ignore',type:'by',id:str_id}, function(data) {

                    if(data.result) {

                        var id_arr = str_id.split("-");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $("ul[id='"+id_arr[i]+"']").hide();
                        }

                        if(data.id==1){
                           $('.concerned .option .choice .global').before('<ul><li><div class="red">' + data.result + '</div></li></ul>');
                        }
                    }
                });}}) 
            }

            return false;
        });
        
        function ignore() {
            $('.concerned .ignore_id').click(function()
            {   var str_id=$(this).attr('rel');
                var a     =$(this);
                jConfirm('取消忽略','取消忽略？',function(r)
                {
                if (r)
                {
                
                $.getJSON('services/attention_publishers.php', 
                            {action:'cancel_ignore', id:str_id}, 
                            function(data) {
                                if(data.result) {
                                var rel = $('#release .choice').attr('rel');
                                if('quan'==rel) {
                                    a.attr('class', 'cancel_id');
                                    a.html('忽略');
                                    cancel();
                                } else {
                                    $("#"+str_id).hide();
                                }
                             }                           
                         }); 
                }
                });return false;
            })}

        ignore();
        function cancel() {
            $('.concerned .cancel_id').click(function(){
                var a     =$(this);
                var str_id=a.attr('rel');
                jConfirm('在当前列表移除，点击查看全部仍可见','确认？', function(r){
                    if(r){
                        $.getJSON('services/attention_publishers.php', {action:'all_ignore',type:'by',id:str_id}, function(data) {
                        if(data.result) {
                            var rel = $('#release .choice').attr('rel');
                            if('quan'==rel) { 
                                a.attr('class', 'ignore_id');
                                a.html('取消忽略');
                                ignore();
                            } else {
                                $("#"+str_id).hide();
                            }
                        }
                    }); 
                }
                });return false;
            });
        } 
        cancel();
        
});

