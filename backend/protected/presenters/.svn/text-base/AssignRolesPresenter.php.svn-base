<?php
class AssignRolesPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();
    }

    public function getUserData() {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $user_id   = intval($_GET['id']);

        $user      = $this->user->getUserData($user_id);
        $role_list = $this->role->findRoleByUserId($user_id);
        $data      = $this->role->getRoleList();

        $role_array = explode(',', $role_list[0]['role_id']);
        foreach($data as $k=>$v) {
            if(in_array($v['id'], $role_array)) {
                $data[$k]['check'] = TRUE;
            }
        }
 
        $this->__p__['role_list'] = $data;
        $this->__p__['user']      = $user;
    }

    public function updateRole() {
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $role    = $_POST['role'];
        $user_id = intval($_GET['id']);

        if(!empty($role)) {

            $role_str = implode(',', $role);

            $data = array('user_id'=>$user_id, 'role_id'=> $role_str);
            $this->role->updateUserRole($data);
        }

        $this->redirect('assignRoles?id=' . $user_id);
    }

    public function __main__() {

        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { exit('参数错误.'); }

        $user_id = $this->checkLoginStatus();
        if(!$this->hasPermission($user_id, 7, 2)) { exit('not auth!'); }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->getUserData();
        $this->updateRole();
    }

}

?>
