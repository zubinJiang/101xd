<?php
class MWeb extends CModel
{
    public function findUserByEmail($email) {
    
        $data = $this->db->table('`website_guide`')
            ->select('id,name,url')
            ->where("1")
            ->getNum(5,1);
		return $data;
    }

}
