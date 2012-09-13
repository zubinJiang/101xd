<?php
class VipsectionPresenter extends InitPresenter
{

    public function __init__() {
  
        parent::__init__();
 
    }

    public function index($user_id){

        $company = $this->company->getVipIdCompany($user_id);

        if(!empty($company['address_id'])){
            $address =  $this->address->getVipIdAddress($company['address_id']);
            $this->__p__['address']     = $address;
        }

        if(!empty($company['website_id'])){
            $website     = $this->site->getVipIdWebsite($company['website_id']);
            $this->__p__['website']     = $website;
        }

        if(!empty($company['id'])) {
            $company_vip = $this->company->getVipCompany_vip($company['id']);
            $this->__p__['company_vip'] = $company_vip;
        }
    
        $this->__p__['company']     = $company;
       
    }

    public function Complete(){

        if('Complete'!=$_GET['action']){ return; }


        $user_id = $this->checkSysCookie();

        $tmp = $this->user->getUserDataById($user_id);
        
        if(!$tmp['Complete']) {

            echo false;
            //$this->redirect("registerSuccess?act=complete&id={$id}");

        } else {

            echo true;
        
        }
        exit;
    }

    public function __main__() {


        $user_id = $this->checkSysCookie();

        $this->__p__['user_id'] = $user_id;

        $this->Complete();

        if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->redirect('/');
        } else {
            $id = $_GET['id'];
        }


        $this->index($id);

        
    }

}
