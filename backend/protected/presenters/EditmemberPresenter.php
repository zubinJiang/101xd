<?php
class EditmemberPresenter extends InitPresenter 
{

    public function __init__() {
        parent::__init__();
    }

    public function getUserInfo($user_id) {
        $data = $this->user->getUserRelateData($user_id);

        $this->__p__['user']  = $data;
    }
    //保存编辑的用户信息
    public function SaveEditUserInfo(){
        //user_id=&name=&ip=&usertype=供货商&usertel=&category=&cooperation=4&note=
        /*isset($_POST['user_id']) ? $_POST['user_id']='';
        isset($_POST['name']) ? $_POST['name']='';
        isset($_POST['usertel']) ? $_POST['usertel']='';
        isset($_POST['category']) ? $_POST['category']='';
        isset($_POST['cooperation']) ? $_POST['cooperation']='';
        isset($_POST['note']) ? $_POST['note']='';*/
        $this->user->SaveEditUserInfo($_POST);
        
        }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $flag = $this->hasPermission($user_id, 6, 4);
        if(!$flag) {
            exit('您无权操作此页面');
        }
        if ($_GET['user'] && !($_POST)){
            isset($_GET['user']) ? $_GET['user']:$user_id ; 
            $this->getUserInfo($_GET['user']);
        } else if ($_POST){
            $this->SaveEditUSerInfo();
            $this->redirect('/user/editmember' .'?user='.$_POST['user_id']);
            }
    }

}

?>
