<?php
class MCompany extends CModel
{
    /**
     * 添加企业数据
     */
    public function addCompany($company) {
    
        $this->db->table('`company`')->insert($company);
        return $this->db->last_insert_id();
    }

    /**
     * 删除用户的企业信息
     */
    public function delCompany($id) {
        $this->db->exec("delete from `company` where id='{$id}'");
    }

    /**
     * 获取vip用户的企业信息
     */
    public function getVipIdCompany($user_id){
    
        $data = $this->db->table('`company`')
            ->select('*')
            ->where("user_id='{$user_id}'")
            ->where('name!=""')
            ->getFirst();

        return $data;
    }


    /**
     * 获取vip用户的企业资质信息
     */
    public function getVipCompany_vip($id){
    
        $data = $this->db->table('`company_vip`')
            ->select('*')
            ->where("company_id='{$id}'")
            ->getFirst();

        return $data;
    }

    public function getUserIDCompany($user_id){

        $data = $this->db->table('`company` c , user u')
            ->select('c.*, u.CompanyID')
            ->where("c.id=u.CompanyID")
            ->where("u.UserID='{$user_id}'")
            ->getFirst();

        return $data;

    }


    function updateCompany($company){

        $data = $this->db->exec("update `company` set contact_name='{$company['contact_name']}',  position='{$company['position']}', contact_tel='{$company['contact_tel']}', QQ='{$company['QQ']}', postcode='{$company['postcode']}', url='{$company['url']}', category_id='{$company['category_id']}', `desc`='{$company['desc']}', `key`='{$company['key']}', user_id='{$company['user_id']}', address_id='{$company['address_id']}' where user_id='{$company['user_id']}'");

        return $data;
    }


    /**
     *
     */
    function updateProfessionalAddress($company){


        $data = $this->db->exec("update `company` set category_id='{$company['category_id']}', 'desc'='{$company['desc']}' where id='{$company['id']}' ");

        return $data;
    }


    function addProfessionalComapny_vip($data){


        $this->db->table('`company_company`')->insert($data);

        return $this->db->last_insert_id();
    
    }
}
