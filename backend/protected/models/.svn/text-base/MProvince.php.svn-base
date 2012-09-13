<?php
class MProvince extends CModel
{
    /**
     * 根据id获取省份数据
     */
    public function getProvinceById($id) {
        $data = $this->db->table('`province`')
            ->where("id={$id}")
            ->getFirst();

        return $data;
    }

    /*
     * 根据省份id获取城市列表
     */
    public function getCityList($id) {
        $data = $this->db->table('`city`')
            ->select('id, name')
            ->where("province_id={$id}")
            ->getList();
    
        return $data;
    }

    /**
     * 获取省份列表
     */
    public function getProvinceList() {
        $data = $this->db->table('`province`')
            ->order('id', 'desc')
            ->getList();

        return $data;
    }
}
