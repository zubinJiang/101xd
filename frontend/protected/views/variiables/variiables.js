$(document).ready(function(){
            
        $('.dealer ol li a').click(function(){
            $('.dealer ol li a').removeClass('local');
            $(this).addClass('local');
            var id = $(this).attr('id');
            $('.dealer .qudao').hide();
            $('.dealer .gongying').hide();
            $('.dealer .' + id).show();
            return false;
        });
        
        $('#variiables .irreversible .marquee ').Scroll({line:2,speed:500,timer:3000});

});
