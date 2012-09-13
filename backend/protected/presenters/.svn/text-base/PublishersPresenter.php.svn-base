<?php
class publishersPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function getData($user_id) {
        $current = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $num  = 12;
        $data = $this->publisher->getDataList($user_id, $current, $num);

        foreach($data['list'] as $k => $v) {
            $data['list'][$k]['first'] = $this->product->getFirstData($v['publisher_id']);
            $data['list'][$k]['count'] = $v['CountProducts']; 
        }

        $this->__p__['list'] = $data['list'];
        $this->__p__['count']= $data['count'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
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
