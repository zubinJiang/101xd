<?php

class MCompany extends CModel
{  
    public function insertCompany($data) {

        $this->db->table('`company`')->insert($data);

        return  $this->db->last_insert_id();

    }

    public function updateInfo($data) {

        if(empty($data['id'])) {
            $company_id = $this->insertCompany($data);
            return $company_id;

        } else {
            $data = $this->db->exec("update `company` set phone='{$data['phone']}',name='{$data['name']}' where id='{$data['id']}'");
            return $data;
        }
    }

    /**
     * 根据ID获取详细数据
     */
    public function getCompanyById($id) {
        $company = $this->db->table('company')
            ->select('*')
            ->where("id='{$id}'")
            ->getFirst();

        return $company;
    }

    /**
     * news
     * update company data
     */
    function updateCompany($company){

        if(empty($company['id'])){
            $data = $this->insertCompany($company);
        } else {
            $data = $this->db->exec("update `company` set contact_name='{$company['contact_name']}',  position='{$company['position']}', contact_tel='{$company['contact_tel']}', QQ='{$company['QQ']}', postcode='{$company['postcode']}', url='{$company['url']}', category_id='{$company['category_id']}', `desc`='{$company['desc']}', `key`='{$company['key']}', user_id='{$company['user_id']}', address_id='{$company['address_id']}' where id='{$company['id']}'");
        }
        return $data;
    }


    /**
     * 获取专业的渠道商数据
     */

     function getProfessionalData($id){

        $data = $this->db->table('`company`')
            ->select("*")
            ->where("user_id='{$id}'")
            ->getFirst();
        return $data;
    }


    function getProfessionalCompany_vip($id){

        $data = $this->db->table('`company_vip`')
            ->select("*")
            ->where("company_id='{$id}'")
            ->getFirst();
        return $data;
    }

    function updateProfessionalCompany($data){
    

        $ret = $this->db->exec("update `company` set  `desc`='{$data['desc']}', category_id='{$data['category_id']}' where id='{$data['id']}' ");


        return $rzt;
    }

    function addProfessionalComapny_vip($data){
 
        $data = $this->db->table('`company_vip`')->insert($data);

        return  $this->db->last_insert_id();

    }


    function updateProfessionalComapny_vip($data){


        $rzt = $this->db->exec("update `company_vip` set  `delivery`='{$data['delivery']}', money_local='{$data['money_local']}', money_net='{$data['money_net']}', money_time='{$data['money_time']}', examine_local='{$data['examine_local']}', examine_net='{$data['examine_net']}', additional='{$data['additional']}', remark='{$data['remark']}', auth_local='{$data['auth_local']}', auth_net='{$data['auth_net']}', ad='{$data['ad']}', contact_name='{$data['contact_name']}', contact_position='{$data['contact_position']}', contact_mobile='{$data['contact_mobile']}' where id='{$data['id']}' ");

        return $rzt;

    }
    
}

?>
