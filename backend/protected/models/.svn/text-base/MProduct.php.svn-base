<?php
class MProduct extends CModel
{
    /**
     * 移动商品
     * target_ca 父类(local, net)
     * target_cid 二级分类
     */
    public function changeCategory($id, $target_ca='local', $target_cid=5) {
        $result = $this->db->exec("update `product` set category='{$target_ca}', category_id={$target_cid} where id='{$id}'");
    
        return $result;
    }

    public function getProductViewData($id) {
        $first = $this->db->table('`product`')
            ->select('id,user_id,title,storage,amount_max,amount_per,market_price,supply_price,product_abstract,description,image,receive_id')
            ->where("id = {$id}")
            ->getFirst();

        return $first;
    }

    public function getProductById($id) {
        $first = $this->db->table('`product` p , `category` c')
            ->select('p.id,p.user_id,p.title,p.category, p.category_id, c.name as cname')
            ->where('p.category_id = c.id')
            ->where("p.id = {$id}")
            ->getFirst();

        return $first;
    }

    public function getFirstData($user_id) {
        $first = $this->db->table('`product`')
            ->select('id,title,image')
            ->where("user_id = {$user_id}")
            ->order('insertdate', 'desc')
            ->getNum(1,0);

        return $first;
    }

    public function getCount($user_id) {
        $count = $this->db->table('`product`')
            ->where('status<>4')
            ->where("user_id = {$user_id}")
            ->getCount();

        return $count;
    }

    //根据标题获得百度热门相关关键字，返回字符串 
    public function baiduKeyword($title,$num=5,$charset="UTF-8"){ 

        $title=iconv($charset, "GB2312", $title); 
        $w = file_get_contents('http://www.baidu.com/s?wd='.urlencode($title).'&tn=baidu'); 

        $arr= array("\n", "\r", "\r\n");
        $w=str_replace($arr,"",$w);
        preg_match_all('|<div id="rs">(.*)</div>|isU',$w,$con); 
        $list=$con[1][0]; 
        preg_match_all('#<a.+?href="(.+?)".*?>(.+?)</a>#', $list, $content);
        $c = $content[2];
        $r=array_slice($c, 0, $num);   
        $result=implode(" ", $r); 
        $result=iconv("GB2312", $charset,$result); 

        return $result; 
    }

    public function addProductData($data){

        if(empty($data['keywords'])) {
            $title = $data['title'];
            if(strlen($data['title'])>38) {
                $title = mb_substr($data['title'], 0, 38,"utf-8");
            }

            $key = $this->baiduKeyword($title);
            $data['keywords'] = $key;
            unset($title);
            unset($key);
        }

        $data['insertdate'] = date("Y-m-d H:i:s");
        $this->db->table('`product`')->insert($data);

        $this->db->exec("update `user` set CountProducts=CountProducts+1 where UserID='{$data['user_id']}'");

        return $this->db->last_insert_id();
    }

