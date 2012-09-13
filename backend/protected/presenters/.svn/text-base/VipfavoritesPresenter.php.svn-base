<?php
class VipfavoritesPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function login($user_id){

        $category = $this->vipcategory->getVipcategoryList();

        $this->__p__['category'] = $category;

        //vip user list
        $vip_user = $this->user->vipUserList();

        $this->__p__['vip_user'] = $vip_user;

        $this->__p__['province'] = $this->province->getProvinceList();

        $data = $this->vipproduct->getVipproductCount($user_id);

        $this->__p__['count'] = $data;

        $collect = $this->vipproduct->getVipproductCollect($user_id);

        $this->__p__['collect'] = $collect;
    
    
    }

    public function index($user_id){

        if(!empty($_GET['action'])) { return; }

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data = $this->vipproduct->getVipproductListCollect($user_id, $page, $num);


        $this->__p__['data'] = $data['list'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

    }


    public function search($user_id){

        if(!isset($_GET['action']) || 'search'!=$_GET['action']) { return; }

        $key         = $_POST['key'];
        /*$search['province_id'] = $_POST['province_id'];
        $search['area_id']     = $_POST['area_id'];
        $search['category']    = $_POST['category'];
        $search['delivery']    = $_POST['delivery'];
        $search['ad']          = $_POST['ad'];
        $search['state']       = $_POST['state'];
        */
        if($_POST['key']=="可以按标题搜索"){ $search['key']=""; }

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data = $this->vipproduct->getSearchVipproductCollect($key, $page, $num);

        $this->__p__['data'] = $data['list'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

    }

    public function __main__() {
    
        $user_id = $this->checkLoginStatus(); 

        if(!$user_id) {
            exit('您无权操作此页面');
        }

        $this->login($user_id);

        $this->index($user_id);

        $this->search($user_id);
    }
}

?>


