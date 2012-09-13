<?php
class IndexPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    private function index() {

        $this->__p__['product'] = $this->product->getIdexProductList();

        //统计渠道商用户

        $this->__p__['channel_count'] = $this->user->getChannelCount();
    }


    public function __main__() {

        $this->index();

        $this->__p__['title']       = '101兄弟 101xd 团购供货平台，企业营销新选择！';
        $this->__p__['keywords']    = '101兄弟,货源,供货商';
        $this->__p__['description'] =  '101兄弟（101xd.com）为团购网站等渠道商供货平台，提供本地商品、精品网货、网站优惠券等多种商品类型，同时是企业商务社区，扩展人脉、互动交流平台，101兄弟，是企业营销新选择！';
    }
}
