<?php
class ChildpagesPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function  productStyleData($id){
        $type = $this->product->higherLevelData($id); //获取上一级类别的ID
        if(!empty($type)) {
            if($type['level'] == 2){
                $comd = 'local';
            } elseif($type['level'] == 3) {
                $comd = 'net';
            } else {
                $comd = 'goldroll';
            }

            $this->getRecommendList($comd);
            $product = $this->product->getNextTypeProduct($comd, $id, $type['level']);

            $this->__p__['product'] = $product['list'];

            $rzt = '';
            $style = array();
            if(!empty($product['type'])){
                foreach($product['type'] as $k=>$v){
                    if($v['count']>0){
                        $rzt .= "<a href='#' value='{$v['id']}'>{$v['name']}<span style='color:red;'>({$v['count']})</span></a>"; 
                        $style[$v['id']]= $v['name']; 
                    } 
                }

                $this->__p__['style']    = $style;//产品类别
                $this->__p__['type_sum'] = $rzt;  //产品按分类计算的总数
            }
        } 


        $max = 9;
        $page=new Page(array('total'=>$product['count'],'perpage'=>$max,'page_name'=>'page'));
        $this->__p__['page'] = $page;

        $this->__p__['childpages'] = "childpages";

        $this->__p__['id'] = $id;
        $this->__p__['type'] = $comd;
    }

    public function __main__() {

        $id =  isset($_GET['id'])? intval($_GET['id']) : 5;
        if($id<5) { $id=5; }

        $this->productStyleData($id);
        $this->getNewUserList();
    }
}
