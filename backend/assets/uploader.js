$(function(){
    var swfu;
    var Uploader = {
	getFileSize: function(num) {
		if (isNaN(num)) {
			return false;
		}
		num = parseInt(num);
		var units = [ " B", " KB", " MB", " GB" ];
		for ( var i = 0; i < units.length; i += 1) {
			if (num < 1024) {
				num = num + "";
				if (num.indexOf(".") != -1 && num.indexOf(".") != 3) {
					num = num.substring(0, 4);
				} else {
					num = num.substring(0, 3);
				}
				break;
			} else {
				num = num / 1024;
			}
		}
		return num + units[i];
	},
	
	Handler: {
		fileQueued: function(file) {
            this.startUpload();
		},
		
		uploadComplete: function(file) {
			this.startUpload();
		},
		
		uploadStart: function(file) {
			this.startUpload();
            var div= document.createElement('div');
            div.setAttribute('id', 'loading');
            div.innerHTML = '<img src="images/lightbox-ico-loading.gif" />&nbsp;图片上传中，请稍后。';
            document.getElementById("upload1-picone").appendChild(div);
		},
		
		uploadProgress: function(file, bytesLoaded, bytesTotal) {

		},
		uploadSuccess: function(file, serverData) {
            var obj = eval('(' + serverData + ')');
            var loading = document.getElementById('loading');
            document.getElementById("upload1-picone").removeChild(loading);
            var li = document.createElement('li');
            li.innerHTML = '<a href="'+obj.aurl+'" target="_blank"><img src="'+obj.aurl+'" width="100" height="100"></a><div class="del" rel="'+obj.aurl+'"><span class="del_cha"></span></div>';
            document.getElementById("upload1-pic-show").appendChild(li);
            var value = document.getElementById("product_pic1").value;
            if(value.length>0) {
                document.getElementById("product_pic1").value = value + '|' + obj.url;
            } else {
                document.getElementById("product_pic1").value = obj.url;
            }
            del_image();
		},
		fileQueueError: function(file, errorCode, message) { 
            try {
		    if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("对不起，最多可同时上传5张图片");
			return;
		    }

            switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                alert("您上传的文件太大。只能上传大小在2MB内的图片文件！");
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                alert("不能上传空文件！");
                break;
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                alert("错误的文件类型！");
                break;
            default:
                alert("未知错误！");
                break;
            }
	    } catch (ex) {
            this.debug(ex);
        }
        }
	}
};


	swfu = new SWFUpload({
		upload_url : "/user/upload",
		flash_url : "/user/images/swfupload.swf",
		file_size_limit : "2 MB",
		file_types : "*.jpg;*.jpeg;*.png;*.bmp;*.gif",
		file_types_description : "All Image Files",
		file_post_name : "imgFile",
        file_upload_limit : 5,
		
        button_image_url: 'images/correlate.png',
		button_placeholder_id : "upload1",
        button_height: "28",
        button_width: "88",
		button_cursor : SWFUpload.CURSOR.HAND,
		
		//handler
		file_queued_handler : Uploader.Handler.fileQueued,
		file_queue_error_handler : Uploader.Handler.fileQueueError,
		upload_complete_handler : Uploader.Handler.uploadComplete,
		upload_start_handler : Uploader.Handler.uploadStart,
		upload_progress_handler : Uploader.Handler.uploadProgress,
		upload_success_handler : Uploader.Handler.uploadSuccess

	});

      var jcrop_api, boundx, boundy;

      function uploadok() {
          $('#uploadok').click(function(){
              var px  = $('#x').val();
              var py  = $('#y').val();
              var pw  = $('#w').val();
              var ph  = $('#h').val();
              var path= $('#preview').attr('src');
              
              $.get('services/upload_default.php', {img:path,x:px,y:py,w:pw,h:ph},function(data){
                  $('#big_image').find('#default_big_image').eq(0).remove();
                  $('#big_image').find('#upstream').eq(0).show();
                  $('#small_image').html('');
                  if(data.length>0) {
                      $('.default_image_show').html('');
                      $('.default_image_show').append('<img height="148" width="211" src="' + data +'" />');
                      $('.default_image_show').append('<input type="hidden" id="defaultpic" name="defaultpic" value="' + data +'" />');
                      $('.default_image_show').append('<div class="del_default_pic" id=""><span class="del_default_cha"></span>');
                      del_default_image();
                  }
                  $('#img_show').hide();
              });
          });
      }

      openpic();
      function openpic() {
          $('#open_pic').click(function(){
                $('#img_show').show();
                return false;
          });
      }
        
      function jscrop() {
          $('#target').Jcrop({
            setSelect: [ 10, 10, 110, 70],
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: 11/7
          },function(){
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            jcrop_api = this;
          });
      }

      function updatePreview(c)
      {
        if (parseInt(c.w) > 0)
        {
          var rx = 440 / c.w;
          var ry = 280 / c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });

            $("#x").val(c.x);
            $("#y").val(c.y);
            $("#w").val(c.w);
            $("#h").val(c.h);
        }
      }

    $('.close').click(function(){
        $('#img_show').hide();
    });

   var Uploader_default = {
	    getFileSize: function(num) {
		if (isNaN(num)) {
			return false;
		}
		num = parseInt(num);
		var units = [ " B", " KB", " MB", " GB" ];
		for ( var i = 0; i < units.length; i += 1) {
			if (num < 1024) {
				num = num + "";
				if (num.indexOf(".") != -1 && num.indexOf(".") != 3) {
					num = num.substring(0, 4);
				} else {
					num = num.substring(0, 3);
				}
				break;
			} else {
				num = num / 1024;
			}
		}
		return num + units[i];
	},
	
	Handler: {
		fileQueued: function(file) {
            this.startUpload();
		},
		uploadComplete: function(file) {
			//this.startUpload();
		},
		
		uploadStart: function(file) {
			this.startUpload();
            var div= document.createElement('div');
            div.setAttribute('id', 'loading');
            div.innerHTML = '<img src="images/lightbox-ico-loading.gif" />&nbsp;图片上传中，请稍后。';
            document.getElementById("big_image").appendChild(div);
		},
		
		uploadProgress: function(file, bytesLoaded, bytesTotal) {

		},
		uploadSuccess: function(file, serverData) {
            var obj = eval('(' + serverData + ')');
            var loading = document.getElementById("loading");
            document.getElementById("big_image").removeChild(loading);
            var li = document.createElement('li');
            var div= document.createElement('div');
            div.innerHTML = '<img src="'+obj.aurl+'" id="target" >';
            div.setAttribute('id', 'default_big_image');
            document.getElementById("upstream").style.display = 'none';
            document.getElementById("big_image").appendChild(div);
            li.innerHTML = '';
            li.innerHTML = '<img src="'+obj.aurl+'" id="preview" >';
            document.getElementById("small_image").innerHTML = li.innerHTML;
            jscrop();
            uploadok();
		},
		fileQueueError: function(file, errorCode, message) { 
            try {
		    if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("对不起，首图只能上传1张图片！");
			return;
		    }

            switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                alert("您上传的文件太大。只能上传大小在2MB内的图片文件！");
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                alert("不能上传空文件！");
                break;
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                alert("错误的文件类型！");
                break;
            default:
                alert("未知错误！");
                break;
            }
	    } catch (ex) {
            this.debug(ex);
        }
        }
	}

   }
	swfu3 = new SWFUpload({
		upload_url : "/user/upload",
		flash_url : "/user/images/swfupload.swf",
		file_size_limit : "2 MB",
		file_types : "*.jpg;*.jpeg;*.png;*.bmp;*.gif",
		file_types_description : "All Image Files",
		file_post_name : "imgFile",
        file_upload_limit : 1,
		
        button_image_url: 'images/upload_defaul.png',
		button_placeholder_id : "uploadfile",
        button_height: "28",
        button_width: "88",
		button_cursor : SWFUpload.CURSOR.HAND,
		
		//handler
		file_queued_handler : Uploader_default.Handler.fileQueued,
		file_queue_error_handler : Uploader_default.Handler.fileQueueError,
		upload_complete_handler : Uploader_default.Handler.uploadComplete,
		upload_start_handler : Uploader_default.Handler.uploadStart,
		upload_progress_handler : Uploader_default.Handler.uploadProgress,
		upload_success_handler : Uploader_default.Handler.uploadSuccess

	});

    delete_img();
    function delete_img() {
        $('#deletepic').click(function(){
                var path = $('#product_pic1').val();
                jConfirm('确认删除图片？','确认删除？',function (r){
                    if (r){
                        $.get('services/delete_upload_image.php', {action:'delete',image:path}, function(data){
                                $('#upload1-pic-show').html('');
                                $('#deletepic').hide();
                        });
                    }
                });
        });
    }

    // 删除图片
    del_image();
    function del_image() {
         $('#upload1-pic-show li').bind({
            mouseover:function(){
                $(this).find('.del').eq(0).show();
            },
            mouseout:function(){
                $(this).find('.del').eq(0).hide();
            }
        });

        $('#upload1-pic-show li .del').click(function(){
            var now_li   = $(this).parent();
            var now_path = $(this).attr('rel');
            var path  = $('#product_pic1').val();
            var product_id = $('input[name="product_id"]').val();
            path = path.replace(now_path, '');
            var all_image = path.split('|');
            var target = '';
            for(i=0;i<all_image.length;i++){
                if(all_image[i].length=0) {continue;}
                target = target + all_image[i] + '|';
            }

            target = target.substring(0, (target.length-1));

            $('#product_pic1').val(target);

            jConfirm('确认删除图片？','确认删除？',function (r){
                if (r){
                    $.get('services/delete_upload_image.php', {action:'delete',image:now_path,product:product_id,value:target}, function(data){
                        now_li.hide();
                    });
                }
            });

            return false;
        });
    }

    del_default_image();
    function del_default_image() {
        $('.default_image_show').bind({
            mouseover:function(){
                $(this).find('.del_default_pic').eq(0).show();
            },
            mouseout:function(){
                $(this).find('.del_default_pic').eq(0).hide();
            }
        });


        $('.default_image_show .del_default_pic').click(function(){
            var image_show = $(this).parent();
            var now_path   = $('#defaultpic').val();
            var product_id = $(this).attr('id');
            jConfirm('确认删除图片？','确认删除？',function (r){
                if (r){
                $.get('services/delete_upload_image.php', {action:'delete',image:now_path,product:product_id,target:'default'}, function(data){
                    image_show.find('.del_default_pic').remove();
                    image_show.find('img').remove();
                    image_show.find('input').remove();
                    image_show.html('');
                });   
                }
            });
            return false;
        });
    }
})
