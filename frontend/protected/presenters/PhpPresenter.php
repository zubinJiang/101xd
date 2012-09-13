<?php
class PhpPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
        
    }

    public function admin_category() {

        if (!$this->admin_category) {
            $this->admin_category = new CCategory($this->db, 'category', 'id', 'left_id', 'right_id', 'level');
        }
        return $this->admin_category;

    }

    public function index(){

        /*
        $this->admin_category()->addItem(1, '本地商品');
        $this->admin_category()->addItem(1, '精品网货');
        $this->admin_category()->addItem(1, '代金券');

        // 本地
        $array = array('美食餐饮','休闲娱乐','美容护发','酒店住宿','旅游景点','食品饮料','摄影');
        foreach($array as $v){
        	$this->admin_category()->addItem(2, $v);
        }
        
        // 精品
        $array = array('化妆品','母婴用品','服饰箱包','酒店住宿','旅游景点','食品饮料','摄影','食品饮料');
        foreach($array as $v){
        	$this->admin_category()->addItem(2, $v);
        }

        // 本地
        $array = array('美食餐饮','休闲娱乐','美容护发','酒店住宿','旅游景点','食品饮料','摄影');
        foreach($array as $v){
        	$this->admin_category()->addItem(2, $v);
        }

         */
        /*$this->admin_category()->addItem(3, '食品饮料');
        $this->admin_category()->addItem(2, '休闲娱乐');
        $this->admin_category()->addItem(2, '美容护发');
        $this->admin_category()->addItem(2, '摄影');
        $this->admin_category()->addItem(2, '酒店住宿');
        $this->admin_category()->addItem(2, '旅游景点');
        $this->admin_category()->addItem(2, '其它');
        $this->admin_category()->addItem(3, '图书音乐');
        *
        //地方菜系    自助海鲜    蛋糕甜品 日式韩系    西餐国际 火锅烧烤  其他餐饮
		/*
		$struct = $this->admin_category()->getCategoryStruct();
		var_dump($struct);
		*/

        //$this->admin_category()->addItem(2, '其他餐饮');
		//$array = array('饮食','娱乐','生活服务','网货精品','网站');
		//$array = array('地方菜系','自助海鲜','蛋糕甜品','日式韩系','西餐国际','火锅烧烤','其他餐饮');
    	//$array=array('游乐游艺','运动健身','电影展览','温泉会所','养生按摩','话剧演出','酒店旅游','KTV','其他娱乐');
		//$array=array('婚纱摄影','健康护理','美容美发','汽车护理','宠物护理','酒店预定','教育培训','报刊杂志','房车租售','酒店住宿','休闲其他');
		/*$array = array('餐饮美食','休闲娱乐','生活服务','购物','优惠票券');
		
		$array = array('配件饰品','文体户外');

		foreach($array as $v){
        	$this->admin_category()->addItem(3, $v);
        }
	

         */
    }

    public function del() {
        if(!isset($_GET['step']) || '2'!=$_GET['step']) { return; }
        
        $user_id = trim($_POST['user_id']);
    
        // Daily
        $table_array = array('attention_publishers', 'business', 'company', 'contact', 'employee', 'favorite', 'product', 'sms', 'website_comment');
        foreach($table_array as $v) {
            $this->db->exec("delete from `{$v}` where user_id in ({$user_id})");
        }

        // GDN
        $gdn_array = array('GDN_Comment', 'GDN_Discussion');
        foreach($gdn_array as $v) {
            $this->db->exec("delete from `{$v}` where InsertUserID in ({$user_id})");
        }

        // group
        $tmp_user = explode(',', $user_id);
        foreach($tmp_user as $v) {
            $tmp_group = $this->db->table('group_user')
                            ->where("user_id={$v}")
                            ->getList();

            if(!empty($tmp_group)) {
                foreach($tmp_group as $value) {
                    $this->db->exec("delete from `group` where id = '{$value['group_id']}'");
                }
            }
        }

        // GDN
        $user_array = array('GDN_UserRole', 'GDN_User');
        foreach($user_array as $v) {
            $this->db->exec("delete from `{$v}` where UserID in ({$user_id})");
        }

        // message
        $this->db->exec("delete from `message` where receiver_id in ({$user_id})");

        exit('delete complete！');
    }

    public function toDel() {
    
        $tmp = $this->db->table("`GDN_User`")
                ->select("UserID")
                ->where('Deleted=1')
                ->getList();

        $user_array = array();
        foreach($tmp as $v) {
            $user_array[] = $v['UserID'];
        }

        $user = implode(',', $user_array);

        $this->__p__['user_id'] = $user;
    }

    public function statistics() {
        $user_list = $this->db->table('`user`')
                        ->select('UserID')
                        ->getList();

        foreach($user_list as $v) {
            $count = $this->db->table('`product`')
                    ->where("user_id={$v['UserID']}")
                    ->getCount();

            $this->db->exec("update user set CountProducts={$count} where UserID='{$v['UserID']}'");
        }
    
    }

    public function __main__() {
        $this->statistics();

       $this->index();

       //$this->toDel();

       //$this->del();
    }
}
