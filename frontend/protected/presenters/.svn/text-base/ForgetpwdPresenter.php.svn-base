<?php
class ForgetpwdPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function editorPass() {
        if(!isset($_GET['action']) || 'editpass'!=$_GET['action']) { return; }
        if(!isset($_GET['checknum']) || empty($_GET['checknum'])) { return; }
        if(!isset($_GET['user_id']) || empty($_GET['user_id']) || !is_numeric($_GET['user_id'])) { return; }

        $now      = time();
        $checknum = trim($_GET['checknum']);
        $user_id  = intval(trim($_GET['user_id']));
    
        $user = $this->user->getPwdEmail($user_id);

        if(empty($user)) {
            $this->__p__['error'] = '非法链接！';
        }

        $flag = $now - $user['EmailValidateTime'];
        if($flag > 86400) {
            $this->__p__['error'] = '验证超时，请重新用邮件找回密码，并在24小时之内验证！';
        }

        if($checknum!=$user['EmailValidateCode']) {
            $this->__p__['error'] = '邮件验证码错误！';
        }

        $this->__p__['user'] = $user;
    }

    public function resetPass() {
        if(!isset($_GET['action']) || 'edite'!=$_GET['action']) { return; }
        if(empty($_POST['id']) || !is_numeric($_POST['id'])) { return; }
        
        $user_id = intval($_POST['id']);
        $new_pass= trim($_POST['pass']);
        $pass = $this->passWordHash->HashPassword($new_pass);

        $result = $this->user->updatePassWord($pass, $user_id);

        if($result) {
            $this->__p__['msg'] = '重置密码成功！';
        } else {
        
            $this->__p__['error'] = '重置密码失败！';
        }

        $this->__p__['user_name'] = $_POST['username'];
    }

    public function __main__() {
        if(empty($_GET['action']) && empty($_SERVER['HTTP_REFERER'])) {
            header('Location:/forget');
            exit;
        }

        $this->editorPass();
        $this->resetPass();
    }

}

?>
