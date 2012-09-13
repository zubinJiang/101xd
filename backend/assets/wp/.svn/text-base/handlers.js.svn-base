/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileQueued(file) {

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("您选择的附件太多了.\n" + (message === 0 ? "已经达到上传的最大限制数." : "您能选择" + (message > 1 ? "到" + message + " 文件." : "一個文件.")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("文件太大.");
			this.debug("错误代码: 文件太大, 文件名: " + file.name + ", 大小: " + file.size + ", 错误讯息: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("不能上传空文件.");
			this.debug("错误代码: 空文件, 文件名: " + file.name + ", 大小: " + file.size + ", 错误消息: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("错误的文件类型.");
			this.debug("错误代码: 错误的文件类型, 文件名: " + file.name + ", 大小: " + file.size + ", 错误消息: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("Unhandled Error");
			}
			this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 大小: " + file.size + ", 错误消息: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
    
    this.startUpload();
}


function uploadStart(file) {
        
    return true;
}


function uploadProgress(file, bytesLoaded, bytesTotal) {
}

function uploadSuccess(file, serverData) {
	try {
        var obj = eval('(' + serverData + ')');
        var li = document.createElement('li');
        li.innerHTML = '<a href="'+obj.aurl+'"><img src="'+obj.url+'" width="100" height="100"></a>';
        document.getElementById(this.customSettings.picshowTarget).appendChild(li);
        var value = document.getElementById(this.customSettings.picinputTarget).value;
        if(value.length>0) {
            document.getElementById(this.customSettings.picinputTarget).value = value + '|' + obj.url;
        } else {
            document.getElementById(this.customSettings.picinputTarget).value = obj.url;
        }

	} catch (ex) {
		this.debug(ex);
	}
        //$('#upload1-picone a').lightBox();
}

function uploadError(file, errorCode, message) {
	try {

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("上传错误: " + message);
			this.debug("错误代码: HTTP 错误, 文件名: " + file.name + ", 错误信息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("上传失败.");
			this.debug("错误代码: 上传失败, 文件名: " + file.name + ", 大小: " + file.size + ", 错误信息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("服务器IO错误");
			this.debug("错误代码: IO 错误, 文件名: " + file.name + ", 大小: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("安全性错误");
			this.debug("错误代码: 安全性错误, 文件名: " + file.name + ", 错误信息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("上传超过限制.");
			this.debug("错误代码: 上传超过上限, 文件名: " + file.name + ", 大小: " + file.size + ", 错误信息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("验证失败. 跳过上传.");
			this.debug("错误代码: 文件验证失败, 文件名: " + file.name + ", 大小: " + file.size + ", 错误信息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("取消");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("停止");
			break;
		default:
			progress.setStatus("未处理错误: " + errorCode);
			this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 大小: " + file.size + ", 错误信息: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		//document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}
