<?php
class VipprofessionalPresenter extends InitPresenter
{
    public function __init__() {
    
        parent::__init__();
    }

    public function index($user_id){

        $category = $this->vipcategory->getVipcategoryList();

        $this->__p__['category'] = $category;

        $data = $this->company->getProfessionalData($user_id);

        $this->__p__['data'] = $data;

        if($data['address_id']){

            $address = $this->address->getAddressById($data['address_id']);

            $this->__p__['address'] = $address;

        }

        //var_dump($data);exit;
        if(!empty($_GET['action'])){ return; }

        if($data['id']){

            $company_vip = $this->company->getProfessionalCompany_vip($data['id']);

            $this->__p__['company_vip'] = $company_vip;

        }

        if(!$company_vip){

            $this->redirect("promptstart");

        } 
    }

    public function postComapny($user_id){

        $company['id'] = $_POST['company_id'];
        $company['user_id'] = $user_id;
        if($_POST['category']){
            $category = "";
            foreach($_POST['category'] as $v){
                $category .= $v.',';
            }
        }
        $company['category_id'] = $category;
        $company['desc'] = $_POST['web_desc'];

        return $company;
    }

    function postComapny_vip($user_id){

        $data['id'] = $_POST['company_vip_id'];
        $data['delivery'] = $_POST['delivery'];
        $data['company_id'] = $_POST['company_id'];
        $data['money_local'] = $_POST['money_local'];
        $data['money_net'] = $_POST['money_net'];
        $data['money_time'] = $_POST['money_time'];
        $data['examine_local'] = $_POST['examine_local'];
        $data['examine_net'] = $_POST['examine_net'];
        $data['additional'] = $_POST['additional'];
        $data['remark'] = $_POST['remark'];


        if($_POST['auth_local']){
            $auth_local = "";
            foreach($_POST['auth_local'] as $v){
                $auth_local .= $v.'|';
            }
        }
        
        $data['auth_local'] = $auth_local;

        if($_POST['auth_net']){
            $auth_net = "";
            foreach($_POST['auth_net'] as $v){
                $auth_net .= $v.'|';
            }
        }

        $data['auth_net'] = $auth_net;
        $data['ad'] = $_POST['ad'];
        $data['contact_name'] = $_POST['contact_name'];
        $data['contact_position'] = $_POST['contact_position'];
        $data['contact_mobile'] = $_POST['contact_mobile'];

        return $data;
    }

    
    public function update($user_id){
        
        if($_GET['action']!='update'){ return; }

        if($_POST['address_id']){
            $address_id = $this->address->updateProfessionalAddress($_POST['desc'],$_POST['address_id']);
        } else {
            $address['desc'] =  $_POST['desc'];

            $address_id = $this->address->addData($address);
        }

        $company = $this->postComapny($user_id);

        $company['ddress_id'] = $address_id;

        if($company['id']){
            $company_id = $this->company->updateProfessionalCompany($company);
        } else {

            $company_id = $this->company->insertCompany($company);
        }

        $company_vip = $this->postComapny_vip($user_id);


        if($_POST['company_vip_id']){

            $vip_id = $this->company->updateProfessionalComapny_vip($company_vip);

        } else {

            $vip_id = $this->company->addProfessionalComapny_vip($company_vip);
        }

        if($vip_id && $_GET['type']=='start'){

            $this->redirect("promptend?id={$user_id}");

        } else {

            header('refresh:0.01;url=http://bak.101xd.com/user/vipindex');

            echo "<script>alert('修改成功')</script>";
        }
    }

    public function __main__() {

        $user_id =  $this->checkSysCookie();

        $this->update($user_id);

        $this->index($user_id);
    
    }


}
?>

