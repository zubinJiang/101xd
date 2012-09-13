$(function(){
var swfu;
var jcrop_api, boundx, boundy;

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
            document.getElementById("photo_jcop").appendChild(div);
		},
		
		uploadProgress: function(file, bytesLoaded, bytesTotal) {

		},
		uploadSuccess: function(file, serverData) {
            var obj = eval('(' + serverData + ')');
            var loading = document.getElementById('loading');
            document.getElementById("photo_jcop").removeChild(loading);

            var show = '<img src="'+obj.burl+'" id="photo_account_preview" />';
            var photo_show = '<img src="'+obj.burl+'"  id="photo_account" />';
            document.getElementById("photo_show_priview").innerHTML = (show);
            document.getElementById("photo_show_priview").style.width = 130;
            document.getElementById("photo_show_priview").style.height = 130;

            document.getElementById("photo_jcop").innerHTML = (photo_show); 
            document.getElementById("photo_jcop").style.width = 300;
            document.getElementById("photo_jcop").style.height = 250;
            document.getElementById("photo_jcop").style.overflow = 'hidden';
            document.getElementById("upload_photo").value = obj.burl;
            jscrop(); 
		},
		fileQueueError: function(file, errorCode, message) { }
	}
};

	swfu = new SWFUpload({
		upload_url : "/user/upload",
		flash_url : "/user/images/swfupload.swf",
		file_size_limit : "500 KB",
		file_types : "*.jpg;*.jpeg;*.png;*.bmp;*.gif",
		file_types_description : "All Image Files",
		file_post_name : "imgFile",
        file_upload_limit : 1,
		
        button_image_url: 'images/upload_button.png',
		button_placeholder_id : "upload1",
        button_height: "26",
        button_width: "66",
		button_cursor : SWFUpload.CURSOR.HAND,
		
		//handler
		file_queued_handler : Uploader.Handler.fileQueued,
		file_queue_error_handler : Uploader.Handler.fileQueueError,
		upload_complete_handler : Uploader.Handler.uploadComplete,
		upload_start_handler : Uploader.Handler.uploadStart,
		upload_progress_handler : Uploader.Handler.uploadProgress,
		upload_success_handler : Uploader.Handler.uploadSuccess

	});

    function jscrop() {
        $("#photo_account").Jcrop({
            setSelect: [10, 10, 80,80],
            onChange: updatePreview,
            onSelect: updatePreview
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
          var rx = 130 / c.w;
          var ry = 130 / c.h;

          $('#photo_account_preview').css({
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

    $('.portrait .conserve').click(function(){
        var px  = $('#x').val();
        var py  = $('#y').val();
        var pw  = $('#w').val();
        var ph  = $('#h').val();
        var path = $('.portrait #upload_photo').val();
            
        $.getJSON('account',{action:'upload',img:path,x:px,y:py,w:pw,h:ph},function(data){
            var error = $('.portrait .error');
                if(data.id==1) {
                    error.css("color","green");
                    var img = $('#navigation .contorl').eq(0).find('img');
                    img.attr('src',data.img);
                } else {
                    error.css("color","red");
                }
                $('.portrait #photo_jcop').html('<div class="photo_text">请上传头像</div>');
                error.show();
                error.html(data.result);
                return false;
      });
        return false;
    });
})
