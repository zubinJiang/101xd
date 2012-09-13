<?php
class MCategory extends CModel
{

	public function getFirstTree() {

		$data = $this->db->table('category')
            ->where("level=1")
            ->order('id','asc')
			->getList();

		return $data;
	}

	public function getById($id) {

		$tmp = $this->db->table('`category`')
			->where("id='{$id}'")
			->getFirst();
		
		$sub_category = $this->db->table('`category`')
			->where("left_id BETWEEN {$tmp['left_id']} and {$tmp['right_id']}")
			->order('right_id','desc')
			->getList();
		
		return $sub_category;
    }

    public function getListData(){

        $data = $this->db->table('category')
            ->select('id,name')
			->where("id>4")
            ->getList();
        return $data;
    }

    /* 
     * vip categoryList
     */
    function getVipcategoryList(){

        $data = $this->db->table('`vipcategory`')
            ->select('*')
            ->order("id",'asc')
            ->getList();

        return $data;
    
    } 

}
