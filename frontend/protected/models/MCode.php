<?php
class MCode extends CModel
{
    public function add($data) {
    
        $this->db->table('`auth_code`')->insert($data);
        return $this->db->last_insert_id();
    }

    public function del($id) {
        $this->db->exec("delete from `auth_code` where id='{$id}'");
    }

    public function get($tel_ip, $type='1') {

        $begin_time = time() - 3600;

        $data = $this->db->table('`auth_code`')
            ->select('*')
            ->where("tel_ip='{$tel_ip}'")
            ->where("insert_date>={$begin_time}")
            ->order('id','desc')
            ->getFirst();

        return $data;
    }
}
