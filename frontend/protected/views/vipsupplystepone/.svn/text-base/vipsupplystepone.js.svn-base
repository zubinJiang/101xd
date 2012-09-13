function ShowErrorMessage(){
   $('#case').modal(); 
}


$(document).ready(
        function(){
        //是否选择推广
        $('input[name=ad][value=1]').bind('click',function (){
            //$('.ft').slideDown(1000);
            $('.ft').show();
            $('.three').css('height','200px');
            $('.three .et').css('height','192px');
            });
        $('input[name=ad][value=0]').bind('click',function (){
            //$('.ft').slideUp(1000);
            $('.ft').hide();
            $('.three').css('height','80px');
            $('.three .et').css('height','80px');
            });
        //根据9.23产品部文档加上的广告位预览
        //http://goo.gl/dCP81
        //使用jquery tooltip 插件
        $('input[type=checkbox]:lt(4)').tooltip({ 
                delay: 0, 
                showURL: false, 
                bodyHandler: function() {
                        var tip_img_src = '/images/supply_tip_img_'+$(this).attr('value')+'.jpg';
                        return $("<img/>").attr("src", tip_img_src); 
                                } 
                    });
        $('input[type=checkbox]:lt(4)').parent().next().tooltip({ 
                delay: 0, 
                showURL: false, 
                bodyHandler: function() {
                        var tip_img_src = '/images/supply_tip_img_'+$(this).prev().find('input').attr('value')+'.jpg';
                        return $("<img/>").attr("src", tip_img_src); 
                                } 
                    });
        //提交推送
        $('input[name=submit]').click(function(){
                        //alert($('form').serialize());
                        var category = $('input[name=category_id]:checked') ;
                        var delivery = $('input[name=delivery]:checked');
                        var ad_1 = $('input[name=ad]:first:checked');
                        var ad_0 = $('input[name=ad]:last:checked');
                        //check_box的php处理中需要在后面加上[],故而此处不用[name=ad_position]
                        var ad_position = $('input[type=checkbox]:checked');
                        var ad_period = $('input[name=ad_period]:checked');
                        //判断是否有选择项没有选择弹出统一的提示信息
                        if (
                            category.length == 0 ||
                            delivery.length == 0 ||
                            (
                            ((ad_1.length == 1 && (ad_position.length == 0 || ad_period.length == 0)) && ad_0.length ==0 ) || 
                            (ad_1.length == 0 && ad_0.length==0 ) 
                            )
                           )
                        {
                        $('#case').show();
                        //xhr.abort();
                        //此处ajax只是防止跳转，不ajax的话 return false还是会跳转
                        $.ajax({url:'/vipsupplystepone',
                                dataType:'json',
                                type:'POST',
                                data:$('form').serialize(),
                                success:function(){
                                //$('#case').show();
                                }})
                        return false;
                        };
                        //如果form信息符合要求后台会重定向不需要else处理
            }); 
        
        
        
        
        }
        
        
        
        
        
        )
