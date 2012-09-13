<?php
class QuantityPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function uploadResult($user_id) {

        $page   = isset($_GET['page'])  ? $_GET['page']  : 1;
        $num = 12;

        $data = $this->product->batchUploadResult($user_id,$page,$num);

        $this->__p__['data'] = $data['data'];
        $this->__p__['count'] = $data['count'];
        $this->__p__['num'] = $data['num'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page;
    }


    public function toUpdate($user_id,$shu){
        $num=12;
        $this->product->batchUpdateResult($user_id,$shu,$num);

    }
    public function __main__() {
        $user_id = $this->checkLoginStatus();

        $shu = isset($_GET['shu'])  ? $_GET['shu']  : '';

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);


        if(!empty($shu)){

            $this->toUpdate($user_id,$shu);

        }
        $this->uploadResult($user_id);


    }
}
?>
