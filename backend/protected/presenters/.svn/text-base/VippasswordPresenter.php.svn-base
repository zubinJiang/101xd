<?php
class VippasswordPresenter extends InitPresenter
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

    public function __main__() {

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        $user_id = $this->checkLoginStatus();

        $this->passwordReset($user_id);
    }

}

?>

