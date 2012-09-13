<?php
class VipdetailPresenter extends InitPresenter 
{
     public function __init__() {
        parent::__init__();
    }

     //根据商品id获取商品的相关数据
    public function GetPushProduct($id_,$uid) {
        $res = $this->vipproduct->getRelateVipproductData($id_,$uid);
        $this->__p__['product'] = $res;

    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();
        $this->__p__['user_id'] = $user_id;
        $id = $_GET['id'];

        $this->GetPushProduct($id,$user_id);
    }

}

?>

