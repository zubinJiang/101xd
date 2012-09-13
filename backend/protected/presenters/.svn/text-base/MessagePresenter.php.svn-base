<?php
class MessagePresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function del() {
        if(!isset($_GET['action']) || $_GET['action']!='del') { return; }
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $user_id = 1;
        $this->message->delMessage($_GET['id']);
        
        $unread_message = $this->message->countunread($user_id);
        $all_message = $this->message->getAllMessageCount($user_id); 
        // 操作数据库
        echo json_encode(array('all'=>$all_message, 'unread'=>$unread_message));
        exit;
    }
    public function getRead($user_id) {
        if(!isset($_GET['action']) || $_GET['action']!='read') { return; }
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

 
        $this->message->getReadMessage($_GET['id']);
        
        $unread_message = $this->message->countunread($user_id);
        $all_message = $this->message->getAllMessageCount($user_id); 

        // 操作数据库
        echo json_encode(array('all'=>$all_message, 'unread'=>$unread_message));
        exit;
    }
    public function getDataList($user_id=1) {
        if(!isset($_GET['page'])) {$_GET['page']=1;} 
        // 每页读取
        $p = 5; //每页显示的条目数
        $page=$_GET['page'];
        $data  =  $this->message->getDataList($user_id,$page,$p);   // 从db读取数据
        $unread_message = $this->message->getNewsMessageCount($user_id);
        $all_message = $this->message->getAllMessageCount($user_id); 

        
        $this->__p__['page'] = new Page(array('total'=>$all_message,'perpage'=>$p,'page_name'=>'page'));
        $this->__p__['data_list'] = $data;
        $this->__p__['unread_message'] = $unread_message;
        $this->__p__['all_message'] = $all_message;
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->del();
        $this->getRead($user_id);
        $this->getDataList($user_id);
    }
}
?>
