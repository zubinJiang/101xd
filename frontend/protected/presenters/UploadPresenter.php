<?php
class UploadPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function upLoadPhoto(){
        $inputName = 'imgFile';
        $dateDir  = date('Ymd');

        $type      = array('jpg','bmp','gif','png','jpeg');
        $fileSize = '102400';

        if (isset($_FILES[$inputName]) && is_uploaded_file($_FILES[$inputName]['tmp_name']) && $_FILES[$inputName]['error'] == 0) {

            $uploadFile = $_FILES[$inputName];
            $fileInfo   = pathinfo($uploadFile['name']);
            $ext        = strtolower($fileInfo['extension']);
            $fileName   = strtolower($fileInfo['filename']);
            if (!(in_array($ext,$type) && ($_FILES[$inputName]['size']/1024) <=$fileSize)) {
                $this->HandleError('StatusCode =-220');
                exit(0);
            }

            $tmp_path = $this->config['fileupload']['localfilePath'];

            $uploadPath = $this->config['fileupload']['rootpath'] . $tmp_path . "{$dateDir}/";
            $backPath   = $this->config['fileupload']['urlpath'] . $tmp_path . "{$dateDir}/";
            $this->createDir($uploadPath);

            $targetName  = $dateDir . rand(10000, 99999);
            $uploadFile['name']     = $targetName . '.' . $ext;

            $uploadFile['filename'] = $uploadPath . $uploadFile['name'];

            if (@move_uploaded_file($uploadFile['tmp_name'],$uploadFile['filename'])) {

                $picId = $this->importIntoMeta($dateDir,$uploadFile['filename'],$targetName,$ext);

                header('Content-type: text/html; charset=UTF-8');
                header("Cache-Control:post-check=0,pre-check=0",false);    
                header("Pragma:no-cache");
                exit(json_encode(array('error' => 0,  'id' => $picId, 'url' =>"{$backPath}{$targetName}.{$ext}", 'aurl'=>$backPath.$targetName.'_660X420.'.$ext, 'burl'=>$backPath.$targetName.'_300X250.'.$ext)));
            }
        }
    }

    public function importIntoMeta($dateDir,$uploadFileName,$fileName,$ext,$targetDir=''){
        if(empty($targetDir)) {
            $targetDir = $this->config['fileupload']['localfilePath'];
        }

        $newFile    = $this->resizeImage(660,420,$uploadFileName,$fileName,$ext,false);

        $newFile    = $this->resizeImage(300,250,$uploadFileName,$fileName,$ext,false);

        return ;
    }

    //editor 浏览文件
    public function fileBrowse() {
        if (!isset($_GET['action']) || $_GET['action'] != 'fileBrowse') return;

        $root_path = $this->config['fileupload']['rootpath'] . $this->config['fileupload']['localfilePath'];
        $root_url  = $this->config['fileupload']['urlpath']  . $this->config['fileupload']['localfilePath'];
        $ext_arr   = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

        if (empty($_GET['path'])) {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . '/' . $_GET['path'];
            $current_url = $root_url . $_GET['path'];
            $current_dir_path = $_GET['path'];
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }

        $filter = 'all';
        if (!empty($_GET['filter'])) {
            $filter = trim($_GET['filter']);
        } 

        //排序形式，name or size or type
        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);

        //不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit;
        }
        //最后一个字符不是/
        if (!preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit;
        }
        //目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit;
        }

        //遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.') continue;

                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                } else {

                    if (!empty($filter) && ($filter!= 'all')) {

                        if ('original' == $filter) {

                            if (preg_match('#_(\d+)X(\d+)#i', $filename)) continue;
                        } else {

                            if (!preg_match("#{$filter}#i", $filename)) continue;
                        }
                    }

                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(array_pop(explode('.', trim($file))));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
    }

    public function __main__() {

        $this->upLoadPhoto();

        $this->fileBrowse();
    }
}
?>
