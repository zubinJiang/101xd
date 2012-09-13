<?php
class MComment extends CModel
{

    public function insertComment($data) {
        if(!is_array($data)) { return FALSE; }

        $this->db->table('`website_comment`')->insert($data);
        $id = $this->db->last_insert_id();

        return $id;
    }
}
