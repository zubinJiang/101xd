<?php
class registerSuccessPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
        NBee::import('app/models/MCode');
        $this->code    = new MCode();
    }

    public function indexAddress() {
        $province = $this->address->provinceList();
        $num_one  = current($province);
        $city     = $this->address->cityListByPid($num_one['id']);

        $category = $this->category->getVipcategoryList();
        $this->__p__['category'] = $category;

        $this->__p__['citys']     = $city;
        $this->__p__['provinces'] = $province;
    }
    public function getCompanyData() {
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

    public function getAddressData() {
        $add_array = array();
        $add_array['province_id'] = $_POST['add_province'];
        $add_array['area_id']     = $_POST['add_city'];
        $add_array['desc']        = $_POST['add_text'];
        $add_array['type']        = 'company';
        
        return $add_array;
    }

    public function addData($user_id) {

        if(!isset($_GET['action']) || 'reg'!==$_GET['action']) { return; }
        
        $act = $_GET['act'];

        $address = $this->getAddressData();
        $company = $this->getCompanyData();

        $address['user_id'] = $user_id;
        $company['user_id']    = $user_id;


        if($act=='complete' && !empty($_POST['address_id'])){

            $address_id = $this->address->updateAddress($address);
            $company['address_id'] = $_POST['address_id'];

        } else {
            $address_id = $this->address->addAddress($address);
            $company['address_id'] = $address_id;
        }

        if($act=='complete' && !empty($_POST['company_id'])){
             $company_id = $this->company->updateCompany($company);

        } else {
            
            $company_id = $this->company->addCompany($company);
            //update user表的企业ID
            $this->user->updateUserCompanyID($company_id, $user_id);
        }


        $address_full=TRUE;
        foreach($address as $v){
            if(empty($v)){
               $address_full = FALSE;
            }
        }

        $company_full=TRUE;
        foreach($company as $v){
            if(empty($v)){
               $company_full = FALSE;
            }
        }

        if(!empty($address_full) && !empty($company_full)){

            $this->user->addUserCompleteAuth($user_id);
        }

        if($address_id || $company_id) {
            $this->writeLog($user_id, $company_id, null, 'company', '完善个人资料成功');

            $id = intval($_GET['id']);

            $tmp = $this->user->getUserDataById($user_id);

            if($tmp['Complete']=='1' && !empty($id)){

                $this->redirect("vipsupplystepone?id={$id}");

            }elseif(!empty($id)){

                $this->redirect("vipsection?id={$id}");
            
            }else{
                $this->redirect('/');
            }
        } else {
            $this->writeLog($user_id, $company_id, null, 'company', '完善个人资料失败');
            if(!empty($address_id)) { $this->address->delAddress($address_id); }
            if(!empty($company_id)) { $this->company->delCompany($company_id); }
            exit('您当前没有做任何修改操作，无需保存！');
        }
        return;
    } 

    public function toUpdate($user_id){

        $company = $this->company->getUserIDCompany($user_id);


        $this->__p__['company'] = $company;

        if(!empty($company['address_id'])){

            $address = $this->address->getUserIDAddress($company['address_id']);

            if(!empty($address['province_id'])) {

                $city_province_list = $this->site->getCityList($address['province_id']);

                
                $this->__p__['citys'] = $city_province_list;
            }

            $this->__p__['address'] = $address;

        }
    
    }
    public function __main__() {

        $user_id = $this->checkSysCookie();

        if(empty($user_id)){
            $this->redirect('/login');
        }

        $this->indexAddress();


        if($_GET['act']=='complete'){

            $this->toUpdate($user_id);
        } 
        $this->addData($user_id);
    }
}