    public function getDataList($user_id, $status=1, $type=null, $page=1, $num=15, $order=1,$admin=false) {

        $cond       = false;
        $dateCond   = false;
        $statusCond = false;
        $type_cond = false;

        if($status==1){
            $time = time();
            $cond = "p.auth=1";  //已通过
            $statusCond = 'p.`status`=1';
            $dateCond = "(p.expire_date>$time or p.expire_date='0')"; //未过期
        } elseif(2==$status) {
            $cond = "auth=2";  //未通过
            $statusCond = 'p.`status`<>4';
        } elseif(3==$status) {
            $cond = "auth=0";  //审核中
            $statusCond = 'p.`status`<>4';
            $time = time();
            $dateCond = "(p.expire_date>$time or p.expire_date='0')"; //未过期
        } elseif(4==$status) {
            $time = time();
            $cond = "p.expire_date<$time and p.expire_date<>0"; //已过期
        } elseif(6==$status) {     // 下架
            $statusCond = 'p.`status`=0';
        } elseif(5==$status) {
            $time = time();
            $statusCond = 'p.`status`<>4';
            $cond =true;
        }

        if('local'==$type) {
            $type_cond = "p.category='local'";
        } elseif('net'==$type) {
            $type_cond = "p.category='net'";
        } elseif('goldroll'==$type) {
            $type_cond = "p.category='goldroll'";
        } else {
            $type_cond = true;
        }

        if($admin==true){

            $user_id_comd = false;
            
        } else {

            $user_id_comd = "p.user_id={$user_id}";
        }

        $start = intval($page-1) * $num;
        if(2==$order) {  //添加时间倒序
            $list = $this->db->table('`product` p, `user` u')
                ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.insertdate,p.default_image,p.image,p.auth,p.expire_date,p.status,p.batch,p.user_id,u.UserID,u.Name')
                ->where("p.user_id=u.UserID")
                ->where($cond)
                ->where($type_cond)
                ->where($statusCond)
                ->where($user_id_comd)
                ->order('insertdate','desc')
                ->getNum($num, $start);
        } elseif(3==$order){ //访问量倒序
            $list = $this->db->table('`product` p, `user` u')
                 ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.insertdate,p.default_image,p.image,p.auth,p.expire_date,p.status,p.batch,p.user_id,u.UserID,u.Name')
                ->where("p.user_id=u.UserID")
                ->where($cond)
                ->where($type_cond)
                ->where($statusCond)
                ->where($user_id_comd)
                ->order('visits','desc')
                ->getNum($num, $start); 
        } elseif(4==$order){ //访问量顺序
            $list = $this->db->table('`product` p, `user` u')
                 ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.default_image,p.insertdate,p.image,p.auth,p.expire_date,p.status,p.batch,p.user_id,u.UserID,u.Name')
                ->where("p.user_id=u.UserID")
                ->where($cond)
                ->where($type_cond)
                ->where($statusCond)
                ->where($user_id_comd)
                ->order('visits','asc')
                ->getNum($num, $start);
        } else {  // 创建时间倒序
            $list = $this->db->table('`product` p, `user` u')
                 ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.default_image,p.image,p.insertdate,p.auth,p.expire_date,p.status,p.batch,p.user_id,u.UserID,u.Name')
                ->where("p.user_id=u.UserID")
                ->where($cond)
                ->where($type_cond)
                ->where($dateCond)
                ->where($statusCond)
                ->where($user_id_comd)
                ->order('insertdate','desc')
                ->getNum($num, $start);
        }

        $count = $this->db->table('`product` p')
            ->where($cond)
            ->where($type_cond)
            ->where($dateCond)
            ->where($statusCond)
            ->where($user_id_comd)
            ->getCount();

        $data = array('list'=>$list, 'count'=>$count);

        return $data;
    }

    public function  getAttentionProduct($type=null, $arr=null, $page=1, $num=15, $order=1){

        if('local'==$type) {
            $type_cond = "category='local'";
        } elseif('net'==$type) {
            $type_cond = "category='net'";
        } elseif('goldroll'==$type) {
            $type_cond = "category='goldroll'";
        } elseif("" == $type) {
            $type_cond = "";
        }
        $start = intval($page-1);

        if(2==$order) {
            $list = $this->db->table('`product`')
                ->select('id,category,title,market_price,supply_price,visits,image')
                ->where($type_cond)
                ->where('status<>4')
                ->where("id in ({$arr})")
                ->order('insertdate','desc')
                ->getNum($num, $start);
        } elseif(3==$order){
            $list = $this->db->table('`product`')
                ->select('id,category,title,market_price,supply_price,visits,image')
                ->where($type_cond)
                ->where('status<>4')
                ->where("id in ({$arr})")
                ->order('visits','desc')
                ->getNum($num, $start); 
        } elseif(4==$order){
            $list = $this->db->table('`product`')
                ->select('id,category,title,market_price,supply_price,visits,image')
                ->where($type_cond)
                ->where('status<>4')
                ->where("id in ({$arr})")
                ->order('visits','asc')
                ->getNum($num, $start);
        } else {
            $list = $this->db->table('`product`')
                ->select('id,category,title,market_price,supply_price,visits,image')
                ->where($type_cond)
                ->where('status<>4')
                ->where("id in ({$arr})")
                ->order('insertdate','desc')
                ->getNum($num, $start);
        }

        $count = $this->db->table('`product`')
            ->where($type_cond)
            ->where("id in ({$arr})")
            ->getCount();
        $data = array('list'=>$list, 'count'=>$count);

        return $data;
    }

