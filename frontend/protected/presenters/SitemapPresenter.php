<?php
class IndexPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        if(!empty($user_id)){
            $user = $this->user->getUserData($user_id);
            if(1==$user['UserType']) {
                $this->redirect('channelhome');
                exit;
            } else {
                $this->redirect('sellerhome');
                exit;
            }        
        }
    }

}  