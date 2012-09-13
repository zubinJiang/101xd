$(document).ready(function(){
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
                $.getJSON('services/batch_manage_product.php', {action:'all_delete', id:str_id , user_type:'admin'}, function(data) {
                    if(data.result) {
                        var id_arr = str_id.split(",");
                        var id_len = id_arr.length;
                        for(var i=0;i<id_len;i++) {
                            $('ul[id="'+id_arr[i]+'"]').hide();
                        }
                    }
                }); 
            }})}
            return false;
        });

        //全选
        $('#all_select').click(function(){
            var value = $(this).attr("checked");
            $('#manageGoodList input[type="checkbox"]').each(function(){
                $(this).attr("checked", value);
            });
        });
        
        //删除
        function del(){
        $('a.delete_id').each(
                function(){
            $(this).click(function(){
            var str_id=$(this).attr('rel');
            jConfirm('确认删除？','确认删除？',function (r){
                if (r){
                    $.getJSON('services/manage_product.php', {action:'delete', id:str_id, user_type:'admin'}, function(data) {
                    if(data.result) {
                        $('ul[id="'+str_id+'"]').hide();
                            }       
                        }); 
                    }
                
                })

         return false;
        });})}

        function change_num() {

            var this_font = $('#manageGoodList ol a.shop font');  //自减 小数字
            var this_num  = this_font.text();
            var the_num = (parseInt(this_num)-1)>0 ? (parseInt(this_num)-1) : 0;
            this_font.text(the_num);

            var tips  = $('#manageGoodList .material font'); // 提示语
            tips.text(the_num);
        }

        //移动
        var contact = {
		message: null,
		init: function () {
			$('.choice a.move_id').click(function (e) {
				e.preventDefault();
                var p_id = $(this).attr('rel');
				$.get("services/administrate.php",{action:'move',id:p_id}, function(data){
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
			var h = 300;

			var title = $('#contact-container #detail').html();
			$('#contact-container #detail').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container #detail').animate({
							height: h
						}, function () {
							$('#contact-container #detail').html(title);
							$('#contact-container #detail').fadeIn(200, function () {

                            $('#contact-container #detail #change_category').change(function(){
                                var cid = $(this).val();
                                $.get('services/administrate.php',{action:'change', id:cid},function(data){
                                    $('#contact-container #detail #category_id').html(data);
                                });
                            });

                            $('#contact-container #detail input[type="button"]').click(function() {
                                var pca = $('#contact-container #detail #change_category').val();
                                var pci = $('#contact-container #detail #category_id').val();
                                var pid = $('#contact-container #detail #pid').val();
                                $.ajax({
                                    url: 'services/administrate.php?action=moveto',
                                    data: 'id='+pid+'&ca='+pca+'&ci='+pci,
                                    type: 'post',
                                    cache: false,
                                    dataType: 'html',
                                    success: function (data) {
                                        $('#contact-container #detail').fadeOut(200, function () {
                                            location.reload();
                                            $.modal.close();
                                        });
                                    },
                                    error: contact.error
                                });
                            });
							});
						});
					});
				});
			});
		},
		close: function (dialog) {
			$('#contact-container #detail').html('Goodbye...');
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
});
