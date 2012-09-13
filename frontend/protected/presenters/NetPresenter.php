<?php
class NetPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function index() {
        $product =  $this->product->getProductNewList('net');

        $rzt = '';
        $style = array();
        if(!empty($product['type'])){
            foreach($product['type'] as $k=>$v){
                if($v['count'] > 0){
                    $rzt .= "<a href='#' value='{$v['id']}'>{$v['name']}<span style='color:red;'>({$v['count']})</span></a>"; 
                    $style [$v['id']]= $v['name']; 
                } 
            }
        }

        $this->__p__['style']    = $style;//产品类别
        $this->__p__['type_sum'] = $rzt;  //产品按分类计算的总数
        $this->__p__['product']  = $product['list'];

        $max = 9;
        $page=new Page(array('total'=>$product['count'],'perpage'=>$max,'page_name'=>'page'));
        $this->__p__['page'] = $page;
        $this->__p__['id'] = "3";
    }

    public function __main__() {
        $this->index();

        $this->getNewUserList();
        $this->getRecommendList('net');
        
    }
}
