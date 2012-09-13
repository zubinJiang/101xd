//激活推送渠道商的建议输入
function ActivePushSuggest(){
$('input[name=addpush]').blur(function(){
        $(this).attr('value','');
        })

}

//删除当前商品的推荐到的渠道商
function DelPushTuan(elem){
    var hand = $(elem);
    var company_id = hand.attr('company');
    var product_id = hand.attr('product');
    $.ajax({
            url:'/user/viewpullproduct',
            data:{action:'delpush',product:product_id,company:company_id},
            dataType:'json',
            type:'GET',
            success:function(data){
                hand.parent().hide();
            }
            });
    hand.parent().hide();
    }

//获取渠道商的需要的资质证明
function Certifications(){
    $('.tuan_name').mouseover(function(){
        var id_ = $(this).attr('vcid');
        $.ajax({url:'user/viewpullproduct',
            data:{'action':'certifications','id':id_},
            dataType:'json',
            type:'GET',
            success:function(data){
                //$( "#company").empty();
                var html=$( "#company").tmpl(data) // Render the template with the movies data
                $( "#companyinfo" ).html(html);
                }
            })
    })
    }
function PutAll(){
    $('button[name=agree]').click(function(){
          $('.push_suggest_tuanname').each(function(){
              var p_name = $(this).attr('p_name');
              $.get('services/pushManagement.php', {action:'process', state:"1", id:$(this).attr('pid'), title:$(this).attr('title'), name:$(this).attr('p_name'), uid:$(this).attr('uid')}, function(data) {
                  if (data==1){
                  var msg = '推送到'+p_name+'成功';
                  alert(msg);
                  }
                  else{
                  var msg = p_name+'已经推送';
                  alert(msg);
                  }
                  },'html')
              });
          $('input[name=pushto]:checked').each(function(){
              var p_name = $(this).attr('p_name');
              $.get('services/pushManagement.php', {action:'process', state:"1", id:$(this).attr('pid'), title:$(this).attr('title'), name:$(this).attr('p_name'), uid:$(this).attr('uid')}, function(data) {
                  if (data==1){
                  var msg = '推送到'+p_name+'成功';
                  alert(msg);
                  }
                  else{
                  var msg = p_name+'已经推送';
                  alert(msg);
                  }
                  },'html')
              });
            return false;
            });
    $('button[name=pass]').click(function(){
              $('.push_suggest_box').hide();
              return false;
            });
    $('button[name=deny]').click(function(){
              $('.push_suggest_tuanname').each(function(){
              var p_name = $(this).attr('p_name');
              $.get('services/pushManagement.php', {action:'process', state:"2", id:$(this).attr('pid'), title:$(this).attr('title'), name:$(this).attr('p_name'), uid:$(this).attr('uid')}, function(data) {
                      if (data==1){
                      var msg = '拒绝推送到'+p_name+'操作成功';
                      alert(msg);
                      }
                      else{
                      var msg = p_name+'已经拒绝';
                      alert(msg);
                      } 
                      },'html')
              });
            return false;
            });
    }
$(document).ready(function(){
        Certifications();
        PutAll();
        })
