<?php
class RolePresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function roleDataList() {
        if(isset($_GET['action'])) { return; }

        $this->__p__['data'] = $this->role->getRoleList();
        $this->__p__['count']= $this->role->getRoleCount();
    }

    public function __main__() {
    
        $user_id = $this->checkLoginStatus(); 
        if(!$this->hasPermission($user_id, 8, 1)) { exit('not auth!'); }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->roleDataList();
    }
}

?>
