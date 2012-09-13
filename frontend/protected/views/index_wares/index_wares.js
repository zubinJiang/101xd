$(document).ready(function(){
        
        $('#wares .wares_c li > a').click(function(){
            var a_type = $(this).attr('rel');

            if(a_type=='1') {
                $('#wares .hd ul li a[rel="0"]').html('最新更新商品');
                $(this).html('<img src="images/pic_6.gif" width="180" height="19" />');
            } else {
                $('#wares .hd ul li a[rel="1"]').html('最受关注商品');
                $(this).html('<img src="images/pic_5.gif" width="180" height="19" />');
            }

            $.get('services/index.php',{type:a_type},function(data){
                $('#wares .wares_c .fd').html(data);
            });
            
            return false;
        });
});
