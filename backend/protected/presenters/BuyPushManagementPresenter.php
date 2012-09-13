<?php
class BuyPushManagementPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function login($user_id){

        //统计商品的各种状态数量
        $this->__p__['state_num'] = $this->vipproduct->getStateNum($user_id);


        $this->__p__['count'] = $this->vipproduct->getBuyVipproductCount($user_id);

    }

    public function index($user_id){

        if(!empty($_GET['action'])) { return; }

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $this->__p__['data'] = $this->vipproduct->getBuyVipproductList($user_id, $page, $num);

        $count = $this->vipproduct->getBuyVipproductCount($user_id);

        $page=new Page(array('total'=>$count,'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

    }

    public function getState($user_id){

        if(!isset($_GET['action']) || 'state'!=$_GET['action']) { return; }

        $state = isset($_GET['state']) ? $_GET['state'] : '';

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data = $this->vipproduct->getBuyStateVipproductList($user_id, $state, $page, $num);

        $this->__p__['data'] = $data['list'];

        $page=new Page(array('total'=>$data['count'], 'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

    }

     public function getCollect($user_id){

        if(!isset($_GET['action']) || 'collect'!=$_GET['action']) { return; }

             
        $collect = isset($_GET['collect']) ? $_GET['collect'] : '';

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data = $this->vipproduct->getBuyCollectVipproductList($user_id, $collect, $page, $num);

        $this->__p__['data'] = $data['list'];

        $page=new Page(array('total'=>$data['count'], 'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

     }

    public function __main__() {
    
        $user_id = $this->checkLoginStatus(); 

        //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->login($user_id);

        $this->index($user_id);

        $this->getState($user_id);

        $this->getCollect($user_id);

    }
}

?>

