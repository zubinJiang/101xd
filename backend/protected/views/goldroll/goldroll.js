$(document).ready(function(){


        $('#goldroll #province_id').change(function(){

            var str_id = $(this).val();

			$.get('services/goldroll.php',{action:'get', id:str_id},function(data){
				$('#area_id').html(data);
			})
		});

      $("input[name=w_url]").blur(function(){
                var w_url = $(this).val();
                var reg="/^[url]http://([/url][\w-]+\.)+[\w-]+(/[\w-./?%&=])?/";
                if(w_url == ""){ return false; }
                if(!reg.test(w_url)){
                    $("#goldroll .mess_url").html('url格式不正确');
                }
        });

        $("input[name=price_y]").blur(function(){
                var price_x = $("input[name=price_x]").val();
                var price_y = $(this).val(); 
                if(price_x == "") { return false; }
                if(price_y == "") { return false; }
                $("#goldroll .price").val("满"+price_x+"返回"+price_y);
                    
        });
        
       KE.show({
            id : 'content',
            width: '100%',
            resizeMode : 1,
            allowFileManager : true,
            fileManagerJson : '../../../../local?action=fileBrowse&filter=original',
            fileManagerJsonMine : '../../../../local?action=fileBrowse&filter=175X132',
            imageUploadJson : '../../../../local',
            imageUploadJsonMine : '../../../../local?filter=175X132',
            items : [
            'source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste',
            'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
            'superscript', '|', 'selectall', '-',
            'title', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold',
            'italic', 'underline', 'strikethrough', 'removeformat', '|', 'image', 'multiUpload',
            'flash', 'media', 'advtable', 'hr', 'emoticons', 'link', 'unlink' ]
        });

        $("#submit .submit").click(function(){
                var w_name  = $("input[name=w_name]").val();
                var p_name  = $("input[name=p_name]").val();
                var p_tel   = $("input[name=p_tel]").val();
                var province_id = $(".province_id").val();
                var area_id     = $("area_id").val();
                var b_address   = $('b_address').val();
                var w_title     = $('w_title').val();
                var len         = w_title.length;
                if(w_name == "") { return false; }
                if(p_name == "") { return false; }
                if(p_tel == "") { return false; }
                if(province_id == "") { return false; }
                if(area_id == "") { return false; }
                if(b_address == "") { return false; }
                if(len > 30) { return false;}
        });
      
});
