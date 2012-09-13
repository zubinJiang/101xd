<?php
class VipsupplysteponePresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
        NBee::import('app/models/MCode');
    }


    public function SaveData($user_id) {
        //$res = new array();
        unset($_POST['submit']);
        if (isset($_POST['category_id']) && isset($_POST['delivery']) &&  (($_POST['ad']=='1' && isset($_POST['ad_position']) &&  isset($_POST['ad_period'])) || $_POST['ad']=='0') && isset($_POST['company_id']) ){ 
          
            $ad_position = '';
            //将广告位置用|连接后入库
            if(!empty($_POST['ad_position'])){
                foreach($_POST['ad_position'] as $ap){
                    $ad_position=$ad_position.$ap.'|';
                }
                $_POST['ad_position']=$ad_position; 
            }
            //存储类别[本地商品，精品网货，其他到vipproduct表]//
            $category = intval($_POST['category_id']);
            if($category<=4){
                $_POST['category']=1;
            } 
            else if($category<=17 && $category>4){
                $_POST['category']=2;
            } 
            else{
                $_POST['category']=0;
            }
            $_POST['insertdate'] = time();
            $vipproduct_id = $this->vipproduct->addVipproduct($_POST);
            $res['status'] = 1;
            $res['msg'] = '存储数据成功';
            $res['url'] = "/vipsupply?id={$vipproduct_id}";
            $this->redirect($res['url']);
            //echo json_encode($res);
            //exit;
        }
        else
        {
            $res['status'] = 0;
            $res['msg'] = '输入的数据不完整';
            echo json_encode($res);
            exit;
        }
    }

    public function GetData(){
        if (isset($_GET['id'])){
            $user = $this->user->getUserDataById($_GET['id']);
            if (!empty($user['UserID'])){
                $data=$this->user->getUserRelateData($user['UserID']);
                $this->__p__['company_name'] = $data['company']['name'];
                $this->__p__['company_id'] = $data['company']['id'];
                $this->__p__['company_user_id'] = $user['UserID'];
                $this->__p__['data'] = $data;
            }
            else{
            $this->redirect('/404');
            }
        }
        else{
            $this->redirect('/404');
        }
    }


    public function __main__() {
        $user_id = $this->checkSysCookie();

        $id = intval($_GET['id']);
        if(!$user_id) {
                $this->redirect("/login?action=tijiao&id={$id}");
        }else{

            $user_id = $this->checkSysCookie();

            $tmp = $this->user->getUserDataById($user_id);
        
            if(!$tmp['Complete']) {

                $this->redirect("registerSuccess?act=complete&id={$id}");

            }

            if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])){
                $this->__p__['user_id'] = $user_id;
                $this->GetData();
            }
            else if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['user_id'])){
                $this->__p__['user_id'] = $user_id;
                $this->SaveData($user_id);
            }else{
                $this->redirect('/');
            }
        }
 
    } 
}



