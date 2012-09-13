<?php
class LocalPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    private function index() {

        $product =  $this->product->getProductNewList('local');

        $rzt   = '';
        $style = array();
        if(!empty($product['type'])) {
            foreach($product['type'] as $k=>$v) {
                if($v['count'] > 0) {
                    $rzt .= "<a href='#' value='{$v['id']}'>{$v['name']}<span style='color:red;'>({$v['count']})</span></a>"; 
                    $style[$v['id']]= $v['name']; 
                } 
            }
        }
        
        $this->__p__['style']    = $style; //产品类别
        $this->__p__['type_sum'] = $rzt;   //产品按分类计算的总数
        $this->__p__['product']  = $product['list'];

        $max = 9;
        $page=new Page(array('total'=>$product['count'],'perpage'=>$max,'page_name'=>'page'));
        $this->__p__['page'] = $page;

        $this->__p__['id'] = "2";

        unset($page);
        unset($style);
        unset($rzt);
    }

    public function __main__() {
        $this->index();
        $this->getNewUserList();
        $this->getRecommendList('local');
        $this->__p__['title']       = '本地生活_精品_团购供货平台-【101兄弟】';
        $this->__p__['keywords']    = '本地团购供货,餐饮美食，生活团购货源';
        $this->__p__['description'] = '本地生活、娱乐、精品团购供货平台是101兄弟团购网站等渠道商供货平台的一个本地供货频道，提供本地餐饮美食,娱乐，KTV,电影票等商品，同时是企业商务社区，扩展人脉、互动交流平台';
    }
}
