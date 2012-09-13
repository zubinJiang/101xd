<?php
class SupplyPresenter extends InitPresenter {

    public function __init__() {
    
        parent::__init__();
    }


    public function __main__() {

        $user_id = $this->checkLoginStatus(); 

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);
    
    }
}
?>
