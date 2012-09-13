<?php
class UserviewPresenter extends InitPresenter
{
    public function __init__() {
    
        parent::__init__();
    }

    private function userData() {
        if(empty($_GET['id'])) { exit('error');}

        $user_id = intval($_GET['id']);
        $user = $this->user->getUserData($user_id);
        if(empty($user)) { exit('该用户不存在');}

        $this->__p__['user_data'] = $user;

        if(!empty($user['CompanyID'])) {
            $company = $this->company->getCompanyById($user['CompanyID']);
            $this->__p__['company'] = $company;
            if(!empty($company['address_id'])) {
                $this->__p__['address'] = $this->address->getAddressById($company['address_id']);
            }
        }
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();

        $this->userData();
    }

}

?>
