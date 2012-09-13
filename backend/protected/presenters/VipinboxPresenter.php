<?php
class VipinboxPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function del($user_id) {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

        $this->message->delMessage($_GET['id']);
        $unread_message = $this->message->getNewsMessageCount($user_id);
        $all_message = $this->message->getAllMessageCount($user_id); 
        // 操作数据库
        echo json_encode(array('all'=>$all_message, 'unread'=>$unread_message,'user_id'=>$user_id));
        exit;
    }
    public function getRead($user_id) {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { return; }

 
        $this->message->getReadMessage($_GET['id']);
        
        $unread_message = $this->message->getNewsMessageCount($user_id);
        $all_message = $this->message->getAllMessageCount($user_id); 

        // 操作数据库
        echo json_encode(array('all'=>$all_message, 'unread'=>$unread_message));
        exit;
    }
    public function getDataList($user_id) {
        if(!isset($_GET['page'])) {$_GET['page']=1;} 
        // 每页读取
        $num = 10; //每页显示的条目数
        $page = isset($_GET['page']) ? $_GET['page'] : "1";

        $data  =  $this->message->getDataList($user_id,$page,$num);   // 从db读取数据

        $unread_message = $this->message->getNewsMessageCount($user_id);

        $all_message = $this->message->getAllMessageCount($user_id); 

        
        $this->__p__['page'] = new Page(array('total'=>$all_message,'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['messages'] = $data;
        $this->__p__['unread'] = $unread_message;
        $this->__p__['all'] = $all_message;
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus();
        //删除消息
        if ($_GET['action']=='del'){
            $this->del($user_id);
        }
        //阅读消息
        else if ($_GET['action']=='read'){
            $this->getRead($user_id);
        }
        //分页显示
        else{
            $this->getDataList($user_id);
        }
    }
}
?>
