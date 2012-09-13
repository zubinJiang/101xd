$(document).ready(function(){
        
        $('#city .hide').click(function(){
            $('#city').hide();
            return false;
        });

        function citySelect() {
        $('#city .city_name  a').click(function(){
            $('#city .city_name a').removeClass('now');
           
            $('#group .group_title a').removeClass('now');
            $('#group .group_title a:first').addClass('now');

            $("#group .tradi").hide();
            $("#group .flow").show();

            $("#group .flow a:first").addClass('now');

            $(this).addClass('now');
            var web_id  = $('#group .group_title a').attr('web_id');
            var ref  = $(this).attr('ref');

            var update_date = $("input[name=update_data]").val();

            $("input[name=update_data]").val(update_date);

            $('input[name=str_id]').val(ref);
            $('input[name=str_action]').val('area_web');

            $.get("daohang", { action:'area_web',id:ref ,web_id:'2'}, function(data){

                $('#group .data').html(data);
                var html = '<a web_id="2" class="now">按流量排名</a><a web_id="1">规模排名</a><span>'+update_date+'更新（更新周期：每周排名变化为近1周变化）</span>';
                $('#group .group_title').html(html);
                
                var tab = '<div class="tradi" style="display:none;"> <a href="#" class="yi now">开通城市在100以上的</a> <a href="#" class="er">开通城市在50以上的</a> <a href="#" class="san">开通城市在10以上的</a> <a href="#" class="si">开通城市在1以上的</a></div> <div class="flow"> <a href="#" class="yi now">流量排名1-100</a> <a href="#" class="er">流量排名100-300</a> <a href="#" class="san">流量排名300-1000的</a> <a href="#" class="si">流量排名1000之外</a></div>'

                $('#group .bup').html(tab);
                web();
            });

            return false;

            });
        }

        citySelect();

        $('#city .city_other  a').click(function(){

                $('#city .city_name .other').show();
                $('#city .city_other').hide();

                });

        function areaselect(){

            $('#city .tical a:not(.hide)').click(function(){
                    $('#city .tical a').removeClass('now');
                    $(this).addClass('now');
                    $('#group .group_title a').removeClass('now');
                    $('#group .group_title a:first').addClass('now');
                    $("#group .tradi").hide();
                    $("#group .flow").show();
                    $("#group .flow a:first").addClass('now');
                    var web_id = $('#group .group_title a').attr('web_id');
                    var ref    = $(this).attr('ref');
                    $('input[name=str_id]').val(ref);
                    $('input[name=web_str_id]').val(web_id);
                    $('input[name=str_action]').val('area_getdata');

                    var update_date = $("input[name=update_data]").val();
                    
                    $("input[name=update_data]").val(update_date);


                    $.get("daohang", { action:'area_getdata',id:ref,web_id:'2', page:'1'}, function(data){
                        var str = data.split('|'); 
                        $("#city .p_contect").html(str['0']);
                        $('#city .city_name ').html(str['1']);
                        $('#group .data').html(str['2']);
                        p_contact();
                        citySelect();
                            var html = '<a web_id="2" class="now">按流量排名</a><a web_id="1">规模排名</a><span>'+update_date+'更新（更新周期：每周排名变化为近1周变化）</span>';
                                    $('#group .group_title').html(html);
                                    
                                    var tab = '<div class="tradi" style="display:none;"> <a href="#" class="yi now">开通城市在100以上的</a> <a href="#" class="er">开通城市在50以上的</a> <a href="#" class="san">开通城市在10以上的</a> <a href="#" class="si">开通城市在1以上的</a></div> <div class="flow"> <a href="#" class="yi now">流量排名1-100</a> <a href="#" class="er">流量排名100-300</a> <a href="#" class="san">流量排名300-1000的</a> <a href="#" class="si">流量排名1000之外</a></div>'

                                    $('#group .bup').html(tab);
                                    web();
                        });

                    return false;

            });
        }
        areaselect();
        function p_contact(){
            $("#city .p_contect a").click(function(){
                var p_page = $(this).attr('href');
                var id = $("input[name=str_id]").val();
                var web_id = $("input[name=web_str_id]").val();
                $('input[name=str_id]').val(id);
                $('input[name=web_str_id]').val(web_id);
                $('input[name=str_action]').val('area_getdata');

                var update_date = $("input[name=update_data]").val();
                    
                $("input[name=update_data]").val(update_date);

                p_page = p_page.substring(p_page.lastIndexOf('=')+1, p_page.length);

                $.get("daohang", { action:'area_getdata',id:id,web_id:'2', page:p_page}, function(data){
                        var str = data.split('|'); 
                        $("#city .p_contect").html(str['0']);
                        $('#city .city_name ').html(str['1']);
                        p_contact();
                        citySelect();
                            var html = '<a web_id="2" class="now">按流量排名</a><a web_id="1">规模排名</a><span>'+update_date+'更新（更新周期：每周排名变化为近1周变化）</span>';
                                    $('#group .group_title').html(html);
                                    
                                    var tab = '<div class="tradi" style="display:none;"> <a href="#" class="yi now">开通城市在100以上的</a> <a href="#" class="er">开通城市在50以上的</a> <a href="#" class="san">开通城市在10以上的</a> <a href="#" class="si">开通城市在1以上的</a></div> <div class="flow"> <a href="#" class="yi now">流量排名1-100</a> <a href="#" class="er">流量排名100-300</a> <a href="#" class="san">流量排名300-1000的</a> <a href="#" class="si">流量排名1000之外</a></div>'

                                    $('#group .bup').html(tab);
                                    web();
                });

                return false;
            });
        }
        p_contact();
        function group_title() {
        $('#group .group_title a').click(function(){
                //$('#group .group_title a').removeClass('now');
                $('#group .bup .flow a').removeClass('now');
                $('#group .bup .flow a:first').addClass('now');
                $(this).addClass('now');
                var p_id     = $('input[name=str_id]').val(); 
                var p_action = $('input[name=str_action]').val();
                var p_type   = $(this).attr('web_id');
                /*if(p_type==2){
                
                    $("#group .flow").show();
                    $("#group .tradi").hide();
                    $("#group .flow a:first").addClass('now');
                } else {
                   
                    $("#group .flow").hide();
                    $("#group .tradi").show();
                    $("#group .tradi a:first").addClass('now');
                }*/
                $.get("services/daohang.php", {action:p_action, id:p_id, web_id:p_type}, function(data){
                    $('#group .data').html(data);
                    });
                return false;
        });
        }

       $('#group .hide').click(function(){
            $('#group').hide();
        }); 

       web();
       function web() {
            one();
            two();
            three();
            four();
            first_footer();
           two_footer();
           three_footer();
           four_footer();
           group_title();
       }

       function one() {
           $("#group .yi").click(function(){
                    $('#group .bup a').removeClass('now');
                    $(this).addClass('now');
                    $("#group .data .two").hide();
                    $("#group .data .three").hide();
                    $("#group .data .four").hide();
                    $("#two_footer").hide();
                    $("#three_footer").hide();
                    $("#four_footer").hide();
                    $("#first_footer").show();
                    $("#group .data .first").show();
                    return false;

           });
       }

       function two() {
       $("#group .er").click(function(){
       
                $('#group .bup a').removeClass('now');
                $(this).addClass('now'); 
                $("#group .data .first").hide();
                $("#group .data .three").hide();
                $("#group .data .four").hide();
                $("#first_footer").hide();
                $("#three_footer").hide();
                $("#four_footer").hide();
                $("#two_footer").show();
                $("#group .data .two").show();
                return false;

       });
       }


       function three() {
       $("#group .san").click(function(){
       
                $('#group .bup a').removeClass('now');
                $(this).addClass('now');
                $("#group .data .first").hide();
                $("#group .data .two").hide();
                $("#group .data .four").hide();
                $("#group .data .three").show();
                $("#first_footer").hide();
                $("#three_footer").show();
                $("#four_footer").hide();
                $("#two_footer").hide();
                return false;

       });
       }

       function four() {
       $("#group .si").click(function(){
                $('#group .bup a').removeClass('now');
                $(this).addClass('now');
                $("#group .data .first").hide();
                $("#group .data .two").hide();
                $("#group .data .three").hide();
                $("#group .data .four").show();
                $("#first_footer").hide();
                $("#three_footer").hide();
                $("#four_footer").show();
                $("#two_footer").hide();
                return false;

       });
       }

       function first_footer(){
       $("#first_footer").click(function(){
               
               $("#group .data .first").attr('style',"height:750px");
               $(this).hide();
               return false;
       });
       }



       function two_footer() {
       $("#two_footer").click(function(){
               
               var value = $(this).attr('value');
               var count2 = $(this).attr('count2');
               var height = 506+value*232;
               var num = Math.floor(count2/32)-1;
               if(value == num){
                    height = height-200;
                    $("#group .data .two").attr('style',"height:"+height+"px");
                    $(this).hide();
                    return false;
               }
               $("#group .data .two").attr('style',"height:"+height+"px");
               ++value;
               count2 = count2-value*32;
               $(this).html("还有"+count2+"个团购网站流量排名在100到300名，点击展开");
               $(this).attr('value',value);
               return false;
       });
       }

       function three_footer() {
       $("#three_footer").click(function(){
               
               var value = $(this).attr('value');
               var count3 = $(this).attr('count3');
               var height = 506+value*232;
               var num = Math.floor(count3/32)-1;
               if(value == num){
                    height = height-200;
                    $("#group .data .three").attr('style',"height:"+height+"px");
                    $(this).hide();
                    return false;
               }
               $("#group .data .three").attr('style',"height:"+height+"px");
               ++value;
               $(this).attr('value',value);
               count3 = count3-value*32;
               $(this).html("还有"+count3+"个团购网站流量排名在300到1000名，点击展开");
               return false;
       });
       }


       function four_footer() {
      $("#four_footer").click(function(){
               var count4 = $(this).attr('count4');
               var value = $(this).attr('value');
               var height = 250+value*230;
               var num = Math.floor(count4/32)-1;
               if(value == num){
                    height = height-240;
                    $("#group .data .three").attr('style',"height:"+height+"px");
                    $(this).hide();
                    return false;
               }
               $("#group .data .four").attr('style',"height:"+height+"px");
               ++value;
               count4 = count4-value*32;
               $(this).html("还有"+count4+"个团购网站流量排名在1000名之外，点击展开");
               $(this).attr('value',value);
               return false;
       });

       }

});
