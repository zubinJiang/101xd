jQuery(function ($) {
	var contact = {
		message: null,
		init: function () {
			$('#liaison .liaison_left .favorite').click(function (e) {
				e.preventDefault();
                var pid = $(this).attr('name');
                var loc = location.href;
                loc     = escape(loc);

				$.get("services/favorite.php",{id:pid,url:loc}, function(data){
					$(data).modal({
						closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
						position: ["35%",],
						overlayId: 'contact-overlay',
						containerId: 'contact-container',
						onOpen: contact.open,
						onShow: contact.show,
						onClose: contact.close
					});
				});
			});
		},
		open: function (dialog) {
			if ($.browser.mozilla) {
				$('#contact-container .rine').css({
					'padding-bottom': '2px'
				});
			}
			if ($.browser.safari) {
				$('#contact-container .rine').css({
					'font-size': '.9em'
				});
			}

			var h = 280;

			var title = $('#contact-container .collect_body p span').html();
			$('#contact-container .collect_body p span').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container .collect_form').animate({
							height: h
						}, function () {
							$('#contact-container .collect_body p span').html(title);
							$('#contact-container .collect_body').fadeIn(200, function () {
								$('#contact-container .collect_body p input[name="title"]').focus();
							});
						});
					});
				});
			});
		},
		show: function (dialog) {
			$('#contact-container input.rine').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
					var msg = $('#contact-container .contact-message');
					msg.fadeOut(function () {
						msg.removeClass('contact-error').empty();
					});
					$('#contact-container .collect_body p span').html('Sending...');
					$('#contact-container .collect_body').fadeOut(200);
					$('#contact-container .collect_form').animate({
						height: '80px'
					}, function () {
						$('#contact-container .contact-loading').fadeIn(200, function () {
                            var f_t = $('#contact-container .collect_body p input[name="title"]').val();
                            var f_c = $('#contact-container .collect_body select[name="folder"]').val();
                            var pid = $('#contact-container .collect_body #product_id').val();
                            $.ajax({
								url: 'services/favorite.php',
								data: 'action=send&title='+f_t+'&folder='+f_c+'&id='+pid,
								type: 'post',
								cache: false,
								dataType: 'html',
								success: function (data) {
									$('#contact-container .contact-loading').fadeOut(200, function () {
										$('#contact-container .collect_body p span').html('操作成功！');
										msg.html(data).fadeIn(100);
                                        $('#contact-container .collect_form').fadeOut(100);
                                        $('#contact-container').html(data);
                                        var font  = $('#liaison .liaison_a .liaison_left #favorite font');
                                        var count = font.text();
                                        count = parseInt(count);
                                        count++;
                                        font.text(count);
                                        $('.modal-close').click(function() {
                                            $.modal.close();
                                        });
									});
								},
								error: contact.error
							});
						});
					});
				}
				else {
					if ($('#contact-container .contact-message:visible').length > 0) {
						var msg = $('#contact-container .contact-message div');
						msg.fadeOut(200, function () {
							msg.empty();
							contact.showError();
							msg.fadeIn(200);
						});
					}
					else {
						$('#contact-container .contact-message').animate({
							height: '30px'
						}, contact.showError);
					}
					
				}
			});
		},
        favoriteclose:function(dialog) {
            $('#contact-container .collection').html('Goodbye...');
			$('#contact-container .collection').fadeOut(200);
			$('#contact-container .collection').animate({
				height: 40
			}, function () {
                $('#contact-overlay').fadeOut(200, function () {
                    $.modal.close();
                });
                var font  = $('#liaison .liaison_a .liaison_left #favorite font');
                var count = font.text();
                count = parseInt(count);
                count++;
                font.text(count);
			});
        },
		close: function (dialog) {
			$('#contact-container .collect_body p span').html('Goodbye...');
			$('#contact-container .collect_body').fadeOut(200);
			$('#contact-container .collect_form').animate({
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
		},
		validate: function () {
			contact.message = '';
			if (!$('#contact-container .collect_body p input[name="title"]').val()) {
				contact.message += '收藏名字必须填写！';

                return false;
			}

		    return true;
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(200);
		}
	};

	contact.init();

});
