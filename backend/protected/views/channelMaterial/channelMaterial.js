$(document).ready(function(){

    //����ʡ��ID��ȡ����List 
    function get_area_by_province_id() {
        $('.province_id').change(function(){
            var str_id = $(this).val();
            $.get('services/goldroll.php',{action:'get', id:str_id},function(data){
                $('.area_id').html(data);
            })
        });
    }

    get_area_by_province_id();
        
});
