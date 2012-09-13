<?php
class PushsteptwoPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
        NBee::import('app/models/MCode');
    }



    public function GetData(){
        if (isset($_GET['id'])){
            $res = $this->user->filterPushCompany($_GET['id']);
            if(!$res){
                $this->redirect('/404');
            }
            else{
                $this->__p__['users']=$res;
                $this->__p__['pid']=$_GET['id'];
            }   
            }
        else{
            $this->redirect('/404');
            }
    }
    
    public function AddQudao($uid){
            $pid = $_GET['pid'];
            if(!$uid){$uid=0;}
            else{
                //检查改提交的商品id是否是本人提交的，防止别人查看
                $res_ =  $this->vipproduct->checkUP($uid,$pid);
                if(!$res_){
                exit('你无权查看该页面');
                }
            }
            $qids= json_decode($_GET['vips']);
            $res['status'] = $this->vipproduct->addQudao($pid,$qids,$uid);
            $res['url'] = "/vipsupplys?id={$pid}";
            echo json_encode($res);
            exit;
        }

    public function __main__() {

        $user_id = $this->checkSysCookie(); 
        if ($_GET['action']=='selectqd'){
            $this->AddQuDao($user_id);    
        }
        else{
            $this->__p__['uid']=$user_id;
            $this->GetData();
        }
 
    } 
}



