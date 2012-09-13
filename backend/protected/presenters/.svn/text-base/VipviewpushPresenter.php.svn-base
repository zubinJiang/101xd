<?php
class VipviewpushPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    private function getUserData($user_id) {

        //101推送数量
        $this->__p__['push_num'] = $this->vipproduct->getPushCount($user_id,'0');

        //user推送数量
        $this->__p__['user_push_num'] = $this->vipproduct->getPushCount($user_id);

        //收藏数量
        $this->__p__['collect_num'] = $this->vipproduct->getVipproductCollectNum($user_id);

        //忽略数量
        $this->__p__['ignore_num'] = $this->vipproduct->getVipproductCollectNum($user_id, '2');

        //track 跟踪记录
        $this->__p__['track_num'] = $this->vipproduct->getVipproductTrack($user_id);

    }


    public function __main__() {

        $user_id = $this->checkLoginStatus();

        $this->getUserData($user_id);

    }

}

?>


