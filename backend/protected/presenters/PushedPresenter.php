<?php
class PushedPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function login(){

        $category = $this->vipcategory->getVipcategoryList();

        $this->__p__['category'] = $category;

        //vip user list
        $vip_user = $this->user->vipUserList();

        $this->__p__['vip_user'] = $vip_user;

        $this->__p__['province'] = $this->province->getProvinceList();
    
    }

    public function index($user_id){

        if(!empty($_GET['action'])) { return; }

        $num = 15;

        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data = $this->vipproduct->getVipproductList($user_id, $page, $num, 'admin');


        $this->__p__['data'] = $data['list'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        
        $this->__p__['page'] = $page;

    }
    public function __main__() {
    
        $user_id = $this->checkLoginStatus(); 


        $flag = $this->hasPermission($user_id, 6, 1);
        if(!$flag) {
            exit('您无权操作此页面');
        }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);


        $user_id = $_GET['id'];

        $this->login();

        $this->index($user_id);
    }
}

?>


