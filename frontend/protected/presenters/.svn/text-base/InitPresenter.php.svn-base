<?php
class InitPresenter extends CPresenter
{

    public function __init__() {
        NBee::import('app/models/MCategory');
        NBee::import('app/models/MSite');
        NBee::import('app/components/passwordhash');
        NBee::import('app/components/Cookies');
        NBee::import('app/models/MLog');
        NBee::import('app/models/MUser');
        NBee::import('app/models/MProduct');
        NBee::import('app/models/MAttention');
        NBee::import('app/models/MCompany');
        NBee::import('app/models/MAddress');
        NBee::import('app/models/MVipproduct');
        
        NBee::import('plugin/CMptt/1.0/CMptt');
        NBee::import('plugin/CCategory/1.0/CCategory');
        NBee::import('plugin/Page/1.0/Page');

        $this->passWordHash = new PasswordHash(8, 1);

        $this->company   = new MCompany();
        $this->attention = new MAttention();
        $this->address   = new MAddress();
        $this->user      = new MUser();
        $this->cookie    = new Cookies();
        $this->site      = new MSite();
        $this->category  = new MCategory();
        $this->log       = new MLog();
        $this->product   = new MProduct();
        $this->vipproduct   = new MVipproduct();

        if(isset($_GET['action']) && 'logout'==$_GET['action']) {
            $this->logoutSys();
        }

        $pic_path = $this->config['fileupload']['rootpath'];
        $this->__p__['pic_path'] = $pic_path;

        $pic_url = $this->config['fileupload']['urlpath'];
        $this->__p__['pic_url'] = $pic_url;
        $this->rememberUserName();
    }

    public function getUserStatus() {
        $flag = FALSE;
        if($this->checkSysCookie()) {
            $sys_cookie = $_COOKIE['_userv_'];
            $sys_cookie = base64_decode($sys_cookie);
            $array_cookie = explode("|", $sys_cookie);
            if(count($array_cookie)<3) { return false;}

            return $array_cookie["0"];
        }

        return $flag;
    }

    public function checkSysCookie() {

        if(!isset($_COOKIE['_userv_'])) { return false; }

        $sys_cookie = $_COOKIE['_userv_'];
        $sys_cookie = base64_decode($sys_cookie);
        $array_cookie = explode("|", $sys_cookie);
        if(count($array_cookie)<3) { return false;}

        $this->__p__['login_user_photo'] = $array_cookie[3];
        $this->__p__['login_user_name'] = $array_cookie[2];

        $flag = false;

        if(!empty($array_cookie['0']) && !empty($array_cookie['2'])) {

            $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
            if($flag) {
                return $array_cookie[0];
            }
        }

        return $flag;

    }

    public function logoutSys() {

        $expiry       = 0;
        $path         = '/';
        $domain       = $this->config['cookie']['domain'];
        $array_cookie = array('_userv_', '_d_');

        foreach($array_cookie as $v) {
            unset($_COOKIE[$v]);

            setcookie($v, "", $expiry, $path, $domain);
            $_COOKIE[$v] = NULL;
        }

        $this->redirect('/');
        exit;
    }

    public function rememberUserName(){

        if(!isset($_COOKIE['user_name'])) { return false; }

        $this->__p__['login_user_name'] = $_COOKIE['user_name'];
    }

    //最新推荐商品
    protected function getRecommendList($type=null){
        $recommend = $this->product->getRecommendList($type);
        $this->__p__['recommed'] = $recommend;
    }

    //最新加入的渠道商 
    protected function getNewUserList() {
        $user = $this->user->getNewsUserList();
        $this->__p__['user'] = $user;
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

    //登录,注册使用
    protected function setUserLoginCookie($user_id, $name, $type, $photo=null, $type=null) {

        $domain  = $this->config['cookie']['domain'];

        $time  = time() + 86400*2;
        $value = "{$user_id}|{$time}|{$name}|{$photo}|{$type}";
        $value = base64_encode($value);
        setCookie('_userv_', $value, $time, '/', $domain);
    }
}
