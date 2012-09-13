<?php

class AuthorizedPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();
    }

    public function getRole() {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $role_id = intval($_GET['id']);

        $role = $this->role->getRoleById($role_id);

        $this->__p__['role'] = $role;
    }

    public function moduleData() {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $role_id = intval($_GET['id']);

        $data = $this->module->getDataList();
        foreach($data as $k => $v) {

            $permission = $this->role->getPermission($role_id, $v['id']);

            $data[$k]['permission'] = isset($permission['permission']) ? $permission['permission'] : 0;
        }

        $this->__p__['form'] = $data;
    }

    public function updateAuthor() {
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }
        $data = $this->module->getDataList();

        $role_id = intval($_GET['id']);

        $tmp = array();
        foreach($data as $v) {
            $tmp[$v['id']] = $_POST[$v['ename']];
        }

        if(!empty($tmp)) {
            foreach($tmp as $k=>$v) {
                $permission = 0;
                if(!empty($v)) {
                    foreach($v as $value) {

                        $permission = $permission | $value;
                    }
                }

                $temp_data = array(
                    'role_id'   => $role_id,    
                    'module_id' => $k,
                    'permission'=> $permission,
                );
                $this->role->updatePermission($temp_data);    
            }
        }

        $this->redirect('authorized?id=' . $role_id);
    }

    public function __main__() {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
            exit('参数错误');
        }

        $user_id = $this->checkLoginStatus();
        if(!$this->hasPermission($user_id, 8, 4)) { exit('not auth!'); }

        //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->updateAuthor();
        $this->getRole();
        $this->moduleData();

    }

}


?>
