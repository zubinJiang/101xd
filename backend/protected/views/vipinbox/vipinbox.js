/*收件箱的js部分
 * 这部分的js有点混乱
 *
 */

$(document).ready(function(){
       // alert('jquery load ok');
        FoldContext();
        bindinput() 
        });

function bindinput() {$('#selectall').click(function () {if ($('#selectall').attr('checked')==true){$(':input').attr('checked',false);}else if ($('#selectall').attr('checked')==false){$(':input').attr('checked',true);}});}

function  DelMessage (message_id){
                $.ajax({
                            url: 'vipinbox?action=del&id='+message_id,
                            dataType: "json",
                            success: function(data) {
                                    var qs='.explain[msgid='+message_id+']';
                                    $(qs).slideUp();
                                    var all=data.all;
                                    var unread=data.unread;
                                    $('#msg_notice_all').text(all);
                                    $('#msg_notice_unread').text(unread);
                                    }
                                }); 
            }
            
function  ReadMessage (message_id){
                $.ajax({
                            url: 'vipinbox?action=read&id='+message_id,
                            dataType: "json",
                            success: function(data) {
                                    var all=data.all;
                                    var unread=data.unread;
                                    $('#msg_notice_all').text(all);
                                    $('#msg_notice_unread').text(unread);
                                    var qs='.explain[msgid='+message_id+']  span a.wd';
                                    $(qs).text('已读').css('color','#999');
                                    }
                                });     
            }


function FoldContext(){
    $All_Context=$('.trou');
    window.text_cut_num=70;
    $('.explain').each(
            function (num) {
                    var msgelem=$(this).find('p.msgtext a.msg');
                    var msg=msgelem.text();
                    //此处根据产品设计，当消息为商品推送服务的时候显示点击详情
                    //当消息已读的时候内容变成灰色
                    if (msgelem.attr('status')==1){
                        msgelem.css('color','#999'); 
                    };
                    if (Boolean(msg.match(/商品推送服务/))){
                        var msgid=$(this).attr('msgid');
                        var pid=$(this).attr('pid');
                        var hrefurl = '/user/vipdetail?id='+pid;
                        $(this).find('p.msgtext a.read').text('详细请点击！').attr('href');
                    }
                    else if ($(this).find('p.msgtext a.msg').text().length>num)
                        {
                            var text=$(this).find('p.msgtext a.msg').text();
                            var omission=text.substring(0,text_cut_num)+'.....';
                            if ($(this).find('p.msgtext a.msg').text().length>text_cut_num){
                                $(this).find('p.msgtext a.msg').text(omission);
                            }
                            else{
                                $(this).find('p.msgtext a.read').remove();
                                }
                            $(this).find('a.msgdel').click(
                                function () {
                                var msg_id = $(this).attr('msgid');
                                jConfirm('您确认要删除该条信息？','删除短消息',function (r){
                                    if (r==true){
                                        DelMessage(msg_id);
                                        }})
                                return false;
                            }
                            )
                            //当消息为未读状态的时候点击传信号到后台服务器端 存储已经阅读
                            $(this).find('p.msgtext a.read').click(
                                function ()   {
                                    var text = $(this).prev().attr('content');
                                    var default_h=64;
                                    var default_height = '64px';
                                    var split_num = 40;
                                    var export_height = parseInt(text.length/split_num);
                                    if(text.length%split_num>0){
                                        export_height = parseInt(export_height)+1;
                                        };
                                    export_height=default_h+(20*(export_height-2));
                                    //alert(export_height);
                                    if ($(this).prev().text().length > text_cut_num){
                                        if ($(this).text()=="[展开阅读]"){
                                            $(this).prev().text(text);
                                            $(this).text('[收起]');
                                            $(this).parent().parent().parent().css('height',export_height);
                                            if ($(this).prev().attr('status')=='0')
                                            {
                                                $(this).prev().css('color','#778877');
                                                var message_id = $(this).attr('msgid');
                                                ReadMessage(message_id);}
                                        }
                                        else if ($(this).text()=='[收起]'){
                                            var clipstext = text.substring(0,text_cut_num)+'.....';
                                            $(this).prev().text(clipstext);
                                            $(this).parent().parent().parent().css('height',default_height);
                                            $(this).text("[展开阅读]");
                                        }
                                    }
                                    });
                        };
                });
            }



function SelectAllinput()
        {   
            if ($(':input[name="selectall"]').attr('checked')==false)
            {
                $(':input').attr('checked',true);
                }
            else if ($(':input[name="selectall"]').attr('checked')==true)
            {
            $(':input').attr('checked',false);
            }}

function DelAllSelected()
    {
    var selectedmsg = checkselect();
    var allmsg = $('input[name=msg]').length;
    if (selectedmsg==0){
         jAlert('请选择需要删除的项目','没有选择任何项目');}
    else {
        var notice=''
        if (selectedmsg==allmsg){
            notice='您确认要删除全部信息？';
        }
        else{
            notice='你确认删除以上'+selectedmsg+'条信息？';
        }
        jConfirm(notice,'全部删除',function (r){
    if(r ===true)   
    {
    $('input[name=msg]').each(
            function () {
                if ($(this).attr('checked')==true)
                {
                    var message_id=$(this).attr('value');
                    DelMessage(message_id);
                };
                        }
                            );}
            });
        }
    }


function checkselect()
{
    var a=0;
    $('input[name=msg]').each(
        function () {if($(this).attr('checked')==true)
        {
        a=a+1;
        };}
        );
    return a;
}


