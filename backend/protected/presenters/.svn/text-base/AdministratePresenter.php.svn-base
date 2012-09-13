<?php
class AdministratePresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function getDataList($user_id) {
        if(isset($_GET['action']) && 'search'==$_GET['action']) { return; }
        $status = isset($_GET['status']) ? $_GET['status'] : null;  //状态
        $type   = isset($_GET['type'])  ? $_GET['type'] : null;     //商品类型
        $order  = isset($_GET['order']) ? $_GET['order'] : 1;       // 排序
        $page   = isset($_GET['page'])  ? $_GET['page']  : 1;       // 翻页

        if('expire'==$status) {
            $p_stauts = 4;
        } elseif('authunknow'==$status) {
            $p_stauts = 3;
        } elseif('authno'==$status) {
            $p_stauts = 2;
        } elseif('authyes'==$status) {
            $p_stauts = 1;
        } elseif('shelves'==$status) {
            $p_stauts = 6;
        } else {
            $p_stauts = 5;
        }

        if('net'==$type) {
            $p_type = 'net';
        } elseif('goldroll'==$type) {
            $p_type = 'goldroll';
        } elseif('local'==$type){
            $p_type = 'local';
        } else {
            $p_type = 'all';
        }

        $num = 15;
        $admin = true;
        $data = $this->product->getDataList($user_id, $p_stauts,  $p_type, $page, $num, $order,$admin);

        $list = $data['list'];

        $count= $data['count'];

        $admin = true;
        //查询状态信息的条数
        $authnum = $this->product->getAuthDataNum($p_type,$user_id,$admin);

        $this->__p__['authnum'] = $authnum;
        $this->__p__['status'] = $status;
        $this->__p__['list']   = $list;
        $this->__p__['count']  = $count;

        $page=new Page(array('total'=>$count,'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page;
    }

    public function search($user_id) {
        if(!isset($_GET['action']) || 'search'!=$_GET['action']) { return; }
        if(!isset($_GET['key']) || empty($_GET['key'])) { return; } 
        $title   = trim($_GET['key']);
        $type_id = $_GET['title_type'];

        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $num = 15;

        $data = $this->product->searchProductByTitle($user_id, $title, $type_id, $current, $num);

        //查询状态信息的条数
        $authnum = $this->product->getAuthDataNum('all',$user_id);
        $this->__p__['authnum'] = $authnum;

        $this->__p__['list']   = $data['list'];
        $this->__p__['count']  = $data['count'];
        $this->__p__['key']    = $title;

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page;
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

        
        $flag = $this->hasPermission($user_id, 2, 1);
        
        if(!$flag) {
            exit('对不起,您无权操作此页面');
        }

        //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->getDataList($user_id); 
        $this->search($user_id);
    }
}

?>
