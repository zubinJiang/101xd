$(document).ready(function(){
    //ȫѡ
    checkselect();
    $('#zizhi_local .local_quan').click(function(){
    
        var value = $(this).attr("checked");
        $('#zizhi_local input[type="checkbox"]').each(function(){
            $(this).attr("checked", value);
        });
    });


    $('#zizhi_net .net_quan').click(function(){
    
        var value = $(this).attr("checked");
        $('#zizhi_net input[type="checkbox"]').each(function(){
            $(this).attr("checked", value);
        });
    });
});


function checkselect(){
    $('input.cateinput').click(function(){
        var sed = $('input.cateinput:checked').length;
        if (sed>5){
            alert('最多可以选择5个');
            $(this).attr('checked',false);
            return false;
            }
        else{
            return true;
        }
            
            })
    }