    /**
     * 商品管理页面的搜索(admin操作)
     * 
     */
    public function searchProductByTitle($user_id, $title, $type_id=0, $page=1, $num=15) {

        $cond = "p.title like '%{$title}%'";
        if($type_id=='2'){
            $cond = "gu.Name like '%{$title}%'";
        }
        
        $start = intval($page-1)*$num;
        if($type_id) {
            $list = $this->db->table('`product` p, `user` gu')
                ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.image,p.insertdate,gu.UserID,gu.Name')
                ->where($cond)
                ->where('p.status<>4')
                ->where('p.user_id=gu.UserID')
                ->order('p.insertdate','desc')
                ->getNum($num, $start);

            $count = $this->db->table('`product` p, `user` gu')
                ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.image')
                ->where($cond)
                ->where('p.user_id=gu.UserID')
                ->where('p.status<>4')
                ->getCount();
        } else {
            $list = $this->db->table('`product` p')
                ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.image')
                ->where($cond)
                ->where("p.user_id={$user_id}")
                ->where('p.status<>4')
                ->order('p.insertdate','desc')
                ->getNum($num, $start);

            $count = $this->db->table('`product` p')
                ->select('p.id,p.category,p.title,p.market_price,p.supply_price,p.visits,p.image')
                ->where($cond)
                ->where('p.status<>4')
                ->where("p.user_id={$user_id}")
                ->getCount();
        }

        $data = array('list'=>$list, 'count'=> $count);

        return $data;
    }


    //供管理调用
    public function manageProduct($sql) {

        $result = $this->db->exec($sql);

        return $result;
    }

    //过期
    public function batchExpiredProduct($user_id, $batch_id) {
        $expire_date = time() - (10 * 24 * 60 * 60);
        return $this->manageProduct("update `product` set expire_date={$expire_date} where id in ({$batch_id}) and user_id={$user_id}");
    }

    //下架
    public function shelfProduct($user_id, $id) {
        if(in_array($user_id, array(1,189,175))) {
            $result = $this->manageProduct("update `product` set status=0 where id={$id}");
        } else {
            $result = $this->manageProduct("update `product` set status=0 where id={$id} and user_id={$user_id}");
        }

        return $result;
    }

    //上架
    public function shelvesProduct($user_id, $id) {
        return $this->manageProduct("update `product` set status=1 where id={$id} and user_id={$user_id}");
    }

    //重发
    public function againProduct($user_id, $id) {

        return $this->batchAgainProduct($user_id, $id);
    }

    //批量重发
    public function batchAgainProduct($user_id, $batch_id) {

        $expire_date = time() + (10 * 24 * 60 * 60);
        return $this->manageProduct("update `product` set expire_date={$expire_date} where id in ({$batch_id}) and user_id={$user_id}");
    }

    //删除 更新状态
    public function deleteProduct($user_id, $id) {
        return $this->batchDeleteProduct($user_id, $id);
    }

    //批量删除
    public function batchDeleteProduct($user_id, $batch_id) {
        if(in_array($user_id, array(1,189,175))) {
            $result = $this->manageProduct("update `product` set status=4 where id in ({$batch_id})");;
        } else {
            $result = $this->manageProduct("update `product` set status=4 where id in ({$batch_id}) and user_id={$user_id}");;
        }

        $this->db->exec("update `user` set CountProducts=CountProducts-{$result} where UserID='{$user_id}'");

        return $result;
    }

    //修改
    public function getUpdateProduct($id){
        $data = $this->db->table('`product`')
            ->select('*')
            ->where("id='{$id}'")
            ->getFirst();
        return $data;
    }

    //update 的处理
    public function updateProductDataID($id, $product){

        $rzt = $this->db->table('`product`')->update($product, "id={$id}");
        $data = $this->db->table('product')->select('contact_id, address_id, business_id')
            ->where("id={$id}")
            ->getFirst();

        return $data;
    }
    //最新供应商品
    public function getNewsList(){
        $data = $this->db->table('`product`')
            ->select('id,title,image')
            ->where('auth=1')
            ->order('insertdate','desc')
            ->getNum(9);

        return $data;
    }

