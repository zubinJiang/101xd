<?php

class MReviewe extends CModel
{
    //获取产品的审核状态数据
    public function GetProductStatus($product_id){
        $res = $this ->db-> table('product')
            ->select('id, title, auth')
            ->getItem('id', $product_id);
        return $res;
    }

    //获取产品列表,获取一个产品审核的列表 
    public function GetRevieweList() {
        $res = $this->db->table('product') -> select('*')-> GetList(); 
        return $res;
    }

    /**
     * 根据ID获取产品的数据
     */
    public function getRevieweProductId($product_id) {

        $product=$this->db->table('product')->getItem('id', $product_id);
        return $product;
    }

    /**
     * 审核产品 
     * 0 vip 供货
     * 1 通过
     * 2 未通过
     */
    public function revieweProductProcess($user_id, $product_id, $status_code){
        $product=$this->getRevieweProductId($product_id);
        $mess_log = array(
                'type'       => '2',
                'sender_id'  => $user_id,
                'receiver_id'=> intval($product['user_id']),
                'status'     => '0'
        );
        if(1==$status_code) {
            $res = $this->db->exec("update product set auth='{$status_code}',status='1' where id='{$product_id}'");
            $mess_log['maintext']="已通过审核：" . $product['title'];
        } elseif (2==$status_code) {
            $mess_log['maintext']="未通过审核：" . $product['title'];
        } else {
            $res = $this->db->exec("update product set vip='1' where id='$product_id'");
            $mess_log['maintext']="vip供货：" . $product['title'];
        }

        $this->db->table('`message`')->insert($mess_log);
        $this->db->exec("update `user` set CountMessages=CountMessages+1 where UserID='{$product['user_id']}'");
        return $res;
    } 

    /*
     * 获得数据的列表和总条数
     * page_show 每页显示的条数
     * page_id 当前页数
     * auth 当前商品状态
     * key 搜索的关键字
     * type 搜索的类型(1 为商品标题 2 发布人)
     */
    public function getRevieweProductList($page_id,$page_show,$auth=0,$key=null, $type=1) {
        $authCond = 'p.auth<>1';
        if($auth) { $authCond = 'p.auth=1'; }
        $keyCond = false;
        if(!empty($key)) {
            if($type==2) {
                $keyCond = "gu.Name like '%{$key}%'";
            } else {
                $keyCond = "p.title like '%{$key}%'";
            }
            $authCond= false;
        }
        $start = (intval($page_id)-1)*$page_show;
        $data = $this->db->table('product p,user gu') 
            ->select('p.id,p.title,p.insertdate,p.auth,p.status,gu.Name,p.recommend,p.vip')
            ->where('p.status<>4')
            ->where('p.user_id=gu.UserID')
            ->where($authCond)
            ->where($keyCond)
            ->order('p.insertdate','desc')
            ->getNum($page_show, $start);

        $count = $this->db->table('product p,user gu') 
            ->where('p.status<>4')
            ->where('p.user_id=gu.UserID')
            ->where($authCond)
            ->where($keyCond)
            ->getCount();

        $arr = array('data'=>$data, 'count'=>$count);

        return $arr;
    }

    /*
     *  推荐商品
     *  1 取消推荐(已推荐状态)
     *  0 推荐商品(未推荐状态)
     */
    public function recommendProductProcess($user_id, $product_id, $status) { 
        $product=$this->getRevieweProductId($product_id);
        $mess_log = array(
                'type'       => '2',
                'sender_id'  => $user_id,
                'receiver_id'=> intval($product['user_id']),
                'status'     => '0'
        );
        if ($status==1) {
            $mess_log['maintext']= '管理员取消了“' . $product['title']."”商品的推荐。"; 
            $this->db->table('`message`')->insert($mess_log);
            $result = $this->db->exec("update product set recommend='0' where id=".$product_id);
        } elseif($status==0) {
            $mess_log['maintext']="管理员推荐了“" . $product['title'] . '”的商品。'; 
            $this->db->table('`message`')->insert($mess_log);
            $result = $this->db->exec("update product set recommend='1',auth='1',status='1' where id=".$product_id);
        }

        $this->db->exec("update `user` set CountMessages=CountMessages+1 where UserID='{$product['user_id']}'");
        return $result;
    }

    //推荐商品列表
    public function getRecommendList($page,$num) {
        $data = $this->db->table('product p, user gu')
            ->select('p.id,p.title,p.insertdate,p.auth,p.status,gu.Name,p.recommend')
            ->where('p.user_id=gu.UserID')
            ->where("p.recommend='1'")
            ->where("p.auth='1'")
            ->where("p.status='1'")
            ->getNum($num,($page-1)*$num);

        $count = $this->db->table('product p, user gu')
            ->where('p.user_id=gu.UserID')
            ->where("recommend=1")
            ->where("auth='1'")
            ->where("status='1'")
            ->getCount();
        return $arr = array('data'=>$data,'count'=>$count);
    
    }
}
?>
