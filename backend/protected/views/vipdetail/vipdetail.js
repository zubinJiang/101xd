$(document).ready(function(){
       Activecollect();
       AddTip();
        })

function Activecollect(){
    $('input[ct=cl]').click(function(){
            var vid = $(this).attr('vid');
            var uid = $(this).attr('uid');
            var pid = $(this).attr('pid');
            var url='/user/vipindex';
            if(vid==2){
                jPrompt('输入拒绝的理由','', '拒绝', function(r) {
                    if(r!='' && r!=null){
                        var msg=r;
                        $.get(url,{'action':'collect','type':vid,'pid':pid,'uid':uid,'ingore_msg':msg},function(data){
                            SwithInput(vid); 
                        },'json')

                    }else{
                        jAlert('未输入任何理由，不能进行忽略操作！！');
                        return false;
                    
                    }
                })
            }else{
                var msg='';
                $.get(url,{'action':'collect','type':vid,'pid':pid,'uid':uid,'ingore_msg':msg},function(data){
                    SwithInput(vid); 
                },'json')
            };
    });
}
function SwithInput(vid){
    var s=[1,2,3];
    $('input[ct=cl]').show();
    var Q="input[vid="+vid+"]";
    $(Q).hide();
    }
function AddTip(){
    $('#qualification p').tooltip({
                delay: 0,
                showURL: false,
                bodyHandler: function () {
                            var domain = location.href
                            if (domain.match(/bak/)){
                                var tip_img_src = 'http://image2.101xd.com/'+$(this).attr('imgsrc'); 
                            }
                            else{
                                var tip_img_src = 'http://image.101xd.com/'+$(this).attr('imgsrc'); 
                                }
                            return $("<img/>").attr("src", tip_img_src);
                            }
                })
    }
