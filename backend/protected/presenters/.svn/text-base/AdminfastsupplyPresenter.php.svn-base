<?php
class AdminfastsupplyPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
        error_reporting(E_ALL);
    }

    private function indexData() {

        if(!isset($_GET['page'])) {$_GET['page']=1;}

        $auth = isset($_GET['auth']) ? intval($_GET['auth']) : 0;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $num  = 10;

        $data = $this->product->getFastSupplyData($page, $num, $auth);

        // Ã¿Ò³¶ÁÈ¡
        $this->__p__['ProductList']  = $data['list'];
        $this->__p__['ProductCount'] = $data['count'];
        $this->__p__['page'] = new Page(array('total'=>$data['count'], 'perpage'=>$num, 'page_name'=>'page'));
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->indexData();
    }
}
?>
