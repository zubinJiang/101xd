<?php
class ConcernedPresenter extends InitPresenter 
{
    public function __init__() {
        parent::__init__();
    }

    public function getData($user_id) {
        if(isset($_GET['action']) || !empty($_GET['action'])) { return; }

        $current = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $num  = 12;
        $data = $this->publisher->getDataList($user_id, $current, $num, 'passive');

        foreach($data['list'] as $k => $v) {
            $data['list'][$k]['first'] = $this->site->getGroupData($v['user_id']);

            if(!empty($data['list'][$k]['first'])){
                $data['list'][$k]['cname'] = $data['list'][$k]['first']['cname'];
            }
        }

        $this->__p__['list'] = $data['list'];
        $this->__p__['count']= $data['count'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page; 
    }

    public function quanData($user_id) {
        if(!isset($_GET['action']) || 'quan'!=$_GET['action'] ) { return; }
        $current = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $num  = 12;
        $data = $this->publisher->getQuanList($user_id, $current, $num);

        foreach($data['data'] as $k => $v) {
            $data['data'][$k]['first'] = $this->site->getGroupData($v['user_id']);

            if(!empty($data['data'][$k]['first'])){
                $data['data'][$k]['cname'] = $data['data'][$k]['first']['cname'];
            }
        }

        $this->__p__['data'] = $data['data'];
        $this->__p__['sum']  = $data['sum'];

        $page=new Page(array('total'=>$data['sum'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page; 
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->quanData($user_id);
        $this->getData($user_id);
    }
}

?>
