$(document).ready(function(){
        vip();
        put();
        check();
        })


function vip(){

    //金牌渠道商   选择数目超过三个的时候提示
    $('.hyb input').click(function(){
            var n = $(".hyb input:checked").length;
            if (n>3){
                alert('对不起，金牌渠道商每款商品最多可选3家渠道商做推送');
                $(this).attr('checked',false);
            }
                });
    //一般渠道商 选择数目不超过五家
    $('.hyb1 input').click(function(){
            var n = $(".hyb1 input:checked").length;
            if (n>5){
                alert('对不起，该列表中，每款商品最多可选5家渠道商做推送');
                $(this).attr('checked',false);
            };
            })
    }

function put(){
    $('input[name=nextstep]').click(function(){
            var glod_n = $(".hyb input:checked").length;
            var coom_n = $(".hyb1 input:checked").length;
            if (glod_n>3){
                alert('对不起，金牌渠道商每款商品最多可选3家渠道商做推送');
                return false;
                }
            if (coom_n>5){
                alert('对不起，该列表中，每款商品最多可选5家渠道商做推送');
                return false;
                }
            //提交选择结果
            if(!$(this).attr('uid')){
                $('#case').show();
                return false;
                }
            else{
                var data = [];
                $('input[type=checkbox]:checked').each(function(){
                    data.push($(this).attr('uid'))
                    });
                //ajax提交结果
                $.get('',{'action':'selectqd','vips':$.toJSON(data),'pid':$('body').attr('pid')},function(data){
                    if (data.status){
                        location.href = data.url;
                    }
                    else{
                        return false;
                    }
                    },'json')
            } 
            })
    }

//没有匹配的时候显示没有匹配提示文字
function check(){
    if($('.hyb1 input').length==0){
        $('.hyb1 .notice').show()
        }
    if($('.hyb input').length==0){
        $('.hyb .notice').show()
        }
    //$('.four input[name=nextstep]').click(function{
     //       if(!(this).attr('uid')){
            //用户未登录的时候
       //     $('#npop').show();
         //   return false;
          //  }
    //   })
    }
