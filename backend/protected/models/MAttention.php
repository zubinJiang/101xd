<?php
class MAttention extends CModel{

    public function getProductID($user_id) {
        $data = $this->db->table('`attention_product`')
            ->select('product_id')
            ->where("user_id={$user_id}")
            ->where('status=1')
            ->getList();
        return $data;
    }
    public function cancelAttentionData($user_id, $id) {

        $result = $this->db->exec("update `attention_product` set status=0 where user_id={$user_id} and id in ({$id})");
        return $result;
    }
   
}
