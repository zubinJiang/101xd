<?php
class MLink extends CModel
{
    /**
     * 添加友情链接
     */
    public function adduserlink($data) {
    
        $day = date('Y-m-d H:i:s', time());
        $data['insert_date'] = isset($data['insert_date']) ? $data['insert_date'] : $day;
        if(empty($data['insert_date'])) {
            $data['insert_date'] = $day;
        }

        $this->db->table('`link`')->insert($data);
        return $this->db->last_insert_id();
    }

    /**
     * 获取友情链接列表
     */
    public function getLinkList($user_id, $page=1, $num=10) {
    
        $list = $this->db->table('`link`')
            ->where("user_id='{$user_id}'")
            ->getNum($num, ($page-1)*$num);
    
        $count = $this->getCount($user_id);

        $data = array('list'=>$list, 'count'=>$count);

        return $data;
    }

    /**
     * 获取链接的数据总数
     */
    private function getCount($user_id) {
    
        $count = $this->db->table('`link`')
            ->where("user_id='{$user_id}'")
            ->getCount();

        return $count;
    }

    /**
     * 删除友情链接
     */
    public function deleteLink($user_id,$id) {
        return $this->db->exec("delete from `link` where id='{$id}' and user_id='{$user_id}'");
    }
}
