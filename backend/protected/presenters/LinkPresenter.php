<?php
class LinkPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function addLink($user_id){
        if(empty($_GET['action']) || 'add'!=$_GET['action']) { return; }

        if(!$this->hasPermission($user_id, 5, 4)) { exit('not auth!'); }

        if(empty($_POST['url'])) {
            $this->__p__['error_msg'] = '网站网址不能空';
        }    
        if(empty($_POST['name'])) {
            $this->__p__['error_msg'] = '网站名称为空！';
        }

        if(empty($this->__p__['error_msg'])) {
            $type = $_POST['type'];
            $name = $_POST['name'];
            $url  = $_POST['url'];
            $desc = $_POST['desc'];
            $data = array(
                'user_id'   => $user_id,
                'site_name' => $name,
                'site_url'  => $url,
                'site_desc' => $desc,
                'type'      => $type
            );
            $data = $this->userlink->adduserlink($data);

            if(!empty($data)){
                $this->__p__['error_msg'] = '友情链接,添加成功';
            } else {
                $this->__p__['error_msg'] = '友情链接,添加失败';
            }
            
            $this->writeLog($user_id, $data, 'link', $this->__p__['error_msg']);

            unset($data);
            unset($type);
            unset($name);
            unset($url);
            unset($desc);
        }
    }

    public function linkList($user_id){
        if(empty($_GET['action']) || 'list'!=$_GET['action']) { return; }

        $num = 10;
        $page= isset($_GET['page']) ? intval($_GET['page']) : 1;
    
        $data = $this->userlink->getLinkList($user_id, $page, $num); 

        $this->__p__['data_list'] = $data['list'];
        $this->__p__['page']=new Page(array('total'=>$data['count'], 'perpage'=>$num, 'page_name'=>'page'));
    
    }

    public function deleteLink($user_id){
        if(empty($_GET['action']) || 'del'!=$_GET['action']) { return; }
        if(empty($_GET['id'])) { return; }

        if(!$this->hasPermission($user_id, 5, 2)) { exit('not auth!'); }

        $id = $_GET['id'];
        $data = $this->userlink->deleteLink($user_id,$id); 

        if(!empty($data)){
            
            $str = 1;
        } else {
            $str = 0;
        }

        $this->redirect("/user/link?action=list&str={$str}");
    
    }

    public function __main__() {
        $user_id = $this->checkLoginStatus(); 
        if(!$this->hasPermission($user_id, 5, 1)) { exit('not auth!'); }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->addLink($user_id);
        $this->linkList($user_id);
        $this->deleteLink($user_id); 
    }

}

?>

