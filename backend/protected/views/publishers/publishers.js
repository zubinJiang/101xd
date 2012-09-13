$(document).ready(function(){
        
        //全选
        $('#publishers #all_select').click(function(){
            var value = $(this).attr("checked");
            $('#publishers input[type="checkbox"]').each(function(){
                $(this).attr("checked", value);
            });
        });
        
        $('#publishers #all_cancel').click(function(){
            
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
                jAlert('勾选后才能批量取消关注。')
            } else {
                    jConfirm('将要批量删除','确认？',function (r) {
                    if (r){
                    $.getJSON('services/attention_publishers.php', {action:'all_cancel',id:str_id}, function(data) {
                    if(data.result) {
                        $('#publishers #release .material font').html(data.count);

                        var id_arr = str_id.split("-");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $('#'+id_arr[i]).hide();
                        }

                        if(data.id==1){
                           $('#publishers .option .choice .global').before('<ul><li><div class="red">' + data.result + '</div></li></ul>');
                        }
                    }
                }); 
            
            }})}
            
            return false;
        });
        
        $('#publishers #cancel_id').click(function(){
            
            var str_id=$(this).attr('ref');
            jConfirm('取消关注','确认取消关注？',function (r){
            if (r){
            $.getJSON('services/attention_publishers.php', {action:'cancel',id:str_id}, function(data) {
                if(data.result) {
                    $('#publishers #release .material font').html(data.count);
                    $('#'+str_id).hide();
                }
            }); 
            }});return false;
        });
})
