<?php
class MAddress extends CModel
{
    
    public function addAddress($address) {
        $this->db->table('`address`')->insert($address);

        return $this->db->last_insert_id();
    }

    public function provinceList() {
        return $this->db->table('`province`')->getList();
    }

    public function cityListByPid($province_id) {
        return $this->db->table('`city`')->select('id,name')->where("province_id='{$province_id}'")->getList();
    }

    public function delAddress($address_id) {
        $this->db->exec("delete from `address` where id='{$address_id}'");

        return ;
    }

    public function getVipIdAddress($id){
    
        $data = $this->db->table('`address` a, city c, province p')
            ->select('a.id,a.desc,a.area_id,a.province_id,c.name as c_name,p.name as p_name')
            ->where('a.area_id=c.id')
            ->where('a.province_id=p.id')
            ->where("a.id='{$id}'")
            ->getFirst();
        return $data;
    }

    public function getUserIDAddress($id){

        $data = $this->db->table('`address` a, city c, province p')
            ->select('a.id,a.desc,a.area_id,a.province_id,c.name as c_name,p.name as p_name')
            ->where('a.area_id=c.id')
            ->where('a.province_id=p.id')
            ->where("a.id='{$id}'")
            ->getFirst();
        return $data;
    }

    public function updateAddress($address){

        $data = $this->db->exec("update `address` set province_id='{$address['province_id']}', area_id='{$address['area_id']}', `desc`='{$address['desc']}', user_id='{$address['user_id']}' where user_id='{$address['user_id']}'");

        return $data;
    }
}
