<?php
class LoginPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();
    }

    private function userDataCookie($user) {
        $domain = $this->config['cookie']['domain'];

        $time  = time() + 86400*2;
        $value = "{$user['UserID']}|{$user['DateLastActive']}|{$user['Name']}|{$user['UserType']}";
        $value = base64_encode($value);
        setCookie('_d_', $value, $time, '/', $domain); 
    }

    public function login() {
        if(empty($_POST) || empty($_POST['name']) || empty($_POST['pass'])) { return; }

        $name = $_POST['name'];
        $pass = $_POST['pass'];

        $this->__p__['name'] = $name;

        $flag = $this->user->loginByName($name);
        if($flag){
            $p_flag    = $flag['Password'];
            $user_id   = $flag['UserID'];
            $rzt = $this->passWordHash->CheckPassword($pass, $p_flag, 'Vanilla');
            if( FALSE != $rzt ) {

                $this->user->updateLastActiveData($user_id);  //更新登陆时间了次数
                $this->userDataCookie($flag);

                $this->setUserLoginCookie($user_id, $name, $flag['UserType'], $flag['Photo'], $flag['UserType']);

                $domain = $this->config['cookie']['domain'];
                if($_POST['remember']==1){
                    setcookie("user_name", $name, time()+3600*24*7, "/", $domain);
                } 

                $this->writeLog($user_id, null, 'GDN_User', '登陆成功');

                $tmp = $this->user->getUserDataById($user_id);

                $id = intval($_GET['id']);

                if(!$tmp['Complete']) {

                    if(!empty($id)){

                        $this->redirect("registerSuccess?act=complete&id={$id}");

                    } else {

                        $this->redirect('registerSuccess?act=complete&id');

                    }
                }

                if(!empty($_GET['url'])) {
                    $url = $_GET['url'];

                    header("Location:{$url}"); 

                }elseif('tijiao'==$_GET['action']){

                    $this->redirect("vipsupplystepone?id={$id}");

                }elseif('pushstpeone'==$_GET['action']){
                    $this->redirect("puststepone");
                } else{

                    $this->redirect('/');
                }
                exit;

            }  else {
                $this->writeLog($user_id, null, 'GDN_User', '密码有误');
                $this->__p__['error_pass_msg'] = '您输入的密码不正确，请重新输入！';
            }
            
        } else {
            $this->writeLog('', null, 'GDN_User', '用户名不存在');
            $this->__p__['error_name_msg'] = '您输入的帐号不存在，请重新输入！';
        }
    }
    
    public function __main__() {

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if($this->checkSysCookie()) {
            $this->redirect('/');
        }

        $this->login();
    }
}
