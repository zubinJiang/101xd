$(document).ready(function(){

        //删除
        $('#role .delete_id').click(function(){
            var str_id=$(this).attr('href');

            $.getJSON('services/manageRole.php', {action:'del',id:str_id}, function(data) {
                if(data.result==0) {
                    alert('您还没有登录');
                } else if(data.result==2) {
                    alert('您没有权限删除');
                } else if(data.result==3) {
                    alert('此角色目前正有用户使用，不能删除');
                } else if(data.result==1) {
                    $('ul[id="'+str_id+'"]').hide();
                }
            }); 

            return false;
        });
        
        
})
