<?php
class DetailPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();

    }

    public function index($id) {

        $site_data = $this->site->get_Web_Data($id);
        $this->__p__['title']       = $site_data['name'] . '介绍_评论_怎么样_团购-【101兄弟】';
        $this->__p__['keywords']    = "{$site_data['name']}团购,怎么样,介绍,团购货源";
        $this->__p__['description'] = $site_data['introduction'];
        $this->__p__['site_data'] = $site_data;
    }

    public function getArea($id){
        $area_data = $this->site->get_Area_Data($id);
        $this->__p__['area_data'] = $area_data;

    }

    public function netFriendComment($website_id) {

        $num  = 5;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $data = $this->site->getNetComment($website_id, $page, $num);
        $this->__p__['net_comment'] = $data['data'];
        $this->__p__['net_count']   = $data['count'];

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['comment_page'] = $page;

        unset($data);
        unset($page);
    }

    public function addSite() {
        if(!isset($_POST['action']) || 'addForm'!=$_POST['action']) {return;}
        if(empty($_POST['name']) || empty($_POST['url'])) {
            echo '2|请填写网站名称或网址！';
            exit;
        }

        $data = array();
        $data['name'] = trim($_POST['name']);
        $data['url']  = trim($_POST['url']);
        $data['api_url']  = trim($_POST['api_url']);
        $data['desc'] = trim($_POST['desc']);

        $reg_name = $this->site->getWebNameData($data['name']);
        $reg_url  = $this->site->getWebUrlData($data['url']);
        if($reg_name) {
            echo '2|当前网站名称已经存在，请重新填写网站名称！';
            exit;
        } elseif ($rea_url) {
            echo '2|当前网址已经被收藏，请重新填写网址！';
            exit;
        } else {
            $result = $this->site->addWebData($data);
            if($result) {
                echo '1|添加成功！';
                exit;
            } else {
                echo '2|添加失败，请联系网站管理员！';
                exit;
            }
        }
    }

    public function browseRecord($id) {
        if(isset($_COOKIE['_userv_'])) { 
            $sys_cookie = $_COOKIE['_userv_'];
            $sys_cookie = base64_decode($sys_cookie);
            $array_cookie = explode("|", $sys_cookie);
            if(count($array_cookie)>=3) { 
                $user_data = array(
                    'user_id'  => $array_cookie['0'],
                    'user_name'=> $array_cookie['2']
                );

                $this->site->createBrowseRecord($id, $user_data);
            }
        }

        $this->__p__['browse_record'] = $this->site->getBrowseRecord($id);
    }

    public function groupIng($id) {

        $group = $this->site->groupIng($id);

        $this->__p__['group'] = $group;
    }

    public function __main__() {
        $this->addSite();

        if(!isset($_GET['id']) || empty($_GET['id']) ) { return; }
        $id = intval($_GET['id']);

        $this->index($id);
        $this->getArea($id);
        $this->browseRecord($id);
        $this->netFriendComment($id);

        $this->groupIng($id);
    }

}