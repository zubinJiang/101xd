<?php
class ReleasesuccessPresenter extends InitPresenter
{

    public function __init__() {
    
        parent::__init__();
    }

    public function getContactInfo() {
        if(!isset($_GET['id']) || empty($_GET['id'])) { return; }
        if(!is_numeric($_GET['id'])) { return; }
    
        $id = intval($_GET['id']);
        if($id==0) { return; }

        $info = $this->contact->getContactFromProductId($id);
        
        $this->__p__['contact_info'] = $info;
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->getContactInfo();
    }
}


?>
