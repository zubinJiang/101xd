<?php
class MAttentionPublishers extends CModel
{  
    public function getDataList($user_id, $page=1, $num=15, $attention='active') {
        $data = array();

        $attCond = "ap.user_id = {$user_id}";
        $useCond = 'ap.publisher_id = gu.UserID';
        $ignore  =  'ap.status=1';
        if('passive'==$attention) {
            $attCond = "ap.publisher_id = {$user_id}";
            $useCond = 'ap.user_id = gu.UserID';
            $ignore  =  'ap.ignore=0';
        }

        $list = $this->db->table('`attention_publishers` as ap, `user` as gu')
            ->select('ap.id,ap.user_id,ap.publisher_id,ap.status,gu.Name,gu.Photo,gu.Email,gu.CountProducts')
            ->where($ignore)
            ->where($useCond)
            ->where($attCond)
            ->getNum($num, ($page-1)*$num);

        $count = $this->getCount($user_id, $attention);

        $data = array('list'=>$list, 'count'=>$count);

        return $data;
    }

    public function getCount($user_id, $attention='active') {

        $attCond = "user_id = {$user_id}";
        $ignore  = 'status=1';
        if('passive'==$attention) {
            $attCond="publisher_id = {$user_id}";
            $ignore  = "`ignore`=0";
        }

        $count = $this->db->table('`attention_publishers`')
            ->select('publisher_id,status')
            ->where($ignore)
            ->where($attCond)
            ->getCount();
        return $count;
    }

    public function cancelAttention($user_id, $publisher_id, $type='') {

        $column = 'user_id';
        if('by'==$type) {
            $column = 'publisher_id';
        }

        return $this->db->exec("update `attention_publishers` set status=0 where {$column}={$user_id} and id in ({$publisher_id})");
    }

    public function ignoreAttention($user_id, $publisher_id, $type='') {

        $column = 'user_id';
        if('by'==$type) {
            $column = 'publisher_id';
        }

        return $this->db->exec("update `attention_publishers` set `ignore`=1 where {$column}={$user_id} and id in ({$publisher_id})");
    }

    public function cancelIgnore($user_id, $publisher_id){
        return $this->db->exec("update `attention_publishers` set `ignore`=0 where publisher_id={$user_id} and id in ({$publisher_id})");
    }

    public function getQuanList($user_id, $page=1, $num=15) {

        $data = array();

        $list = $this->db->table('`attention_publishers` as ap, `user` as gu')
            ->select('ap.id,ap.user_id,ap.publisher_id,ap.status,gu.Name,gu.Photo,gu.Email,ap.ignore')
            ->where('ap.user_id = gu.UserID')
            ->where("ap.publisher_id= {$user_id}")
            ->order('ap.status','desc')
            ->getNum($num, ($page-1)*$num);

        $count = $this->db->table('`attention_publishers`')
            ->select('publisher_id,status')
            ->where("publisher_id = {$user_id}")
            ->getCount();
        $data = array('data'=>$list, 'sum'=>$count);

        return $data;
    }
   
}

?>