    /**
     * 更新商品数据
     *
     */
    public function updateProductData($data, $admin=FALSE) {

        if(empty($data['id'])) {
            $this->addProductData($data);
        } else {

            if(empty($data['keywords'])) {
                $title = $data['title'];
                if(strlen($data['title'])>38) {
                    $title = mb_substr($data['title'], 0, 38,"utf-8");
                }
                $key = $this->baiduKeyword($title);
                $data['keywords'] = $key;
                unset($title);
                unset($key);
            }
            $data['expire_date']  = empty($data['expire_date']) ? 10 : $data['expire_date'];
            $data['payment_id']   = empty($data['payment_id']) ? 1 : $data['payment_id'];
            $data['site_number']  = empty($data['site_number']) ? 0 : $data['site_number'];

            if($admin){
                $result = $this->db->exec("update `product` set title='{$data['title']}', keywords='{$data['keywords']}',category_id='{$data['category_id']}', market_price='{$data['market_price']}', supply_price='{$data['supply_price']}',foreign_price='{$data['foreign_price']}', default_image='{$data['default_image']}',image='{$data['image']}', description='{$data['description']}', vedio='{$data['vedio']}', payment_id='{$data['payment_id']}', expire_date={$data['expire_date']}, site_number='{$data['site_number']}', gonghuoren='{$data['gonghuoren']}',freight='{$data['freight']}',free_mail='{$data['free_mail']}',chain_desc='{$data['chain_desc']}',unit='{$data['unit']}',cycle='{$data['cycle']}',storage='{$data['storage']}' where id='{$data['id']}'");

            } else {
            
                $result = $this->db->exec("update `product` set title='{$data['title']}', keywords='{$data['keywords']}',category_id='{$data['category_id']}', market_price='{$data['market_price']}', supply_price='{$data['supply_price']}',foreign_price='{$data['foreign_price']}', default_image='{$data['default_image']}',image='{$data['image']}', description='{$data['description']}', vedio='{$data['vedio']}', payment_id='{$data['payment_id']}', expire_date={$data['expire_date']}, site_number='{$data['site_number']}', gonghuoren='{$data['gonghuoren']}',freight='{$data['freight']}',free_mail='{$data['free_mail']}',chain_desc='{$data['chain_desc']}',unit='{$data['unit']}',cycle='{$data['cycle']}',storage='{$data['storage']}' where user_id='{$data['user_id']}' and id='{$data['id']}'");
            
            }

            return $result;
        }
    }


    public function getProductCateogryList($parent_id){ 

        $list = $this->db->table('`category`')
            ->select('id,name,left_id,right_id')
            ->where("level={$parent_id}")
            ->order('id', 'asc')
            ->getList();

        return $list;
    }

    public function updateProductImage($id, $image) {
        $array_image = explode('|', $image);
        $target = '';
        foreach($array_image as $v) {
            if(empty($v)) {continue;}
                $target .= $v . '|';
        }
        $target = substr($target, 0 , -1);

        $this->db->exec("update `product` set image='{$target}' where id='{$id}'");
        return ;
    }

    public function updateDefaultImage($id, $image='') {

        $this->db->exec("update `product` set default_image='{$image}' where id='{$id}'");

        return ;
    } 

    public function getAuthDataNum($type, $user_id, $admin=false){

        $type_cond = false;
        if('local'==$type) {
            $type_cond = "category='local'";
        } elseif('net'==$type) {
            $type_cond = "category='net'";
        } elseif('goldroll'==$type) {
            $type_cond = "category='goldroll'";
        } else {
            $type_cond = true;
        }

        $cond = false;
        $dateCond = false;
        $time = time();

        if($admin==true){
            $user_id_cond = false;
        } else {
            $user_id_cond = "user_id={$user_id}";
        }

        $count1 = $this->db->table('`product`')
            ->where("auth=1")
            ->where($type_cond)
            ->where('status=1')
            ->where($user_id_cond)
            ->where("(expire_date>$time or expire_date='0')")
            ->getCount();

        $count2 = $this->db->table('`product`')
            ->where("auth=0")
            ->where($type_cond)
            ->where('`status`<>4')
            ->where($user_id_cond)
            ->where("(expire_date>$time or expire_date='0')")
            ->getCount();
        $count3 = $this->db->table('`product`')
            ->where("auth=2")
            ->where($type_cond)
            ->where('status<>4')
            ->where($user_id_cond)
            ->where("(expire_date>$time or expire_date='0')")
            ->getCount();

        $count4 = $this->db->table('`product`')
            ->where($type_cond)
            ->where($user_id_cond)
            ->where('status<>4')
            ->where("expire_date<$time")
            ->where("expire_date<>'0'")
            ->getCount();

        $count5 = $this->db->table('`product`')
            ->where($type_cond)
            ->where('status=0')
            ->where($user_id_cond)
            ->getCount();
        $authnum = array('num1'=>$count1,'num2'=>$count2,'num3'=>$count3,'num4'=>$count4,'num5'=>$count5);

        return $authnum; 
    }

