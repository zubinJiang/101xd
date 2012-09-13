<?php

class MLog extends CModel
{  
    /**
     * 添加日志  
     */
    public function addLogData($data) {
        $this->db->table('`log`')->insert($data);
        return $this->db->last_insert_id();
    }
    
    /**
     * 获取日志列表
     */
    public function getLogByNum($num, $user_id) {
        $list = $this->db->table('`log`')
            ->select('id, user_id, table_name, record, createdate')
            ->where("user_id = {$user_id}")
            ->where("table_name<>'GDN_User'")
            ->order('createdate', 'desc')
            ->getNum($num);
        return $list;
    }
}
?>
