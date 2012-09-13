$(document).ready(function(){
        //page 
        function page(){
            $(".content100 .yi a.pagelist").click(function(){
                var p_page = $(this).attr('href');
                var p_sort  = $("input[name=sort]").val();
                var p_way   = $("input[name=order]").val();
                var p_page  =  p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);

                $.get("services/ranking.php",{action:'page', sort:p_sort, page:p_page, way:p_way },function(data){
                    var str = data.split('|||||'); 
                    $('#content .content3 ul').html('').hide();
                    $('#content .content3 h2').css('border','none');
                    $('#content .content3').css('height', '30');
                    $('#content .content3 ul').html('').hide();
                    $('#content').css('height', '1950');
                    $('#content .zhongxin').html('').html(str['0']);
                    $('.content100 .fanye .yi').html('').html(str['1']);
			        page();
                    location.hash= '#goods';
		        }); 

                return false;
            });

            return false;
        }
        page();

        //GO
        $("#go").click(function(){
                var p_page = $("input[name=go]").val();
                var p_sort  = $("input[name=sort]").val();
                var p_way   = $("input[name=order]").val();
                var p_page  =  p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);
                $.get("services/ranking.php",{action:'page', sort:p_sort, page:p_page, way:p_way },function(data){
                    var str = data.split('|||||'); 
                    $('#content .content3 ul').html('').hide();
                    $('#content .content3 h2').css('border','none');
                    $('#content .content3').css('height', '30');
                    $('#content .content3 ul').html('').hide();
                    $('#content').css('height', '1950');
                    $('#content .zhongxin').html('').html(str['0']);
                    $('.content100 .fanye .yi').html('').html(str['1']);
			        page();
                    location.hash= '#goods';
		        }); 
                return false;

        });

        //sort
        $(".content3 h2 span a").click(function(){
                $(".content3 h2 span a").css('font-weight','normal');
                $(this).css('font-weight', 'bolder');
                var p_way = $(this).attr('value');
                var value = $(this).attr('class');
                $("input[name=sort]").val(value);
                $("input[name=order]").val(p_way);
                $('#content').css('height', '1700');
                if(p_way=='desc'){
                    $(this).attr('value','asc');
                } else {
                    $(this).attr('value','desc');
                }
                if(value=="bought"){
                    if(p_way=="asc"){
                        $(this).html("购买量↑");
                    } else {
                        $(this).html("购买量↓");
                    }
                }
                if(value=="starttime"){
                    if(p_way=="asc"){
                        $(this).html("开团日期↑");
                    } else {
                        $(this).html("开团日期↓");
                    }
                }
                if(value=="sales"){
                    if(p_way=="asc"){
                        $(this).html("销售额↑");
                    } else {
                        $(this).html("销售额↓");
                    }
                }
                if(value=="boughtperhour"){
                    if(p_way=="asc"){
                        $(this).html("日均购买量↑");
                    } else {
                        $(this).html("日均购买量↓");
                    }
                }
                $.get("services/ranking.php",{action:'sort', sort:value, way:p_way},function(data){
                    var str = data.split('|||||'); 
                    $('#content .content3 ul').html('').html(str['0']);
                    $('#content .content3 h2').css('border-bottom', '1px dashed #CCCCCC');
                    $('#content .content3').css('height', '265');
                    $('#content .content3 ul').show();
                    $('#content .zhongxin').html('').html(str['1']);
			        page();
		        }); 

                return false;
        });
});
