<?php

if ( isset($_GET['action']) && !empty($_GET['action'])) {
    NBee::import('app/models/MSite');
    $this->site = new MSite();
    $method = trim($_GET['action']);
    $id     = trim($_GET['id']);
    $type   = trim($_GET['web_id']);
    $type   = intval($type);
    $result = '';
    $data   = array();
    $page   = isset($_GET['page'])  ? $_GET['page']  : 1;
    $num = 24;

    if($method=='area_web'){
        $data = $this->site->web_getdata($id, $type);
    } else if($method=='area_getdata'){

        $data=$this->site->web_getdata_areas($id,$type);
    } else {

        $id = intval($id);
        if(1==$id) {
            $data = $this->site->web_getdata_index($id,$type, true);
        } else {
            $data = $this->site->web_getdata_index($id,$type,true);
        }
    }

    if(empty($data)) {

        $result .= '对不起，暂时没有数据！';
    } else {

      $key = (1==$type) ? 'scale' : 'cn_rank';

      if(2==$type) { 

            $result .="<ul>";
            foreach($data as $k=>$v) {
                if($k>=0 && $k<=100) {
                    $result .= "<li class='opencity'><a  class='first' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>100 && $k<=300) {
                    $result .= "<li class='opencity'><a  class='two'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>300 && $k<=1000) {
                    $result .= "<li class='opencity'><a class='three'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                } elseif($k>1000) {
                    $result .= "<li class='opencity'><a class='four' style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
                }
            }
            $result .="</ul>";
        }  elseif(1==$type) { // scale
            $result .="<ul>";
            foreach($data as $v) {
                if($v[$key]>=100) {
                    $result .= "<li class='opencity'><a  class='first' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}({$v['scale']})</a></li>";
                    
                } elseif($v[$key]>=50 && $v[$key]<100){
                    $result .= "<li class='opencity'><a  class='two'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}({$v['scale']})</a></li>";
                    
                } elseif($v[$key]>=10 && $v[$key]<50){
                    $result .= "<li class='opencity'><a class='three'style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}({$v['scale']})</a></li>";
                } else {
                    $result .= "<li class='opencity'><a class='four' style='display:none;' ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}({$v['scale']})</a></li>";
                }

            }
            $result .="</ul>";
        }

    }
    exit($result);
}

?>
