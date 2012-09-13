<?php
class ViewpushdetailPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    //根据商品id获取商品的相关数据
    public function GetPushProduct($id_,$user_id) {
        /*$ck = $this->vipproduct->checkRelate($user_id,$id_);
        if(!$ck){
        exit('你无权操作此页面!');
        }*/


        $res = $this->vipproduct->getRelateVipproductData($id_);
        $this->__p__['product'] = $res;
        //echo json_encode($res);
    }

    public function __main__() {
    
        $user_id = $this->checkLoginStatus(); 


        //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);


        //权限判断
        if(!$user_id){
           $this->redirect("/"); 
        }
        if (isset($_GET['id'])){
            $this->GetPushProduct($_GET['id'],$user_id);
        }




    }
}

?>

