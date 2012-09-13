function ActiveDelTuan(){
        $('.deltuan').click(function(){
                var pid = $(this).attr('pid'); 
                var qid = $(this).attr('qid'); 
                $.ajax({
                    url:'/user/viewpullproduct',
                    data:{'action':'delpushtuan','pid':pid,'qid':qid},
                    type:'GET',
                    dateType:'json',
                    success:function(data){
                        if (data.status){
                        $(this).parent().hide();
                        }
                    }
                    })
                })
    }
//激活审核按钮
function ActiveCheckBottom(){
    //审核通过
    $('#agree').click(function(){
        var product = $(this).attr('product'); 
        $.ajax({
            url:'/user/viewpullproduct',
            data:{'action':'push','type':'agree','id':product},
            dataType:'json',
            type:'GET',
            success:function(data){
            if (data.status){
                $('.push_suggest_box').show();
            }
            else{
            }
            },
           }) 
        });
    //拒绝审核通过
    $('#deny').click(function(){
        var pid = $(this).attr('product');
    jPrompt('输入拒绝的理由','', '拒绝', function(r) {
            if(r){
               $.ajax({
                    url:'/user/viewpullproduct',
                    data:{'action':'push','type':'deny','id':pid,'msg':r},
                    dataType:'json',
                    type:'GET',
                    success:function(data){
                    if (data.status){
                       // $('.push_suggest_box').show();
                    }
                    else{
                    }
                    },
                    })   
                }
             else{
                jAlert('未输入任何理由，不能进行忽略操作！！')
                return false;
             }
            });
            })
}

$(document).ready(function(){
        ActiveDelTuan(); 
        ActiveCheckBottom();
        })
