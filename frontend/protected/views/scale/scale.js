$(document).ready(function(){
        
        $("#scale .dimen").click(function(){
            $(this).val('');
            });

        $("#scale .sions").click(function(){
            var value = $("#scale .dimen").val();

            var update_date = $("input[name=update_data]").val();

            $("input[name=update_data]").val(update_date);


            location.href= 'daohang?key='+value;
            
            return false;
            });
});
