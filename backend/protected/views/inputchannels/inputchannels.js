function get_random_suggs(v){ 
   var a=[];
   var names = ['_first','_second','_third','_forth','_fifth'];
   for(var i=0;i<names.length;i++) {
     a.push({id:i, value:v+names[i], info:i, extra:"extra fields remains!" });
   }
   return a;
}
function print_sugg(obj){ 
  //$(this).attr('value',obj.value); 
}

//ajax获取联想建议
function get_look_suggs(key,cont){ 
   var script_name = '/user/inputchannels';
   var params = { 'q':key }
   $.get(script_name,params,
         function(obj){ 
           // obj is just array of strings
           var res = [];
           for(var i=0;i<obj.length;i++){
             res.push({ id:i , value:obj[i]});
           }
           // will build suggestions list
           cont(res); 
         },
         'json');
}




function AutoSuggest(elem){
    //elem is a jquery obj
    $(elem).autocomplete({ ajax_get : get_look_suggs, 
                                       callback: print_sugg,
                                       minchars:1,
                                       multi: true});
}

function AjaxAllPut(){
    // elem is a jquery obj
    var data = [];
    $('input[name=username]').each(function(){
            data.push($(this).attr('value'));
            })
    $.ajax({    url:'/user/inputchannels',
                type:'GET',
                data:{'action':'addvippage','users':$.toJSON(data)},
                dataType:'json',
                success:function(data){
                    jAlert('数据已保存!')
                   $('#notice').text(data.msg); 
                    }
            })
} 

function checkuser(elem){
    $(elem).blur(function(){
           var username = $(this).attr('value');
           //延时执行一下，否则和自动建议的有冲突
           setTimeout(function(){
           $.get('inputchannels',{'action':'checkuser','username':username},function(data){
                if(data.status){
                }
                else{
                jAlert('输入的用户名不是会员名','请确认输入的用户名')
                }
               },'json')
           },200)
           //---延时结束---
            })
    }
//在autosuggest的callback function
function checkuser_after_autosuggest(obj){
           var username = obj.value;
           //延时执行一下，否则和自动建议的有冲突
           setTimeout(function(){
           $.get('inputchannels',{'action':'checkuser','username':username},function(data){
                if(data.status){
                }
                else{
                jAlert('输入的用户名不是渠道商名','请确认输入的用户名')
                }
               },'json')
           },800)
           //---延时结束---
        }


$(document).ready(function(){
    $('#add').click(function(){
        var last_input = $(this).parent().parent().find('input[name=username]:last');
        var index = parseInt($(last_input).attr('index'))+1;
        var html = '<p>请输入需开通专页的渠道商会员名：<input name=\"username\" id=\"input_'+index+'\" index=\"'+index+'\"><span onclick="$(this).parent().remove()">&ensp;删除</span></p>';
        $(last_input).parent().after(html);
        var last_elem = $('input[index]:last');
        //var next = $(last_input).parent().next();
        //AutoSuggest(last_elem);
        checkuser(last_elem);
        return false;
        });
    var dd = $('input[name=username]:first')
    //AutoSuggest(dd);
    checkuser(dd);
    $('#save').click(function(){
         AjaxAllPut();
         return false;
        })
});
