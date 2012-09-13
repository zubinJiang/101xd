$(document).ready(function(){

    function editor() {
        KE.show({
            id : 'content',
            width: '100%',
            height:'350',
            resizeMode : 1,
            allowFileManager : false,
            //fileManagerJson : '../../../../local?action=fileBrowse&filter=original',
            //fileManagerJsonMine : '../../../../local?action=fileBrowse&filter=175X132',
            imageUploadJson : '/user/upload',
            imageUploadJsonMine : '/user/upload?filter=660X420',
            items : [
				'fullscreen', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
				'removeformat', '|','image', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'link']
        });
    }

    editor();
});
