<?php
NBee::import('app/models/MSite');
$this->site = new MSite();

if(!empty($_GET['id']) && 'areaname'==$_GET['action']){
    //获取直辖市对应的地区ID
    $id = intval($_GET['id']);
    $data = $this->site->getProvinceAreaID($id);
    exit($data['id']);
}

if(!empty($_GET['id']) && 'cityname'==$_GET['action']){
    $id = intval($_GET['id']);

    $data = $this->site->getAreaList($id);

    if(!empty($data)) {
        $rzt = '';
        foreach ($data as $v) {
            
            $rzt .= "<a href='#' class='item_area' key={$v['id']} value={$v['name']}>{$v['name']}</a>&nbsp;&nbsp;"; 
        }
        exit($rzt);
    }
}

$area_data = $this->site->getdata(1);
$pr_data = $this->site->getProvinceData();
$arr = '主要城市：<hr>';
if(!empty($area_data)){
    foreach($area_data as $v){
            $arr .= "<a href='#' class='area'  value={$v['area']} key={$v['id']}>{$v['area']}</a>";
    }
}
$arr .= "<hr>全部省份:<hr><ul>";
if(!empty($pr_data)) {
    foreach($pr_data as $v){
        $arr .= "<li><a href='#' class='province' key={$v['id']} value={$v['name']}>{$v['name']}</a>
            <div class='area_type' style='display:none;' id={$v['id']}></div></li>";
    }
}
$arr .= '</ul>';
echo $arr;
?>
