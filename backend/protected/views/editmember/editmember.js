jQuery(function ($) {
	var contact = {
		message: null,
		init: function () {
			$('#member a.detail_id').click(function (e) {
				e.preventDefault();
                var user_id = $(this).attr('rel');

				$.get("services/member.php",{id:user_id}, function(data){
					$(data).modal({
						closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
						position: ["15%",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onClose: contact.close
					});
				});
			});
		},
		open: function (dialog) {
			var h = 350;
			var title = $('#contact-container #detail').html();
			$('#contact-container #detail').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container #detail').animate({
							height: h
						}, function () {
							$('#contact-container #detail').html(title);
							$('#contact-container #detail').fadeIn(200);
						});
					});
				});
			});
		},
		close: function (dialog) {
			$('#contact-container #detail ul').html('Goodbye...');
			$('#contact-container #detail ul').fadeOut(200);
			$('#contact-container #detail').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		}
	};

	contact.init();


    del();
    // 获取选中状态id
    function getCheckValue() {

        var str_id = '';
        $('li[class="checkbox"] input[class="checkbox"]').each(function(){
            var sta = $(this).attr("checked");
            if(sta) {
                str_id = str_id + ($(this).val()) + ',';
            }
        });

        if(str_id.length>0) {
            str_id = str_id.substring(0,(str_id.length-1));
        }

        return str_id;
    }

    
    //批量删除
    $('#delete').click(function(){
        var str_id = getCheckValue();
        if(str_id.length==0) {
            jAlert('勾选后才能执行操作。')
        } else {
            jConfirm('确认删除？','确认删除？',function (r){
            if (r){
            $.getJSON('services/member.php', {action:'delete',id:str_id}, function(data) {
                if(data.result) {
                    var id_arr = str_id.split(",");
                    var id_len = id_arr.length;
                    for(var i=0;i<id_len;i++) {
                        $('ul[id="'+id_arr[i]+'"]').hide();
                    }
                    count(id_len);
                }
            }); 
        }})}
        return false;
    });

    //删除
    function del(){
    $('a.delete_id').each(
        function(){
        $(this).click(function(){
        var str_id=$(this).attr('rel');
        jConfirm('确认删除？','确认删除？',function (r){
            if (r){
                $.getJSON('services/member.php', {action:'delete',id:str_id}, function(data) {
                    if(data.result) {
                        $('ul[id="'+str_id+'"]').hide();
                        count(1);
                    }       
                }); 
                }
            
            })

     return false;
    });})}

    //全选
    $('.global #all_select').click(function(){
        var value = $(this).attr("checked");
        $('#member input[type="checkbox"]').each(function(){
            $(this).attr("checked", value);
        });
    });

    function count(num) {
        var font  = $('#member .material font');
        var count = font.text();
        count = parseInt(count);
        if(num==1){
            count--;
        } else {
            count=count-num;
        }
        if(count<=0) { count=0; }
        font.text(count);
    }
});
