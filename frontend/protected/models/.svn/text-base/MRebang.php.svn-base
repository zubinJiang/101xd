<?php
class MRebang extends CModel
{  
    
    public function getListData($sort='bought', $way='desc', $page='1', $num='10', $link=FALSE) {
        $sort_cond = "r.bought";
        if("starttime"==$sort){
            $sort_cond = "r.starttime";
        }elseif ('boughtperhour'==$sort) {
            $sort_cond = "r.boughtperhour";
        }elseif ('sales'==$sort) {
            $sort_cond = "r.Sales";
        }

        $linkCond = false;
        $linkCount= false;
        if($link) {
            $linkCond = 'r.bought>1500';
            $linkCount= 'bought>1500';
        }

        $data = $this->db->table('`rebang` as r , website as w')
            ->select('r.*, w.name as web_name, w.id as web_id, w.RealIP as ip')
            ->where("w.id=r.website_id")
            ->where($linkCond)
            ->order("{$sort_cond}","{$way}")
            ->getNum($num, ($page-1)*$num);

        $count = $this->db->table('`rebang`')
            ->where($linkCount)
            ->getCount();
        $arr = array('data'=>$data, 'count'=>$count);
        return $arr;

    }
}