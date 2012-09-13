<?php
session_start();

if ( isset($_GET['action']) && !empty($_GET['action'])) {
    if ('login' != $_GET['action']) exit;

    if(empty($_POST['aname'])) { exit(0);}
    if(empty($_POST['apass'])) { exit(0);}

    $name = trim($_POST['aname']);
    $pass = trim($_POST['apass']);

    NBee::import('app/components/passwordhash');
    NBee::import('app/components/Cookies');
    NBee::import('app/models/MUser');

    $this->passWordHash = new PasswordHash(8, 1);
    $this->user   = new MUser();
    $this->cookie = new Cookies();

    $flag = $this->user->loginByName($name);
        if($flag){
            $p_flag    = $flag['Password'];
            $user_id   = $flag['UserID'];
            $user_type = $flag['UserType'];
            $rzt = $this->passWordHash->CheckPassword($pass, $p_flag, 'Vanilla');
            if( FALSE != $rzt ) {

                $this->user->updateLastActiveTime($user_id);
                $this->userDataCookie($flag);

                $this->setUserLoginCookie($user_id, $name, $flag['UserType'], $flag['Photo']);

                $domain = $this->config['cookie']['domain'];
                if($_POST['remember']==1){
                    setcookie("user_name", $name, time()+3600*24*7, "/", $domain);
                } 

                $this->writeLog($user_id, null, 'GDN_User', '登陆成功');

                if(!empty($_GET['url'])) {
                    $url = $_GET['url'];
                    header("Location:{$url}"); 
                } else {
                    header("Location:index"); 
                }
                exit;

            }  else {
                $this->writeLog($user_id, null, 'GDN_User', '密码有误');
                exit('密码错误！');
            }
            
        } else {
            $this->writeLog('', null, 'GDN_User', '用户名不存在');
            exit('用户名不存在,请注册');

        }

    $time  = time() + 86400*2;
    $value = "{$user_id}|{$time}|{$sina_id}";
    $value = base64_encode($value);
    $domain= $this->config['cookie']['domain'];
    setCookie('_userv_', $value, $time, '/', $domain);

    $this->cookie->_setCookie($user_id, 'Vanilla', $domain);
    $this->cookie->_setCookie($user_id, 'Vanilla-Volatile', $domain);

    $_SESSION['login_user_id']   = $user_id;
    $_SESSION['login_user_name'] = $sina_name;

    echo 1;
    exit;
}
?>
