<?php
class InitPresenter extends CPresenter
{

    public function __init__() {

        NBee::import('app/models/MContact');
        NBee::import('app/models/MSite');
        NBee::import('app/models/MProduct');
        NBee::import('app/models/MPayment');
        NBee::import('app/models/MBusiness');
        NBee::import('app/models/MAddress');
        NBee::import('app/models/MAgent');
        NBee::import('app/models/MAttention');
        NBee::import('app/models/MAttentionPublishers');
        NBee::import('app/models/MUser');
        NBee::import('app/models/MLog');
        NBee::import('app/models/MRole');
        NBee::import('app/models/MLink');
        NBee::import('app/models/MModule');
        NBee::import('app/models/MCompany');
        NBee::import('app/models/MMessage');
        NBee::import('app/models/MProvince');
        NBee::import('app/models/MVipproduct');
        NBee::import('app/models/MVipcategory');

        NBee::import('plugin/Image/1.0/Image');
        NBee::import('plugin/CMptt/1.0/CMptt');
        NBee::import('plugin/CCategory/1.0/CCategory');
        NBee::import('plugin/Page/1.0/Page');

        NBee::import('app/components/passwordhash');
        NBee::import('app/components/Cookies');

        $this->province= new MProvince();
        $this->company = new MCompany();
        $this->message = new MMessage();
        $this->userlink= new MLink();

        $this->module  = new MModule();
        $this->role    = new MRole();
        $this->user    = new MUser();
        $this->contact = new MContact();
        $this->site    = new MSite();
        $this->product = new MProduct();
        $this->payment = new MPayment();
        $this->business= new MBusiness();
        $this->address = new MAddress();
        $this->agent   = new MAgent();
        $this->publisher    = new MAttentionPublishers();
        $this->attention    = new MAttention();
        $this->log          = new MLog();
        $this->vipproduct   = new MVipproduct();
        $this->vipcategory  = new MVipcategory();

        $this->passWordHash = new PasswordHash(8, 1);
        $this->cookie       = new Cookies();


        $this->logout();

        $this->__p__['login_flag'] = false;
        if($this->checkSysCookie()) {
            $this->__p__['login_flag'] = true;
        }

        $pic_url = $this->config['fileupload']['urlpath'];
        $pic_path = $this->config['fileupload']['rootpath'];
        $this->__p__['pic_path'] = $pic_path;
        $this->__p__['pic_url']  = $pic_url;
    }

    public function logout() {
        if(!isset($_GET['action']) || 'logout'!=$_GET['action']) { return; }

        $this->logoutSys();

        header("Location:/index");
        exit;
    }

    public function checkSysCookie() {

        if(!isset($_COOKIE['_userv_'])) { return false; }

        $sys_cookie = $_COOKIE['_userv_'];
        $sys_cookie = base64_decode($sys_cookie);
        $array_cookie = explode("|", $sys_cookie);
        if(count($array_cookie)<3) { return false;}

        $this->__p__['login_user_photo'] = $array_cookie[3];
        $this->__p__['login_user_name']  = $array_cookie[2];
        $this->__p__['login_UserType']   = $array_cookie[4];

        $flag = false;
        
        if(!empty($array_cookie['0']) && !empty($array_cookie['2'])) {

            $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
        }

        return $flag;
    }

    private function logoutSys() {

        $expiry       = 0;
        $path         = '/';
        $domain       = $this->config['cookie']['domain'];
        $array_cookie = array('_userv_', '_d_');

        foreach($array_cookie as $v) {
            unset($_COOKIE[$v]);

            setcookie($v, "", $expiry, $path, $domain);
            $_COOKIE[$v] = NULL;
        }
    }


