<?php
class AccountPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function passwordReset($user_id){
        if(!isset($_GET['action']) || 'password'!=$_GET['action']) { return; }
        if(!isset($_GET['old_pass']) || empty($_GET['old_pass'])) { return; }
        if(!isset($_GET['news_pass']) || empty($_GET['news_pass'])) { return; }
        if(!isset($_GET['again_pass']) || empty($_GET['again_pass'])) { return; }

        $old_pass   = $_GET['old_pass'];
        $news_pass  = $_GET['news_pass'];
        $again_pass = $_GET['again_pass'];

        if($news_pass != $again_pass){ 
            echo json_encode(array('id'=>2, 'result'=>'确认密码与新密码不一致！'));
            exit;
        }

        $pass      = $this->user->getUserData($user_id);
        $flag_pass = $pass['Password'];

        $rzt = $this->passWordHash->CheckPassword($old_pass, $flag_pass, 'Vanilla');

        if(empty($rzt)) {
            echo json_encode(array('id'=>2, 'result'=>'对不起，您输入的旧密码有误！'));
            exit;
        } else {
            $pass = $this->passWordHash->HashPassword($news_pass);
            $data = $this->user->updateUserPass($pass, $user_id);
            if(!empty($data)) {
                $this->writeLog($user_id, $user_id, 'GDN_User', '修改密码成功');
                
                echo json_encode(array('id'=>1, 'result'=>'密码修改成功！'));
                exit;
            } else {
                $this->writeLog($user_id, $user_id, 'GDN_User', '修改密码失败');
                
                echo json_encode(array('id'=>2, 'result'=>'密码修改失败！'));
                exit;
            }
        }

        exit;
    }

    public function getUserData($user_id) {

        $user   = $this->user->getUserData($user_id);
        $company= $this->company->getCompanyById($user['CompanyID']);

        $user['cid']  = '';
        $user['cname']= '';
        $user['cphone']= '';
        if(!empty($company) && is_array($company)) {
            $user['cid']   = $company['cid'];
            $user['cname'] = $company['cname'];
            $user['cphone']= $company['cphone'];
        }

        $this->__p__['user_data'] = $user;
    }

    public function updateUserData($user_id) {
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }

        $data['cid']     = $_POST['cid'];
        $data['contact'] = $_POST['person_name'];
        $data['com_name']= $_POST['company_name'];
        $data['phone']   = $_POST['phone'];
        $data['mobile']  = $_POST['mobile'];
        $data['qq']      = $_POST['qq'];
        $data['email']   = $_POST['email'];

        // 没有验证email格式
        $company = array(
            'id'   => $data['cid'],
            'name' => $data['com_name'],
            'phone'=> $data['phone']
        );

        $cid = $this->company->updateInfo($company);

        $user['ContactName'] = $data['contact'];
        $user['UserTel']     = $data['mobile'];
        $user['QQ']          = $data['qq'];
        $user['Email']       = $data['email'];

        $user['CompanyID'] = $data['cid'];

        if(intval($cid)>1) {
            $user['CompanyID'] = $cid;
        }

        $this->user->updateUserInfo($user, $user_id);


        $this->__p__['update_info'] = '修改成功!';
    }

    public function updateCookiePhoto($image_path) {

        $sys_cookie = $_COOKIE['_userv_'];
        $sys_cookie = base64_decode($sys_cookie);
        $array_cookie = explode("|", $sys_cookie);

        $domain = $this->config['cookie']['domain'];
        $time  = time() + 86400*2;

        $array_cookie[3] = $image_path;

        $value = "{$array_cookie['0']}|{$time}|{$array_cookie['2']}|{$array_cookie['3']}|{$array_cookie['4']}";
        $value = base64_encode($value);

        setCookie('_userv_', $value, $time, '/', $domain);

        return;
    }

    public function uploadHead($user_id){
        if(!isset($_GET['action']) || 'upload'!=$_GET['action']) { return; }
        if(!isset($_GET['img']) || empty($_GET['img'])) { return; }

        $img   = $_GET['img'];

        if(empty($img)) {
            echo json_encode(array('id'=>2, 'result'=>'请上传好头像后再点击保存！'));
            exit;
        }

        $x     = $_GET['x'];
        $y     = $_GET['y'];
        $width = $_GET['w'];
        $height= $_GET['h'];

        $server_path = $this->config['fileupload']['rootpath'] ;
        $url_path = $this->config['fileupload']['urlpath'] ;

        $config = array();
        $config['image_library']    = 'imagemagick';
        $config['library_path']     = '/usr/bin/';

        $newImg = str_replace($url_path, $server_path, $img);
        $image = new image();
        // crop image
        $cropConfig = $config;
        $cropConfig['width']            = $width;
        $cropConfig['height']           = $height;
        $cropConfig['source_image']     = $newImg;
        $cropConfig['maintain_ratio']   = false;
        $cropConfig['x_axis'] = $x;
        $cropConfig['y_axis'] = $y;

        $image->initialize($cropConfig);
        $image->crop();

        $data = $this->user->updatePhoto($img, $user_id);
        
        // set image path to cookie
        $this->updateCookiePhoto($img.'?c='.date('YmdHis'));
        $this->__p__['login_user_photo'] = $img.'?c='.date('YmdHis');

        if(empty($data)) {
            echo json_encode(array('id'=>2, 'result'=>'系统错误，请从新上传！'));
            exit;
        }

        header("Cache-Control:post-check=0,pre-check=0",false);    
        header("Pragma:no-cache");
        echo json_encode(array('id'=>1, 'result'=>'上传成功！', 'img'=> $img.'?c='.date('YmdHis')));
        exit;
    }

    public function __main__() {

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        $user_id = $this->checkLoginStatus();
        //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->passwordReset($user_id);
        $this->uploadHead($user_id);
        $this->updateUserData($user_id);
        $this->getUserData($user_id);
    }

}

?>