    public function batchUploadResult($user_id,$page,$num) {
        $list = $this->db->table('`product`')
            ->select('id, title, market_price, supply_price,error_msg')
            ->where("user_id = '{$user_id}'")
            ->where('batch = 1')
            ->where('status=2')
            ->getNum($num,($page-1)*$num);

        $count = $this->db->table('`product`')
            ->where("user_id = '{$user_id}'")
            ->where('status=2')
            ->where('batch = 1')
            ->getCount();

        $num = $this->db->table('`product`')
            ->where("user_id = '{$user_id}'")
            ->where('status=2')
            ->where('batch = 1')
            ->where("error_msg!='NULL'")
            ->getCount();
        $arr = array('data'=>$list, 'count'=>$count, 'num'=>$num);
        return $arr;
    }

    public function batchUpdateResult($user_id,$page,$num){

        $list = $this->db->table('`product`')
            ->select('id')
            ->where("user_id = '{$user_id}'")
            ->where('status=2')
            ->getNum($num,($page-1)*$num);

        foreach($list as $v) {
            $this->db->exec("update `product` set status='1' where id='{$v['id']}' and user_id='{$user_id}'");
        }
    }

    public function getSuppliersData(){
        $list = $this->db->query("select id,user_id,attentions,title from `product` where auth='1' and status!='4' group by user_id order by attentions desc limit 0,10"); 
        return $list;
    }

    public function getFavoriteData($user_id, $page=1, $num=10, $folder=null) {
        if(!empty($folder) && !is_numeric($folder)) {
            $folder = null;
        } 

        $folderCond = false;
        if(!is_null($folder)) {
            $folder = intval($folder);
            $folderCond = "f.favorite_folder={$folder}";
        }
    
        $list = $this->db->table('`favorite` f, `product` p')
            ->select('f.id,f.favorite_folder,f.product_id,f.product_title,f.insert_date,p.title,p.default_image,p.image,p.batch')
            ->where("f.user_id = {$user_id}")
            ->where($folderCond)
            ->where('f.product_id = p.id')
            ->getNum($num, ($page-1)*$num);

        $count = $this->db->table('`favorite` f')
            ->where("f.user_id={$user_id}")
            ->where($folderCond)
            ->getCount();

        return array('list'=>$list, 'count'=>$count);
    }

    public function addFavoriteData($data) {
        $this->db->table('`favorite`')->insert($data);
        return $this->db->last_insert_id();
    }

    public function delFavoriteData($user_id, $batch_id) {
        return $this->db->exec("delete from `favorite` where user_id={$user_id} and id in ({$batch_id})");;
    }

    public function getFastSupplyData($page=1, $num=10, $auth=null) {
        switch($auth) {
            case 1:
                $auth_cond = "auth=1";
                break;
            case 2:
                $auth_cond = "auth=0";
                break;
            case 3:
                $auth_cond = "auth=2";
                break;
            case 4:
                $auth_cond = "vip=1";
                break;
            default:
                $auth_cond = FALSE;
        }

        $data['list'] = $this->db->table('`product` p ,`user` u') 
                ->select('p.id,p.title,p.auth,p.insertdate,p.vip,u.UserID as uid,u.Name as name')
                ->where('u.UserID=p.user_id')
                ->where($auth_cond)
                ->where('receive_id>0')
                ->getNum($num, ($page-1)*$num);

        $data['count'] = $this->db->table('`product`')
                ->where('receive_id>0')
                ->where($auth_cond)
                ->getCount();

        return $data;
    } 

    public function notThrough($user_id, $pid, $msg) {
        
        $result = $this->db->exec("update `product` set auth=2,auth_msg='{$msg}' where id='{$pid}'");

        $product = $this->getProductById($pid);
        $mess_log = array(
                'type'       => '2',
                'sender_id'  => $user_id,
                'receiver_id'=> intval($product['user_id']),
                'status'     => '0',
                'maintext'   => "产品：“{$product['title']}”的商品没有通过审核,理由：{$msg}。",
        );

        $this->db->table('`message`')->insert($mess_log);
        $this->db->exec("update `user` set CountMessages=CountMessages+1 where UserID='{$product['user_id']}'");

        return $result;
    }

}

