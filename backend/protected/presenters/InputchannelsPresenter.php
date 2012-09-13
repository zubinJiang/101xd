<?php
class InputchannelsPresenter extends InitPresenter 
{

    public function __init__() {
        parent::__init__();
        //NBee::import('app/models/MCode');
    }

    public function GetSuggestUsername($q) {
        $res = $this->user->GetSuggestUsername($q);
        echo json_encode($res);
        exit;
    }
    public function CheckUserExist($username){
        
        $res = array();
        $res['status'] = $this->user->CheckQuDaoUserByName($username);
        echo json_encode($res);
        exit;
    }
    public function AddVipPage($users){
        $res=array();
        foreach($users as $user){
            if(!empty($user)){
                $r=$this->user->AddVipPage($user);
                array_push($res,$r);
            }
        };
        echo json_encode($res);
        exit;
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();

        $flag = $this->hasPermission($user_id, 6, 1);
        if(!$flag) {
            exit('您无权操作此页面');
        }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q'])){
            $this->GetSuggestUsername($_GET['q']);
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action']=='addvippage'){
            $users = json_decode($_GET['users']);
            $this->AddVipPage($users);
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action']=='checkuser'){
            $username = $_GET['username'];
            $this->CheckUserExist($username);
        }

    }

}

?>
