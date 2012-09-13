<?php

class MBusiness extends CModel
{  

    /**
     * 添加商家数据
     */
    public function addData($data) {

        $this->db->table('`business`')->insert($data);

        return $this->db->last_insert_id();
    }

    /**
     * 根据用户ID获取商家数据
     */
    public function findDataByUserId($user_id, $page=1, $num=10) {
        $data = $this->db->table('`business`')
            ->where("user_id = '{$user_id}'")
            ->getNum($num, ($page-1)*$num);

        return $data;
    }

    /**
     * 根据商家ID获取商家数据
     */
    public function getDataById($business_id) {
    
        $data = $this->db->table('`business`')
            ->select('*')
            ->where("id='{$business_id}'")
            ->getFirst();

        return $data;
    }

    /**
     * 更新商家数据
     */
    public function updateBusinessDataID($id,$data){

        $this->db->table('business')->update($data, "id='{$id}'");
    }

    public function updateData($data, $admin=FALSE) {
    
        if(empty($data['id'])) {
            $this->addData($data);
        } else {
            if($admin){

                $result = $this->db->exec("update `business` set name='{$data['name']}', number_years='{$data['number_years']}',seats='{$data['seats']}',funds='{$data['funds']}',business_area='{$data['business_area']}',address_id='{$data['address_id']}',legal_name='{$data['legal_name']}',legal_tel='{$data['legal_tel']}' where  id='{$data['id']}'");
            } else {

                $result = $this->db->exec("update `business` set name='{$data['name']}', number_years='{$data['number_years']}',seats='{$data['seats']}',funds='{$data['funds']}',business_area='{$data['business_area']}',address_id='{$data['address_id']}',legal_name='{$data['legal_name']}',legal_tel='{$data['legal_tel']}' where user_id='{$data['user_id']}' and id='{$data['id']}'");
            }
            return $result;
        }
    }

    //根据用户id获取商家个数
    public function getCountByUser($user_id) {
    
        $count = $this->db->table('`business`')
            ->where("user_id='{$user_id}'")
            ->getCount();

        return $count;
    }

    /**
     * 获取商家名和对应的分类数据
     */
    public function getNameAndCategory($user_id) {
        $data = $this->db->table('`business`')
            ->select('name, category_id')
            ->where("user_id={$user_id}'")
            ->where('category_id is not null')
            ->getFirst();

        if(!empty($data)) {
            $category = $this->db->table('`category`')
                ->select('name')
                ->where("id='{$data['category_id']}'")
                ->getFirst();

            $data['category_name'] = $category['name'];

            unset($category);
        }

        return $data;
    }
}

?>
