<?php
class ReviewePresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();

        NBee::import('app/models/MReviewe');

        $this->reviewe = new MReviewe();
    }

    public function revieweProcess($user_id) {
        if(!isset($_GET['action']) || $_GET['action']!='reviewe') { return; }
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }
        if(!isset($_GET['code']) || !is_numeric($_GET['code'])) { return; }
        
        $flag = $this->hasPermission($user_id, 1, 8);
        
        if(!$flag) {
            exit('对不起,您无权操作此页面');
        }

        $id      = $_GET['id'];
        $code    = $_GET['code'];
        $this->reviewe->revieweProductProcess($user_id, $id, $code);

        if($code=='1') {
            $record = "审核通过";
        } else if ($code=='2') {
            $record = "审核未通过";
        } else {
            $record = "vip供货";
        }
        $this->writeLog($user_id, $id, 'product', $record);

        if($code==0) {
            echo json_encode(array('id'=>$id, 'auth'=>$code, 'result'=>'1'));
        } else {
            echo json_encode(array('id'=>$id, 'auth'=>$code, 'result'=>'0'));
        }
        exit;
    }

    private function recommendProcess($user_id) {
        if(!isset($_GET['action']) || $_GET['action']!='recommend') { return; }
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $flag = $this->hasPermission($user_id, 1, 4);
        
        if(!$flag) {
            exit('对不起,您无权操作此页面');
        }

        $id     = $_GET['id'];
        $status = intval($_GET['recommend']);

        $result = $this->reviewe->recommendProductProcess($user_id, $id, $status);
        
        if($status=='0') {
            $record = "推荐商品";
        } else {
            $record = "取消推荐";
        }
        $this->writeLog($user_id, $id, 'product', $record);

        echo json_encode($result);
        exit;
    }

    public function getDataList() {
        if(!empty($_GET['action'])) {return; }
        if(isset($_GET['recommend']) || '1'==$_GET['recommend']) {return;}
        if(!isset($_GET['page'])) {$_GET['page']=1;}

        $auth = isset($_GET['auth']) ? 1 : 0;

        $num = 10;
        $page= isset($_GET['page']) ? $_GET['page'] : 1;

        $data = $this->reviewe->getRevieweProductList($page, $num, $auth);

        // 每页读取
        $this->__p__['ProductList'] = $data['data'];
        $this->__p__['ProductCount'] = $data['count'];
        $this->__p__['page']=new Page(array('total'=>$data['count'], 'perpage'=>$num, 'page_name'=>'page'));
    }

    private function search() {

        $type = intval($_POST['type']);
        $key  = trim($_POST['key']);
        $auth = isset($_GET['auth']) ? 1 : 0;

        $num = 10;
        $page= isset($_GET['page']) ? $_GET['page'] : 1;

        $data = $this->reviewe->getRevieweProductList($page, $num, $auth, $key, $type);


        $this->__p__['ProductList'] = $data['data'];
        $this->__p__['ProductCount'] = $data['count'];
        $this->__p__['page']=new Page(array('total'=>$count, 'perpage'=>$num, 'page_name'=>'page'));
    }

    private function getRecommendList(){
        if(!isset($_GET['recommend']) || '1'!=$_GET['recommend']) {return;}
        $num = 10;
        $page= isset($_GET['page']) ? $_GET['page'] : 1;

        // 每页读取
        $data = $this->reviewe->getRecommendList($page,$num);
        $this->__p__['ProductList'] = $data['data'];
        $this->__p__['ProductCount'] = $data['count'];
        $this->__p__['page']=new Page(array('total'=>$data['count'], 'perpage'=>$num, 'page_name'=>'page'));
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

        $flag = $this->hasPermission($user_id, 1, 1);
        
        if(!$flag) {
            exit('对不起,您无权操作此页面');
        }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->search();
        $this->recommendProcess($user_id);
        $this->revieweProcess($user_id);
        $this->getRecommendList();
        $this->getDataList();

    }
}
?>
