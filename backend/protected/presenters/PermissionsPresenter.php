<?php

class PermissionsPresenter extends InitPresenter 
{
    public function __init__() {
    
        parent::__init__() ;
    }

    public function getData() {

        $num = 15;

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $data = $this->user->getUserList($page,$num);

        $page=new Page(array('total'=>$data['count'], 'perpage'=>$num,'page_name'=>'page'));

        $this->__p__['page'] = $page;
    
        $this->__p__['user_list'] = $data['data'];

        $this->__p__['user_count'] = $data['count'];
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        if(!$this->hasPermission($user_id, 7, 1)) { exit('not auth!'); }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->getData();
    }

}

?>
