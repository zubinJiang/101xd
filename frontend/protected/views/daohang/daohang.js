$(document).ready(function(){

        $('#city .city_name .other').hide();
        $('#city .hide').click(function(){
            $('#city').hide();
            });

        function citySelect() {
        $('#city .city_name  a').click(function(){
            $('#city .tical li a').removeClass('now');
            $('#city .city_name a').removeClass('now');
           
            $('#group .group_title a').removeClass('now');
            $('#group .group_title ol li a:first').addClass('now');
            $(this).addClass('now');
            var web_id  = $('#group .group_title a').attr('web_id');
            var ref  = $(this).attr('ref');

            $('input[name=str_id]').val(ref);
            $('input[name=str_action]').val('area_web');

            $.get("daohang", { action:'area_web',id:ref ,web_id:web_id}, function(data){
                $('#group .group_list .data').html(data);
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

            $('#city .tical ul a').click(function(){

                    $('#city .tical li a').removeClass('now');
                    $('#group .group_title a').removeClass('now');
                   
                    $('#group .group_title ol li a:first').addClass('now');
                    $(this).addClass('now');

                    $('#city .city_other').hide();
                    $('#city .city_other2').hide();

                    var web_id = $('#group .group_title a').attr('web_id');
                    var ref    = $(this).attr('ref');

                    $('input[name=str_id]').val(ref);
                    $('input[name=str_action]').val('area_getdata');

                    $.get("daohang", { action:'area_getdata' ,id:ref ,web_id:web_id }, function(data){

                        var str = data.split('|');
                        $('#city .city_name ul li').html(str['0']);
                        $('#group .group_list .data').html(str['1']);

                        citySelect();
                        });

                    return false;

            });
        }

        areaselect();

        $('#group .group_title a').click(function(){
                $('#group .group_title a').removeClass('now');
                $(this).attr('class','now');

                var p_id     = $('input[name=str_id]').val(); 
                var p_action = $('input[name=str_action]').val();
                var p_type   = $(this).attr('web_id'); 

                $.get("services/daohang.php", {action:p_action, id:p_id, type:p_type}, function(data){
                    $('#group .group_list .data').html(data);
                    });
                return false;
        });
});
