<?php
class SellerhomePresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    private function getUserData($user_id) {

        $this->__p__['user_data'] = $this->user->getUserData($user_id);

    }

    private function specify($user_id) {

        /*
        //群组功能删除
        // 动态信息
        $this->__p__['publish']   = $this->publisher->getPublicGroup($user_id, 1);
        */
        //关注的供应商排行
        $this->__p__['suppliers'] = $this->product->getSuppliersData();

        // website 
        $this->__p__['webdata']   = $this->site->getNewList(1);

        // log
        $this->__p__['log_data']  = $this->log->getLogByNum(10, $user_id);
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);


        $this->getUserData($user_id);

        $this->specify($user_id);
    }

}

?>
