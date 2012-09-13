<?php
class ViewpullproductPresenter extends InitPresenter 
{

    public function __init__() {
        parent::__init__();
        //NBee::import('app/models/MCode');
    }
    
    //根据商品id获取商品的相关数据
    public function GetPushProduct($id_) {
        $res = $this->vipproduct->getRelateVipproductData($id_);
        $this->__p__['product'] = $res;
        //1该商品被推送到的其他渠道商
        $pushed = $this->vipproduct->getPushedList($id_);
        $this->__p__['pushed'] = $pushed;
        //2该商品的推荐推送渠道商
        $suggestpush = $this->vipproduct->getSuggestPush($id_);
        $this->__p__['suggestpush'] = $suggestpush;

        //echo json_encode($res);
        //exit;
    }
    //审核通过
    //0 未处理 1 审核通过 2拒绝
    public function AgreePushTuan($id_,$state){
        $num = $this->vipproduct->processVipproductData($state, $id_,'');
        $res['status'] = 1;
        $res['msg'] = "操作成功,更新{$num}条数据";
        echo json_encode($res);
        exit;
    }
    //根据渠道商的id获取该渠道上需要的资质证明
    public function Certifications($id_){
        $res = $this->vipproduct->GetCertificationsByID($id_);
        echo json_encode($res);
        exit;
    }
    /*删除推送到的渠道商
     *pid vipproduct_id qid 渠道商的id
     */
    public function DelPushTuan($pid,$qid){
        $res = array();
        $res['status'] = $this->vipproduct->CancelPushToTuan($pid,$qid);
        echo json_encode($res);
        exit;
    }
    public function __main__() {
        $user_id = $this->checkLoginStatus();
        $flag = $this->hasPermission($user_id, 6, 1);
        if(!$flag) {
            exit('您无权操作此页面');
        }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['action']) && isset($_GET['id'])){
            $this->GetPushProduct($_GET['id']);
        }
        //删除推送的团
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action']=='delpushtuan'){
            $this->DelPushTuan($_GET['action'],$_GET['pid'],$_GET['qid']);
        }
        //同意推送
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action']=='push' && $_GET['type']=='agree'){
            $this->AgreePushTuan($_GET['id'],1);
        }
        //拒绝推送
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action']=='push' && $_GET['type']=='deny'){
            $this->AgreePushTuan($_GET['id'],2);
        }
        //获取渠道商的资质证明
        else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action']=='certifications'){
            $this->Certifications($_GET['id']);
        }
        else{
        $res['status']=0;
        $res['msg']='不正确的参数';
        echo json_encode($res);
        exit;
        }
    }

}

?>
