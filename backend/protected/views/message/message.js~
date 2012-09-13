var color_unread='red';
var color_read='green';
$(document).ready(FoldContext());
$(document).ready(
      bindinput() 
        );

function bindinput() {$('#selectall').click(function () {if ($('#selectall').attr('checked')==true){$(':input').attr('checked',false);}else if ($('#selectall').attr('checked')==false){$(':input').attr('checked',true);}});}

function  DelMessage (message_id){
                var q='.atic_r > a[value='+message_id+']';
                var msg=$(q);
                $.ajax({
                            url: 'message?action=del&id='+message_id,
                            dataType: "json",
                            success: function(data) {
                                    var q='.atic_l> input[value='+message_id+']';
                                    $(q).parent().parent().slideUp();
                                    var all=data.all;
                                    var unread=data.unread;
                                    var text='您共收到'+all+'条消息，其中有<strong>'+unread+'</strong>条新消息</p>';
                                    $('#message >p').html(text);
                                    }
                                }); 
            }
            
function  ReadMessage (message_id){
                var q='.atic_r > a[value='+message_id+']';
                var msg=$(q);
                $.ajax({
                            url: 'message?action=read&id='+message_id,
                            dataType: "json",
                            success: function(data) {
                                    var q='.atic_l> input[value='+message_id+']'; 
                                    var all=data.all;
                                    var unread=data.unread;
                                    var text='您共收到'+all+'条消息，其中有<strong>'+unread+'</strong>条新消息</p>';
                                    $('#message >p').html(text);
                                    var qs='#status_info_'+message_id;
                                    $(qs).text('已读').css('color','green');
                                    }
                                });     
            }


function FoldContext(){
    $All_Context=$('.trou');
    var num=80;
    $('.atic_l[info=status]').each(function () {
                if ($(this).next().children('span.trou').attr('status') == 0) {
                $(this).children('span').css('color', 'red');
                } else if ($(this).next().children('span.trou').attr('status') == 1) {
                $(this).children('span').css('color', 'green');
                }
                });   
    $('.trou').each(
            function (num) {
                    if ($(this).text().length>num)
                        {
                            var text=$(this).attr('content');
                            var omission=text.substring(0,40)+'.....';
                            $(this).text(omission);
                            $(this).parent().next().click(
                            function () {
                            var msg_id = $(this).children().attr('value');
                            jConfirm('确认？','将要删除项目.',function (r){
                                if (r==true)
                                {
                            DelMessage(msg_id);}})
                            return false;
                            }
                            )
                            $(this).next().click(
                                function ()   {
                                    if ($(this).text()=='展开阅读'){
                                    $(this).prev().text(text);
                                    $(this).text('收起');
                                    if ($(this).prev().attr('status')=='0')
                                    {
                                    $(this).prev().css('color','#778877');
                                    ReadMessage($(this).prev().parent().prev().prev().children().attr('value'));}
                                    }
                                    else if ($(this).text()=='收起'){
                                    $(this).prev().text(text.substring(0,40)+'.....');
                                    $(this).text('展开阅读');
                                    }});
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
    if (checkselect()==0){
    jAlert('请选择项目','未选中任何项目');}
    else {
    jConfirm('确认？','将要全部删除.',function (r){
    if(r ===true)   
    {
    $('.atic_l >input').each(
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
    $('.atic_l >input').each(
        function () {if($(this).attr('checked')==true)
        {
        a=a+1;
        };}
        );
    return a;
}

