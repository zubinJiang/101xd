<?php
class ProcedurePresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        if(!$this->hasPermission($user_id, 3, 1)) { exit('not auth!'); }
         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->__p__['user_id'] = $user_id ;
    }
}
?>
