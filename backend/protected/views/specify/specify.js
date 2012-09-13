$(document).ready(function(){
        
        $("#scale").click(function(){
           $(this).parent().css('background-image','url(../../../images/past.gif)');
                var ref = $(this).attr('ref');
                $.get("services/sellerhome.php", {action:"getList", id:ref}, function(data){
                    $("#specify .israel").html(data);
                });

                return false;
        });

        $("#flow").click(function(){
             $(this).parent().css('background-image','url(../../../images/past2.gif)');

             var ref = $(this).attr('ref');
                 $.get("services/sellerhome.php", {action:"getList", id:ref}, function(data){
                    $("#specify .israel").html(data);
                });


                 return false;

            });
});
