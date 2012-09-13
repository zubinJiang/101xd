<?php
class ProductviewPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    private function productData() {
        if(empty($_GET['id']) || !is_numeric($_GET['id'])) {exit('error');} 
        $id = intval($_GET['id']);
        $product = $this->product->getProductViewData($id);
        if(empty($product)) {exit('改产品不存在');}
        $this->__p__['product'] = $product;
        $this->__p__['user']    = $this->user->getUserData($product['user_id']);
        $this->__p__['receive'] = $this->user->getUserData($product['receive_id']);

        
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        
        $this->productData();
    }
}

?>
