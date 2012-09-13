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
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("加載...");

		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("您選擇的附件太多了.\n" + (message === 0 ? "已經達到了上傳的最大限制數." : "您能選擇 " + (message > 1 ? "到" + message + " 文件." : "一個文件.")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("文件太大.");
			this.debug("錯誤代碼: 文件太大, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤訊息: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("不能上傳空文件.");
			this.debug("錯誤代碼: 空文件, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤消息: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("錯誤的文件類型.");
			this.debug("錯誤代碼: 錯誤的文件類型, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤消息: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("Unhandled Error");
			}
			this.debug("錯誤代碼: " + errorCode + ", 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤消息: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
    
        try {
            if (numFilesSelected > 0) {
                document.getElementById(this.customSettings.cancelButtonId).disabled = false;
            }
		
            if(confirm('您確認要提交嗎?')) { 
                this.startUpload();
            } else {
                swfu.cancelQueue();
            }
        } catch (ex)  {
            this.debug(ex);
        }
}


function uploadStart(file) {
        try {
        /* I don't want to do any file validation or anything,  I'll just update the UI and
        return true to indicate that the upload should start.
        It's important to update the UI here because in Linux no uploadProgress events are called. The best
        we can do is say we are uploading.
         */
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setStatus("加載中...");
            progress.toggleCancel(true, this);
        } catch (ex) {

        }
    
        return true;
}


function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("加載中...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
        if (typeof KEInsertImageFun != undefined && KEInsertImageFun) {
            json = eval('('+serverData+')');
            if (json.error == 0) {
                KEInsertImageFun(json.url);
            }
        }

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("Complete.");
		progress.toggleCancel(false);

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("上傳錯誤: " + message);
			this.debug("錯誤代碼: HTTP 錯誤, 文件名: " + file.name + ", 錯誤訊息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("上傳失敗.");
			this.debug("錯誤代碼: 上傳失敗, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤訊息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("服務器 (IO) 錯誤");
			this.debug("錯誤代碼: IO 錯誤, 文件名: " + file.name + ", 大小: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("安全性錯誤");
			this.debug("錯誤代碼: 安全性錯誤, 文件名: " + file.name + ", 錯誤訊息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("上傳超過限制.");
			this.debug("錯誤代碼: 上傳超過上線, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤訊息: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("驗證失敗.  跳過上傳.");
			this.debug("錯誤代碼: 文件驗證失敗, 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤訊息: " + message);
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
			progress.setStatus("未處理錯誤: " + errorCode);
			this.debug("錯誤代碼: " + errorCode + ", 文件名: " + file.name + ", 大小: " + file.size + ", 錯誤訊息: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {

		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	var status = document.getElementById("divStatus");
	status.innerHTML = numFilesUploaded + " 個文件已經上傳.";
}
