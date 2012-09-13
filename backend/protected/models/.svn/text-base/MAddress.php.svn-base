<?php
class MAddress extends CModel
{  
    //添加地址 发布商品
    public function addData($data) {
        $this->db->table('`address`')->insert($data);

        return $this->db->last_insert_id();

    }

    // 更新关联ID 
    public function updateRelatedId($id, $target) {
    
        $this->db->exec("update `address` set related_id='{$target}' where id='{$id}'");
    }

    // 获取地址信息 修改商品信息
    public function getAddressData($id,$type) {
        $data = $this->db->table('`address` as a,`city` as c')
                ->select('a.id as aid,a.province_id,a.area_id,a.desc,a.lat,a.lng,c.id,c.name')
                ->where('a.area_id=c.id')
                ->where("a.id='{$id}' and a.type='{$type}'")
                ->getFirst();
        return $data;
    }

    // 修改地址 修改商品信息
    public function updateData($data, $admin=FALSE) {

        if(empty($data['id'])) {
            $this->db->table('`address`')->insert($data);
            return $this->db->last_insert_id();   

        } else {
            if($admin){
                $result = $this->db->exec("update `address` set province_id={$data['province_id']}, area_id='{$data['area_id']}', `desc`='{$data['desc']}', lat='{$data['lat']}', lng='{$data['lng']}', zipcode='{$data['zipcode']}', type='{$data['type']}' where id='{$data['id']}'");
            } else {
                $result = $this->db->exec("update `address` set province_id='{$data['province_id']}', area_id='{$data['area_id']}', `desc`='{$data['desc']}', lat='{$data['lat']}', lng='{$data['lng']}', zipcode='{$data['zipcode']}', type='{$data['type']}' where user_id='{$data['user_id']}' and id='{$data['id']}'");
            }
        }
        return $data['id'];
    }

    //获取详细地址信息  导入商家
    public function getAddressById($address_id) {
        
        $data = $this->db->table('`address` as a, city as c, province as p')
            ->select('a.id, a.province_id, a.area_id, a.desc, c.id as cid, c.name as cname, p.id as pid, p.name as pname')
            ->where("a.province_id = p.id")
            ->where("a.area_id = c.id")
            ->where("a.id='{$address_id}'")
            ->getFirst();

        return $data;
    }

    /**
     * 
     */

    function updateProfessionalAddress($desc,$id){

        $data = $this->db->exec("update `address` set `desc`='{$desc}' where id='{$id}'");

        return $data;
    }
}

?>
