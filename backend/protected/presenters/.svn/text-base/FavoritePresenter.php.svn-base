<?php
class FavoritePresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function getData($user_id) {
        $num = 10;
        $page= isset($_GET['page']) ? intval($_GET['page']) : 1;
        $type= isset($_GET['type']) ? intval($_GET['type']) : 0;

        switch ($type) {
            case 0:
                $type_num = null;
                break;
            case 1:
                $type_num = 0;
                break;
            case 2:
                $type_num = 1;
                break;
            case 3:
                $type_num = 2;
                break;
            default:
                $type_num = null;
        }

        $data = $this->product->getFavoriteData($user_id,$page,$num, $type_num);

        $this->__p__['list_data'] = $data['list'];
        $this->__p__['count_data']= $data['count'];

        $page=new Page(array('total'=>$data['count'], 'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page;
    }

    public function __main__() {
    
        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

    
        $this->getData($user_id);
    }
}
?>
