<?php
class BatchPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function upLoadFile()
    {
        if(!empty($_GET['action'])) { return ; }

        $inputName = 'imgFile';
        $dateDir   = date('Ymd');

        $type     = array('rar','zip');
        $fileSize = '512000';

        if (isset($_FILES[$inputName]) && is_uploaded_file($_FILES[$inputName]['tmp_name']) && $_FILES[$inputName]['error'] == 0) {

            $uploadFile = $_FILES[$inputName];
            $fileInfo   = pathinfo($uploadFile['name']);
            $ext        = strtolower($fileInfo['extension']);
            $fileName   = strtolower($fileInfo['filename']);
            if (!(in_array($ext,$type) && ($_FILES[$inputName]['size']/1024) <=$fileSize)) {
                $this->HandleError('StatusCode =-220');
                exit(0);
            }

            //设置上传路径
            $tmp_path   = $this->config['fileupload']['productPath'];
            $uploadPath = $this->config['fileupload']['rootpath'] . $tmp_path . "{$dateDir}/";
            $backPath   = $this->config['fileupload']['urlpath'] . $tmp_path . "{$dateDir}/";
            $this->createDir($uploadPath);

            // $targetName             = $fileName; 
            $targetName  = $dateDir . rand(10000, 99999);
            $uploadFile['name']     = $targetName . '.' . $ext;

            $uploadFile['filename'] = $uploadPath . $uploadFile['name'];

            if (@move_uploaded_file($uploadFile['tmp_name'],$uploadFile['filename'])) {

                header('Content-type: text/html; charset=UTF-8');
                header("Cache-Control:post-check=0,pre-check=0",false);    
                header("Pragma:no-cache");

                exit(json_encode(array('error' => 0,  'url' =>"{$backPath}{$targetName}.{$ext}")));
            }
        }
    }

    public function unzip() {
        if(empty($_GET['action']) || 'unzip'!=$_GET['action']) { return; }
        if(empty($_GET['file'])) { return; }
        $file = trim($_GET['file']);
        $file = str_replace($this->config['fileupload']['urlpath'], $this->config['fileupload']['rootpath'], $file);

        $zip = new ZipArchive() ; 

        if($zip->open($file) !== TRUE) { 
            die ('不能打开压缩文件'); 
        } 

        $tmp  = pathinfo($file);
        $rest = substr($tmp['dirname'], -8);

        $user_id = intval($_GET['id']);
        $tmp['filename'] = $tmp['filename'] . '_' . $user_id;
        $dest= $tmp['dirname'] . '/' . $tmp['filename'];
        $zip->extractTo($dest); 
        $zip->close(); 

        $dest = $rest. '/' .$tmp['filename'] ;

        $python_path = $this->config['fileupload']['pythonPath'];
        $cmd = "python {$python_path}/run.py -t uploadxls -p {$dest}/ -u {$user_id} independent";
        $this->test($cmd);
        $output = array();
        $last_line = exec($cmd, $output, $retval);
        exit;
    }

    public function test($test) {
    
        $fp=fopen("/var/log/batch_upload.log","w");
        $date = date('Y-m-d H:i:s',time());
        fwrite($fp,$date . ' --- ' . $test);
        fclose($fp);
    }

    public function __main__() {
        $this->upLoadFile();
        $this->unzip();
    }

}
?>
