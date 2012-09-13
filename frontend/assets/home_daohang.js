$(document).ready(function(){

    page();
    function page(){
		$("#page_content a").click(function(){
		    var p_page = $(this).attr('href');
            p_page = p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);
		    var c_id   = $("input[name=type]").val();
		    var p_sort = $("input[name=sort]").val();
		    var p_way  = $("#"+p_sort).attr('ref');
		    if('asc'==p_way) {
			    p_way = 'desc';
		    }else{
			    p_way = 'asc';
		    }
		    $.get("services/homepage.php",{id:c_id,sort:p_sort,way:p_way,page:p_page},function(data){
			var str = data.split('%');
			$("#page_content").html(str['3']);
			$("#home_center .center_bup").html(str['0']);
			page();
            location.hash= '#goods';
		    }); 
		    return false;
		});
    }

	 $("#home_center #price").click(function(){
            var c_id = $("input[name=type]").val();
            var p_way = $(this).attr('ref');
            if('asc'==p_way) {
                $(this).attr('ref','desc')
                $(this).css('background-position','0 -22px');
            } else {
                $(this).attr('ref','asc')
                $(this).css('background-position','0 0');
            }
	    $.get("services/homepage.php",{id:c_id,sort:'price',way:p_way},function(data){
                $("input[name=sort]").val('price');
                var str = data.split('%');
	        $("#page_content").html(str['3']);
                $("#home_center .center_bup").html(str['0']);
		page();
            });
            return false;
        });

        $("#home_center #attentions").click(function(){
            var c_id = $("input[name=type]").val();
            var p_way = $(this).attr('ref');
            if('asc'==p_way) {
                $(this).attr('ref','desc')
                $(this).css('background-position','0 -22px');
            } else {
                $(this).attr('ref','asc')
                $(this).css('background-position','0 0');
            }

	    $.get("services/homepage.php",{id:c_id,sort:'attentions',way:p_way},function(data){
                $("input[name=sort]").val('attentions');
                var str = data.split('%');
	        $("#page_content").html(str['3']);
                $("#home_center .center_bup").html(str['0']);
		page();
            });
            return false;
        });

 $("#home_center #date").click(function(){
            var c_id = $("input[name=type]").val();
            var p_way = $(this).attr('ref');
            if('asc'==p_way) {
                $(this).attr('ref','desc')
                $(this).css('background-position','0 -22px');
            } else {
                $(this).attr('ref','asc')
                $(this).css('background-position','0 0');
            }

	    $.get("services/homepage.php",{id:c_id,sort:'date',way:p_way},function(data){
                $("input[name=sort]").val('date');
                var str = data.split('%');
	            $("#page_content").html(str['3']);
                $("#home_center .center_bup").html(str['0']);
		        page();
            });
            return false;
        });


        $("#home_daohang .daohang_type a").click(function(){
                $("#home_daohang .daohang_type a").removeClass('font_size');
                $(this).addClass('font_size');
        });

            //二级分类查询数据
            $("#home_center .locality a").click(function(){
                $(".locality a").removeClass('font_size');
                $("#home_daohang .daohang_type a").removeClass('font_size');
                $(this).addClass('font_size');    
                var p_sort  = $("input[name=sort]").val();
                var p_way   = $("#"+p_sort).attr('ref');
                var c_id = $(this).attr('value');
                $("input[name=type]").val(c_id);
                $.get("services/homepage.php",{id:c_id,sort:p_sort,way:p_way},function(data){
                    $("input[name=type]").val(c_id);
                    var str = data.split('%');
	                $("#page_content").html(str['3']);
		            $("#home_center .center_bup").html(str['0']);
                    page();
                });
		        return false;
            });
});