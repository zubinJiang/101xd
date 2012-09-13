$(document).ready(function(){
        $('#fastsupply li a.active').click(function(){
            var url_ = $(this).attr('rel');
            var id   = url_.substring(url_.lastIndexOf('=')+1, url_.length);
            jAlert('确认将要进行操作','确认操作？',function(r){
                if (r){
                    var del = url_.indexOf('delete');
                    if(del>0) {
                        $.getJSON(url_, function(data){
                            $('#fastsupply li[id="'+id+'"]').hide();
                        });
                    } else {
                        $.getJSON(url_, function(data){
                            var re_status = '未通过';
                            if(data.auth=='0') {
                                if(data.result=='1') {
                                    re_status = 'vip供货';
                                } else {
                                    re_status = '审核中';
                                }
                            } else if(data.auth=='1') {
                                re_status = '已通过';
                            } else if(data.auth=='2') {
                                re_status = '未通过';
                            }

                            $('#fastsupply .'+id+'_status').text(re_status);
                        });
                    }
                }
                return false;
            });
            return false;
        });


    //移动
        var contact = {
		message: null,
		init: function () {
			$('#fastsupply a.through').click(function (e) {
				e.preventDefault();
                var url_ = $(this).attr('rel');
                var p_id   = url_.substring(url_.lastIndexOf('=')+1, url_.length);
				$.get("services/adminfastsupply.php",{action:'through',id:p_id}, function(data){
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

                            $('#contact-container #detail input[type="button"]').click(function() {
                                var res = $('#contact-container #detail #reason').val();
                                var pid = $('#contact-container #detail #pid').val();
                                $.ajax({
                                    url: 'services/adminfastsupply.php?action=submit',
                                    data: 'id='+pid+'&msg='+res,
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
