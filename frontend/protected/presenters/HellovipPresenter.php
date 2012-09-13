<?php
class HellovipPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    private function index() {

        //统计VIP渠道商用户

        $count = $this->user->getVipChannelCount();

        $this->__p__['count'] = $count;

        //最新入住的渠道商
        $news_user = $this->user->getNewsUserList();

        $this->__p__['news_user'] = $news_user;

        //开通专业的会员
        $vip_data  = $this->user->getVipUserList();

        $this->__p__['vip_data'] = $vip_data;

        //其他渠道商会员
        $user_data  = $this->user->getQitaUserList();

        $this->__p__['user_data'] = $user_data;

    }

    public function search(){

        if('search'!=$_GET['action']){ return; }

        $data = $this->user->searchUserName($_POST['key']);


        $this->__p__['data'] = $data;

        $this->__p__['search'] = 'search';


    
    }


    public function __main__() {

        $this->index();

        $this->search();

        $this->__p__['title']       = '101兄弟 101xd 团购供货平台，企业营销新选择！';
        $this->__p__['keywords']    = '101兄弟,货源,供货商';
        $this->__p__['description'] =  '101兄弟（101xd.com）为团购网站等渠道商供货平台，提供本地商品、精品网货、网站优惠券等多种商品类型，同时是企业商务社区，扩展人脉、互动交流平台，101兄弟，是企业营销新选择！';
    }
}
