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
            div.innerHTML = '<img src="images/spinner.gif" />&nbsp;资料上传导入中，请稍后。';
            document.getElementById("zip_file").appendChild(div);
		},
		
		uploadProgress: function(file, bytesLoaded, bytesTotal) {
		},
		uploadSuccess: function(file, serverData) {
            var obj = eval('(' + serverData + ')');

            ajaxToUrl(obj.url);
		},
		fileQueueError: function(file, errorCode, message) { 

        },
        uploadError:function (file, errorCode, message) {
                try {
                switch (errorCode) {
                case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
                    this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
                    this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.IO_ERROR:
                    this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
                    this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
                    this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
                    this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
                    // If there aren't any files left (they were all cancelled) disable the cancel button
                    if (this.getStats().files_queued === 0) {
                        document.getElementById(this.customSettings.cancelButtonId).disabled = true;
                    }
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
                    break;
                default:
                    this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                }
            } catch (ex) {
                this.debug(ex);
            }
        }
	}
};

	swfu = new SWFUpload({
		upload_url : "/user/batch",
		flash_url : "/user/images/swfupload.swf",
		file_size_limit : "500 MB",
		file_types : "*.zip;*.rar",
		file_types_description : "All Image Files",
		file_post_name : "imgFile",
        file_upload_limit : 2,

        button_image_url: 'images/batch_product.png',
		button_placeholder_id : "upload1",
        button_height: "35",
        button_width: "133",
		button_cursor : SWFUpload.CURSOR.HAND,
		
		//handler
		file_queued_handler : Uploader.Handler.fileQueued,
		file_queue_error_handler : Uploader.Handler.fileQueueError,
		upload_complete_handler : Uploader.Handler.uploadComplete,
		upload_start_handler : Uploader.Handler.uploadStart,
		upload_progress_handler : Uploader.Handler.uploadProgress,
		upload_success_handler : Uploader.Handler.uploadSuccess,
        upload_error_handler : Uploader.Handler.uploadError

	});

    function ajaxToUrl(url) {
        var id = $('#procedure .magnitude #user_id').val();
        $.get('/user/batch?action=unzip&id='+id+'&file='+url, function(data){
            var loading = document.getElementById('loading');
            document.getElementById("zip_file").removeChild(loading); 
            location.href = '/user/quantity';
        });

        return false;
    }
    
})
