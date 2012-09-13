<?php
class ChannelManagementPresenter extends InitPresenter 
{

    public function __init__() {
        parent::__init__();
    }

    public function getDataList() {

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
 
        $num  = 15;
  
        $data = $this->user->getChanneUserlDataList($page, $num);

        if(!empty($data['list'])){

            foreach($data['list'] as $k=>$v){

                $address = $this->address->getAddressById($v['address_id']);

                $data['list']["{$k}"]['pname'] = $address['pname'];
                
                $data['list']["{$k}"]['area_name'] = $address['cname'];
            }
        
        }
        $this->__p__['list_data']  = $data['list'];
        $this->__p__['count_data'] = $data['count'];

        $page=new Page(array('total'=>$data['count'], 'perpage'=>$num,'page_name'=>'page'));
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

        $this->getDataList();
    }

}

?>

