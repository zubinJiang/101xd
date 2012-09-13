<?php
class MSms extends CModel
{

    /**
     * 添加短信
     */
    public function addSms($data) {
        $data['insert_date'] = date('Y-m-d H:i:s', time());
        
        $this->db->table('`sms`')->insert($data);
        return $this->db->last_insert_id();
    }

    /**
     * 获取短信列表
     */
    public function getDataList($user_id, $page=1, $num=10) {
    
        $list = $this->db->table('`sms`')
            ->where('status<>4')
            ->where("user_id='{$user_id}'")
            ->getNum($num, ($page-1)*$num);
    
        $count = $this->getCount($user_id);

        $data = array('list'=>$list, 'count'=>$count);

        return $data;
    }

    /**
     * 获取短信条数
     */
    private function getCount($user_id) {
    
        $count = $this->db->table('`sms`')
            ->where("user_id='{$user_id}'")
            ->getCount();

        return $count;
    }

    /**
     * 删除短信
     */
    public function userDelSms($user_id, $sms_id) {
        return $this->db->exec("update `sms` set status=4 where id='{$sms_id}' and user_id='{$user_id}'");
    }
}
