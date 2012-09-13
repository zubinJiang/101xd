$(document).ready(function(){
        commentPage();
        function commentPage(){
            $('#verbal .comment a.pagelist').click(function(){
                var website_id = $('#verbal #website_id').val();
                var page_url   = $(this).attr('href');
                target         = page_url.substring(page_url.lastIndexOf('page=')+5, page_url.length);

                $.get('services/commentpage.php', {action:'comment', id: website_id, page: target},function(data){
                    
                    $('#verbal .comment').html(data);
                    commentPage();
                    return false;
                });
                return false;
            });
        }


        // 商品名称
        $('#verbal #comment_form input[name="product_name"]').bind({
        'keydown':function(){
            $('#verbal #comment_form textarea').val('购买商品名称：' + $(this).val());
        },
        'keyup':function(){
            $('#verbal #comment_form textarea').val('购买商品名称：' + $(this).val());
        }
        })

        function commentCon(desc, rate) {
            var text = $('#verbal #comment_form textarea');
            var value= text.val();
            var comment;
            if(rate==5) {
                comment='非常好';
            } else if(rate==4) {
                comment='好';
            } else if(rate==3) {
                comment='一般';
            } else if(rate==2) {
                comment='还行';
            } else {
                comment='很差';
            }
            text.val(value + '\r\n'+desc+'：'+comment+'('+rate+'分) ');

            if(rate==1) {
                $('#verbal #comment_form .reason').show();  // div
                $('#verbal #comment_form #reason').focus();  // input 
                requireField();
            }
        }

        function requireField() {
            $('#verbal #comment_form #reason').focusout(function(){
                var text = $(this).val();
                if(text.length==0) {
                    alert('补充理由必须填写！');
                    $(this).focus();
                }
            });
        }

        $('#verbal #comment_form #unit_quality a').click(function(){
            var title = $('#verbal #comment_form input[name="product_name"]').val();
            if(title.length<=0) {
                $('#verbal #comment_form input[name="product_name"]').next().text('评分前，请先填写购买商品的名称！');
                return false;
            }
            var rate = $(this).text();
            rate     = parseInt(rate);
            $('#verbal #comment_form .product_quality').val(rate);
            $('#verbal #comment_form .show_quality').html('&nbsp;' + rate + '分&nbsp;');

            commentCon('商品质量', rate);

            $('#verbal .item ul').css('height',"17px");
            $('#verbal #comment_form #unit_quality').html('<li class="current-rating" style="width:'+(rate*17)+'px;left:0;top:0;">Currently.0.00/5</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li>');

            return false;
        });

        $('#verbal #comment_form #unit_services a').click(function(){
            var title = $('#verbal #comment_form input[name="product_name"]').val();
            if(title.length<=0) {
                $('#verbal #comment_form input[name="product_name"]').next().text('评分前，请先填写购买商品的名称！');
                return false;
            }
            var rate = $(this).text();
            rate     = parseInt(rate);
            $('#verbal #comment_form .after_services').val(rate);
            $('#verbal #comment_form .show_services').html('&nbsp;' + rate + '分&nbsp;');

            commentCon('售后服务', rate);
            
            $('#verbal #comment_form #unit_services').html('<li class="current-rating" style="width:'+(rate*17)+'px;left:0;top:0;">Currently.0.00/5</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li>');

            return false;
        });
        
        $('#verbal #comment_form #unit_price a').click(function(){
            var title = $('#verbal #comment_form input[name="product_name"]').val();
            if(title.length<=0) {
                $('#verbal #comment_form input[name="product_name"]').next().text('评分前，请先填写购买商品的名称！');
                return false;
            }
            var rate = $(this).text();
            rate     = parseInt(rate);
            $('#verbal #comment_form .product_price').val(rate);
            $('#verbal #comment_form .show_price').html('&nbsp;' + rate + '分&nbsp;');

            commentCon('商品价格', rate);
            
            $('#verbal #comment_form #unit_price').html('<li class="current-rating" style="width:'+(rate*17)+'px;left:0;top:0;">Currently.0.00/5</li><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li>');

            return false;
        });

        $('#verbal .present #comment_submit').click(function(){
            var title = $('#verbal #comment_form input[name="product_name"]').val();
            if(title.length==0) {
                alert('请填写您购买的商品的名称！');
                return false;
            }
                
            var p_services= $('#verbal #comment_form .after_services').val();
            var p_quality = $('#verbal #comment_form .product_quality').val();
            var p_price   = $('#verbal #comment_form .product_price').val();
            var p_reason  = $('#verbal #reason').val();
            var w_id      = $('#verbal .present #comment_submit').attr('class');

            if(parseInt(p_services)==1 || parseInt(p_quality)==1 || parseInt(p_price)==1) {
                if(p_reason.length==0) {
                    alert('请填写补充理由后再发布评论！');
                    return false;
                }
            }

            var t_niming = $('#verbal .niming').attr("checked")
            var p_niming = 0;
            if(t_niming) { p_niming = 1; }

$.getJSON('services/detailcomment.php', {action:'comment',name:title,quality:p_quality,services:p_services,price:p_price,reason:p_reason,niming:p_niming,wid:w_id}, function(data){ 

                if(data.id==1) {
                    $('#verbal #comment_form .after_services').val(2);
                    $('#verbal #comment_form .product_quality').val(2);
                    $('#verbal #comment_form .product_price').val(2);
                    $('#verbal #reason').val('');
                    $('#verbal #comment_form input[name="product_name"]').val('');

                    var html = '<li class="current-rating" style="width:34px;left:0px;height:17px;">Currently.0.00/5</li><li><a href="javascript:void(0);" title="很拆 1分" class="r-5-unit rater">1</a></li><li><a href="javascript:void(0);" title="还行 2分" class="r-4-unit rater">2</a></li><li><a href="javascript:void(0);" title="一般 3分" class="r-3-unit rater">3</a></li><li><a href="javascript:void(0);" title="好 4分" class="r-2-unit rater">4</a></li><li><a href="javascript:void(0);" title="非常好 5分" class="r-1-unit rater">5</a></li>';

                    $('#verbal #comment_form textarea[name="text_show"]').val('');
                    $('#verbal #comment_form #unit_price').html(html);
                    $('#verbal #comment_form #unit_services').html(html);
                    $('#verbal #comment_form #unit_quality').html(html);

                    var website_id = $('#verbal #website_id').val();
                    $.get('services/commentpage.php', {action:'comment', id: website_id},function(data){
                        $('#verbal .comment').html(data);
                        commentPage();
                        return false;
                    });
                } else {
                    alert(data.result);
                }
            });
            return false;
        });
});
