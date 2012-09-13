<?php
class MAttention extends CModel
{

    public function doAttention($user_id, $publish_id) {
        $tmp = $this->db->table('`attention_publishers`')
            ->where("user_id='{$user_id}'")
            ->where("publisher_id='{$publish_id}'")
            ->getFirst();

        if(!empty($tmp)) {
            return $this->db->exec("update `attention_publishers` set status=1 where id='{$tmp['id']}'");
        }

        $data = array(
            'user_id' => $user_id,
            'publisher_id' => $publish_id
        );

        $this->db->table('`attention_publishers`')->insert($data);
        $id = $this->db->last_insert_id();

        if($id<=0) { return false; }

        return true;
    }

    public function getAttention($user_id, $publish_id) {
        $tmp = $this->db->table('`attention_publishers`')
            ->where("user_id='{$user_id}'")
            ->where("publisher_id='{$publish_id}'")
            ->getFirst();

        if(!empty($tmp)) {
            if($tmp['status']) {
                return true;
            }
        }
        return false;
    }

    public function cancelAttention($user_id, $publish_id) {
        $tmp = $this->db->table('`attention_publishers`')
            ->where("user_id='{$user_id}'")
            ->where("publisher_id='{$publish_id}'")
            ->getFirst();

        if(empty($tmp)) { return FALSE;}

        return $this->db->exec("update `attention_publishers` set status=0 where id='{$tmp['id']}'");
    }

    public function getAttentionedCount($publish_id) {
         $tmp = $this->db->table('`attention_publishers`')
            ->where("publisher_id='{$publish_id}'")
            ->where("status=1")
            ->getCount();

         return $tmp;
    }
}