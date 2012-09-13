<?php
class channelMaterialPresenter extends InitPresenter
{
    public function __init__() {
    
        parent::__init__();
    }

    public function index($user_id){

        $this->__p__['user_data'] = $this->user->getUserData($user_id);

        $this->__p__['province'] = $this->province->getProvinceList();

        if(!empty($user_data['CompanyID'])){

            $company_data = $this->company->getCompanyById($user_data['CompanyID']);

            $this->__p__['company_data'] = $company_data;

            if(!empty($company_data['address_id'])){
                
                $address_data = $this->address->getAddressById($company_data['address_id']);

                $this->__p__['address_data'] = $address_data;   
            }
        
        }
    }

    public function postUserData($user_id){
        $user = array();
        $user['Name']        = $_POST['user_name'];
        $user['ContactName'] = $_POST['comapny_name'];
        $user['Email']       = $_POST['email'];
        $user['UserTel']     = $_POST['tel'];
        $user['CompanyID']   = $_POST['company_id'];
        $user['UserID']      = $user_id;
        return $user;
    }

    public function postAssressDaata($user_id){

        $add_array = array();
        $add_array['province_id'] = $_POST['add_province'];
        $add_array['area_id']     = $_POST['add_city'];
        $add_array['desc']        = $_POST['address_desc'];
        $add_array['related_id']  = $_POST['company_id'];
        $add_array['type']        = 'company';
        $add_array['id']          = $_POST['address_id'];
        $add_array['user_id']     = $user_id;
        
        return $add_array;
    }
    

    public function postCompanyData($user_id){

        $company = array();
        $company['contact_name'] = $_POST['contact_name'];
        $company['position']     = $_POST['position'];
        $company['contact_tel']  = $_POST['contact_tel']; 
        $company['QQ']           = $_POST['QQ'];
        $company['postcode']     = $_POST['postcode'];
        $company['url']          = $_POST['gro_url'];
        $company['category_id']  = $_POST['category'];
        $company['key']          = $_POST['key'][0];
        $company['desc']         = $_POST['com_desc'];
        $company['address_id']   = $_POST['address_id'];
        $company['id']           = $_POST['company_id'];
        //$company['bak']          = $_POST['bak'];
        if(!empty($_POST['key'][1])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1];
        }
        if(!empty($_POST['key'][2])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1]. "|" . $_POST['key'][2];
        }
        if(!empty($_POST['key'][3])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1]. "|" . $_POST['key'][2]. "|" .$_POST['key'][3];
        }
            
        return $company;
    
    }

    public function update($user_id){

        if(!isset($_GET['action']) || 'update'!==$_GET['action']) { return; }

        $user = $this->postUserData($user_id);
        $userid = $this->user->updateUserData($user);

        $address = $this->postAssressDaata($user_id);
        $address_id = $this->address->updateData($address, TRUE);

        $company = $this->postCompanyData($user_id);
        if(empty($_POST['address_id'])){
            $company['address_id']   = $address_id;
        }
        $company_id = $this->company->updateCompany($company);

        if($userid || $address_id || $company_id){

            echo "OK";
        } else {
            
            echo "NO";
        }
    }

    public function __main__() {

        $user_id =  $this->checkSysCookie();

        $this->index($user_id);

        $this->update($user_id);
    }

}

?>

