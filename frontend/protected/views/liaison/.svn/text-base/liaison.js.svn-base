$(document).ready(function(){
    guanzhu();
    function guanzhu() {
        $('#liaison button[class="guanzhu"]').click(function(){
            var publish_id = $(this).attr('rel');
            var product_id = $(this).attr('name');
            $('input[name="publishid"]').val(publish_id);

            $.getJSON('services/loginvalidate.php', {action:'validate', publish:publish_id, product:product_id},function(data) {
                if(data.id==3) {
                    var res = data.result;
                    var res_arr = res.split('|');
                    $('#liaison .innocuous').html(res_arr[0]);
                    $('#liaison .attentions').html('商家人气：' + res_arr[1]);
                } else {
                    $wp = $('.pop');
                    $wp.css('z-index','1000');
                    var lf = (parseInt(screen.width)-parseInt(400))/2;
                    var lfc = lf/parseInt(screen.width)*100+'%';
                    $wp.css('left',lfc);
                    $wp.css('top','80');
                    $('.pop').show();
                }
            });
        });
    }

    $('.pop #case #close').click(function(){
        $('.pop').hide();
        return false;
    });
});
