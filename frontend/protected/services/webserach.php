<?php
if ( isset($_GET['action']) && !empty($_GET['action'])) {
    NBee::import('app/models/MSite');
    $this->site = new MSite();
    $key = $_GET['key'];
    $data = $this->site->getWebSerach($key);
    $rzt = '';
    if(!empty($data)){
        $rzt .= "<ul>";
        foreach($data as $v){
            $rzt .= "<li><a  ref='{$v['id']}' id='{$v['id']}' href='detail?id={$v['id']}'>{$v['name']}</a></li>";
        }
        $rzt .= "</ul>";
    
    } else {
        $rzt .= "对不起，当前没有你要搜索的网站";
    }
    echo $rzt;
}