    public function upLoadPhoto()
    {
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

    public function importIntoMeta($dateDir,$uploadFileName,$fileName,$ext,$targetDir='')
    {
        if(empty($targetDir)) {
            $targetDir = $this->config['fileupload']['localfilePath'];
        }

        $newFile    = $this->resizeImage(660,420,$uploadFileName,$fileName,$ext,false);

        $newFile    = $this->resizeImage(300,250,$uploadFileName,$fileName,$ext,false);

        return ;
    }


    public function resizeImage($width,$height,$sourImg,$newImgName,$ext,$crop=true)
    {
        $image = new image();

        $config = array();
        $config['image_library']    = 'imagemagick';
        //$config['image_library']    = 'gd2';
        $config['library_path']     = '/usr/bin/';

        $newImg = dirname($sourImg) . "/{$newImgName}_{$width}X{$height}.{$ext}";

        if ($crop) {

            $imageSize = getimagesize($sourImg);

            $originalWidth  = $imageSize[0];
            $originalHeight = $imageSize[1];

            // resize image
            $resizeConfig   = $config;
            $resizeConfig['source_image']   = $sourImg;
            $resizeConfig['master_dim']     = 'auto';
            if ($originalWidth >= $originalHeight) {
                $resizeConfig['height']     = $height;
            } else {
                $resizeConfig['width']      = $width;
            }
            $resizeConfig['new_image']      = $newImg;
            $resizeConfig['maintain_ratio'] = TRUE;

            $image->initialize($resizeConfig);
            $image->resize();

            // crop image
            $cropConfig = $config;
            $cropConfig['width']            = $width;
            $cropConfig['height']           = $height;
            $cropConfig['source_image']     = $newImg;
            $cropConfig['maintain_ratio']   = false;
            $cropConfig['x_axis'] = '0';
            $cropConfig['y_axis'] = '0';

            $image->initialize($cropConfig);
            $image->crop();

        } else {
        
            $resizeConfig = $config;

            $resizeConfig['source_image']   = $sourImg;
            $resizeConfig['master_dim']     = 'auto';
            $resizeConfig['width']          = $width;
            $resizeConfig['height']         = $height;
            $resizeConfig['new_image']      = $newImg;
            $resizeConfig['maintain_ratio'] = TRUE;

            $image->initialize($resizeConfig);
            $image->resize();
       
        }

        return basename($newImg);
    }

    public function createDir($dir) 
    {
        if (!is_dir($dir)) {
            $temp = explode('/',$dir);
            $cur_dir = '';
            $count = count($temp);

            for($i=0; $i<$count; $i++) {

                $cur_dir .= $temp[$i].'/';
                if (!is_dir($cur_dir)){
                    @mkdir($cur_dir,0777);
                }
            }
        }
    }

    public function HandleError($message) {
        header("HTTP/1.1 500 Internal Server Error");
        echo $message;
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

        //排序
        function cmp_func($a, $b) {
            global $order;
            if ($a['is_dir'] && !$b['is_dir']) {
                return -1;
            } else if (!$a['is_dir'] && $b['is_dir']) {
                return 1;
            } else {

                if ($order == 'size') {
                    if ($a['filesize'] > $b['filesize']) {
                        return 1;
                    } else if ($a['filesize'] < $b['filesize']) {
                        return -1;
                    } else {
                        return 0;
                    }
                    //return ($a['filesize']<$b['filesize']) : (-1) : 1; 
                } else if ($order == 'date') {
                    return strcmp($a['datetime'], $b['datetime']);
                } else if ($order == 'type') {
                    return strcmp($a['filetype'], $b['filetype']);
                } else {
                    return strcmp($b['filename'],$a['filename']);
                }
            }
        }
        usort($file_list, 'cmp_func');

        $result = array();
        //相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        //相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        //当前目录的URL
        $result['current_url'] = $current_url;
        //文件数
        $result['total_count'] = count($file_list);
        //文件列表数组
        $result['file_list'] = $file_list;

        //输出JSON字符串
        header('Content-type: application/json; charset=UTF-8');
        exit(json_encode($result));
    }

    public function getAllPaymentData() {
        $this->__p__['payment'] = $this->payment->getAllDataList(); 
    }

    public function getIndexAdderssData() {
        $this->__p__['province'] = $this->site->getProvinceData();
    }

    public function getCategoryData($num) {
        $this->__p__['category_data'] = $this->product->getProductCateogryList($num);
    }

    public function checkLoginStatus() {

        $user_id = $this->checkSysCookie();
        if(!$user_id) {$this->redirect('/login'); }

        return $user_id;
    }

    protected function writeLog($user_id, $table_id=null, $table_name=null, $record=null) {
        $log_arr = array(
            'user_id'   => $user_id,
            'table_id'  => $table_id,
            'table_name'=> $table_name,
            'record'    => $record
        );
        $this->log->addLogData($log_arr);
    }

    public function getRelativeCount($user_id) {
        $b_count = $this->business->getCountByUser($user_id);
        $c_count = $this->contact->getUserContactCount($user_id);

        $this->__p__['b_count'] = $b_count;
        $this->__p__['c_count'] = $c_count;

        unset($b_count);
        unset($c_count);
    }


    //权限判断
    public function hasPermission($user_id, $module_id, $active_id) {
    
        $umr = $this->user->userRolePermssion($user_id, $module_id);

        if(empty($umr)) { return FALSE; }

        $flag = $umr['permission'] & $active_id;
        if($flag != $active_id) { return FALSE; }

        return TRUE;
    }
}

?>
