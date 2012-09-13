$(document).ready(
        function(){
        FetchProduct(0,0);
        }
        )

function Active(){
        //激活左侧点击上一个商品
        $('#prev_product').click(
                function () {
                    FetchProduct($(this).attr('cursor'),-1) 
                    return false;
                }
                );
        $('#next_product').click(
                function () {
                    FetchProduct($(this).attr('cursor'),1) 
                    return false;
                    }
                );
        $('input[name=collect_1]').click(function(){
            $.ajax({    url:'/user/vipindex',
                        data:{'action':'collect','pid':$(this).attr('pid'),'uid':$(this).attr('uid'),'type':'1'},
                        type:'GET',
                        dataType:'json',
                        success:function(data){
                                alert('收藏成功！！！');
                                }
            });
        })
        $('input[name=collect_2]').click(function(){
            var me=$(this);
            jPrompt('忽略的理由:', '', '输入你的操作理由', function(r) {
                if (r=='' || !Boolean(r) || r=='理由'){
                jAlert('未输入任何理由，不能进行忽略操作！！')
                return false;
                }
                else{
                    $.ajax({    url:'/user/vipindex',
                            data:{'action':'collect','pid':me.attr('pid'),'uid':me.attr('uid'),'type':'2','ignore_msg':r},
                            type:'GET',
                            dataType:'json',
                            success:function(data){
                                    alert('已经忽略！！！');
                                    }
                    });
                }
            });
        });
        $('input[name=viewdetail]').click(function(){
            location.href=$(this).attr('rtf');
            return false;
            })
        //激活tooltip
      $('span.qualification').tooltip({
            delay: 0,
            showURL: false,
            bodyHandler: function () {
              var domain = location.href
              if (domain.match(/bak/)) {
                var tip_img_src = 'http://image2.101xd.com/' + $(this).attr('imgsrc');
              } else {
                var tip_img_src = 'http://image.101xd.com/' + $(this).attr('imgsrc');
              }
              return $("<img/>").attr("src", tip_img_src);
            }
          })
    }
//渲染数据到dom，显示动画效果
function RenderDataToDom(data,type){
    //$("#company").empty();
    var me = $('#companyinfo');
    var me_top = me.offset().top;
    var me_left = me.offset().left;
    //me.css('position','absolute').css('top',me_top).css('left',me_left);
    me.html($("#company").tmpl(data));
    //me.hide()
    //点击右侧的next的按钮的时候
    if (type==1)
    {
        me.animate({
            "marginLeft":'+100px'
        },100,function(){me.hide()});
        me.animate({
            "marginLeft":'-200px'
        },100,function(){me.show()});
        me.animate({
            "marginLeft":'0px'
        },800);
     }
     if (type==-1)
    {
        me.animate({
            "marginLeft":'-100px'
        },100,function(){me.hide()});
        me.animate({
            "marginLeft":'+200px'
        },100,function(){me.show()});
        me.animate({
            "marginLeft":'0px'
        },800);
     }

    //me.animate({width: 'toggle'});
    Active();
    }

//cursor为当前的游标，type传入1为next -1 为prev,返回vipproduct的关联数据
function FetchProduct(cursor,type){
        var res = ''
        //var cursor = 0;
        //var type = 0;
        //$('#prev_product').unbind('click');
        //$('#next_product').unbind('click');
        $.ajax({
            url:'/user/vipindex',
            type:'GET',
            dataType:'json',
            data:{'action':'fetchsuggestproduct','cursor':cursor,'type':type},
            success:function(data){
                RenderDataToDom(data,type);
                //res = data;
                }
            })
        return false;
        }
