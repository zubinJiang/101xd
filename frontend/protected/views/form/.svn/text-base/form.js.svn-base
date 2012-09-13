$(document).ready(function(){
        $('#scale .form').click(function(){
            $('#form').show();
        });

        $('#form .close a').click(function(){
            $('#form input[name=name]').val('');
            $('#form input[name=url]').val('');
            $('#form input[name=api_url]').val('');
            $('#form textarea[name=desc]').val('');

            $('#form').hide();
        });

        $('#form input[name=name]').blur(function(){
            var name = $(this).val();
            if(name.length==0){
                $(this).next().text('网站名称必须填写！').css('color','red');
            }
        }); 

        $('#form input[name=url]').blur(function(){
            var url = $(this).val();
            if(url.length==0){
                $(this).next().text('网站地址必须填写！').css('color','red');
            }
            
        });

        $('#form .form_submit').click(function(){
            var w_name = $('#form input[name=name]').val();
            var w_url  = $('#form input[name=url]').val();
            var w_api  = $('#form input[name=api_url]').val();
            var w_desc = $('#form textarea[name=desc]').val();

            if(w_name.length==0){
                $('#form input[name=name]').next().text('网站名称必须填写！').css('color','red');
                return false;
            }

            if(w_url.length==0){
                $('#form input[name=url]').next().text('网站地址必须填写！').css('color','red');
                return false;
            }
                
            $.post('detail',{action:'addForm',name:w_name,url:w_url,api_url:w_api,desc:w_desc},function(data){
                var result = data.split('|');
                if(parseInt(result[0])==1) {
                    $('#main #form ul .error').text(result[1]).css({'color':'green','font-size':'14px','font-weight':'bolder'});
                    $('#form input[name=name]').val('');
                    $('#form input[name=url]').val('');
                    $('#form input[name=api_url]').val('');
                    $('#form textarea[name=desc]').val('');

                } else {
                    $('#main #form ul .error').text(result[1]).css({'color':'red','font-size':'14px','font-weight':'bolder'});
                }
                return true;
            })
            return false;
        });
});
