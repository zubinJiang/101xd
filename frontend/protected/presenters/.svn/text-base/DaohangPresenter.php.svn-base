<?php
class DaohangPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function index_data(){ //默认显示的数据
        if(!empty($_GET['action'])) { return; }
    
        $web_id = isset($_GET['web_id']) ? $_GET['web_id'] : '2';
        $page   = isset($_GET['page'])  ? $_GET['page']  : 1;

        $num = 24;
        $data = $this->site->getdata('1',$page,$num);

        $this->__p__['data']  = $data['data'];
        $this->__p__['count'] = $data['count'];

        $web_data = $this->site->web_getdata_index('1',$web_id, true);
        $this->__p__['web_data'] = $web_data; 

        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
        $this->__p__['page'] = $page;
    }

    public function getdata(){

        if(!isset( $_GET['action']) || $_GET['action'] != 'getdata' ) { return; }
        if(!isset( $_GET['id']) || empty($_GET['id']) ) { return; }
        $web_id = intval(isset($_GET['web_id']) ? $_GET['web_id'] : '2');

        if($_GET['action'] == 'getdata' && $_GET['id'] != ''){

            $id   = intval($_GET['id']);
            $page   = isset($_GET['page'])  ? $_GET['page']  : 1;
            $num = 24;
            $this->__p__['data'] = $data['data'];
            $this->__p__['count'] = $data['count'];

            $web_data = $this->site->web_getdata_index($id,$web_id, true);
            $this->__p__['web_data'] = $web_data; 
            $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
            $this->__p__['page'] = $page;

        }
    }

    public function  area_getdata(){

        if(!isset( $_GET['action']) || $_GET['action'] != 'area_getdata' ) { return;}
        if(!isset( $_GET['id']) || empty($_GET['id']) ) { return; }

        $web_id = isset($_GET['web_id']) ? $_GET['web_id'] : '2';
        $id     = $_GET['id'];
        $web_id = intval($web_id);
        $result = '';
        $page   = isset($_GET['page'])  ? $_GET['page']  : 1;
        $num = 24;
        $data = $this->site->getdata($id,$page,$num);
        $result = "";
        if(count($data['data'])==24){
            $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
            $result .= $page->show(4);
        }
        $result .= '|';
        if(empty($data)){
            $result .= '对不起，没有您要查找的数据！|对不起，没有您要查找的数据！';
            exit($result);
        } else {
            foreach($data['data'] as $v) {
                $hot_css = '';
                if($v['hot'] == 1){      
                    $hot_css = "style=color:#FF7E00;";
                }
                $result .= "<a {$hot_css} ref='{$v['id']}' id='{$v['id']}'>{$v['area']}</a>";
            }
        }
        
        $result .= '|';

        $web = array();
        //点击翻页不执行
        if($page==1){
            $web = $this->site->web_getdata_areas($id,$web_id);
        }
        if(empty($web)){
            $result .= '对不起，没有您要查找的数据！';
        } else {
            $result .= "<ul>";
            foreach($web as $k=>$v) {
            if($k>=0 && $k<=100) {
                $result .= "<li class='opencity' ><a  class='first' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
            } elseif($k>100 && $k<=300) {
                $result .= "<li class='opencity' ><a  class='two'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
            } elseif($k>300 && $k<=1000) {
                $result .= "<li class='opencity' ><a class='three'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
            } elseif($k>1000) {
                $result .= "<li class='opencity' ><a class='four' style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
            }
            }
            $result .= "</ul>";
        }

        exit($result);
    }

    public function area_web(){
        if( !isset($_GET['action']) || $_GET['action']!='area_web' ) { return; }
        if( !isset($_GET['id']) || empty($_GET['id']) ) { return; }

        $web_id = isset($_GET['web_id']) ? $_GET['web_id'] : '2';
        $id     = intval($_GET['id']);
        $web_id = intval($web_id);

        $web_data = $this->site->web_getdata($id, $web_id);
        $result = '';
        if(empty($web_data)) {
            $result .= '对不起，没有您要查找的数据！';
        } else {
             $result .= "<ul>";
             foreach($web_data as $k=>$v) {

                if($k>=0 && $k<=100) {
                    $result .= "<li class='opencity' ><a  class='first' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>100 && $k<=300) {
                    $result .= "<li class='opencity' ><a  class='two'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>300 && $k<=1000) {
                    $result .= "<li class='opencity' ><a class='three'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>1000) {
                    $result .= "<li class='opencity' ><a class='four' style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                }
             }
             $result .= "</ul>";
        }
        exit($result);
    }

    public function webSeach() {
        if(!isset($_GET['key']) || empty($_GET['key'])) { return; }

        $key = trim($_GET['key']);
        $data = $this->site->getWebSerach($key);
        $this->__p__['web_seach_data'] = $data;
        
    }

    public function getWebsite_logData() {
        $updatedate = $this->site->getWebsite_logData();
        $this->__p__['updatedate'] = $updatedate;
    }

    public function __main__() {

        $this->getRecommendList('local');
        $this->getWebsite_logData();
        $this->webSeach();

        $this->area_web();
        $this->area_getdata();
        $this->getdata();

        $this->index_data();

    }
}