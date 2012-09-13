$(document).ready(function(){
      
        $('#releasenets #province_id').change(function(){
            var str_id = $(this).val();

			$.get('services/goldroll.php',{action:'get', id:str_id},function(data){
				$('#area_id').html(data);
			})
		});

});
