<?php
if(!isset($_GET) && empty($_GET)){ return; }
NBee::import('app/models/MRebang');
$this->rebang = new MRebang();
$sort         = isset($_GET['sort']) ? $_GET['sort'] : 'bought';
$page         = isset($_GET['page']) ? $_GET['page'] : '1';
$action 	  = isset($_GET['action']) ? $_GET['action'] : '';
$way          = isset($_GET['way']) ? $_GET['way'] : 'desc';
$page  = intval($page);
$num   = 10;
if('page'==$action){
    NBee::import('plugin/Page/1.0/Page');

    if($page<=1) {$page=2;}
    $data = $this->rebang->getListData($sort, $way, $page, $num);

    $rzt = "";
    if(!empty($data)){

        foreach($data['data'] as $k=>$v){
            $str_title = $v['title'];

            $start_date = $v['starttime'];
            if(!empty($v['starttime'])){
                $start_date = date("Y-m-d",$v['starttime']);
            }

            $boughtperhour = floor($v['boughtperhour']*24);

            $ip = $v['ip'];

            $no = $page*10 + $k +1;
            $rzt .= "<div class='content4'><div class='content4_l'>";
            $rzt .= "<span class='shuzi'>{$no}.</span>";
            $rzt .= "<span class='im'><a href='{$v['url']}' target='_blank' rel='nofflow' ><img src='{$v['image']}' width='195' height='145' /></a></span>";
            $rzt .= "</div><div class='content4_r'>";
            $rzt .= "<h2><a href='{$v['url']}' target='_blank' rel='nofflow' >{$str_title}<br /></a></h2>";
            $rzt .= "<p class='ppp'><span class='gou'>购买量：{$v['bought']}</span><span class='gou'>销售额：￥{$v['Sales']}</span>";
            $rzt .= "<span class='startdate'>上团日期：{$start_date}</span>"; 
            $rzt .= "<span class='gou'>日均购买量：{$boughtperhour}</span><br/><span class='jia'>团购价：￥{$v['price']}</span>";
            $rzt .= "<span class='jia'>市场价：￥{$v['value']}</span>";
            $rzt .= "<span class='source'>信息来源：{$v['web_name']}</span><span class='jia'>日均IP：{$ip}</span></p>";
            $rzt .= "</div></div>";
        }
    }

    $rzt .= '|||||';

    $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));
    $rzt .= $page->show(4);
    $rzt .= " 共{$data['count']}个商品";

    echo $rzt;
    exit;
} 

if('sort'==$action){

    $data = $this->rebang->getListData($sort, $way);
    $rzt = "";
    if(!empty($data)){

        foreach($data['data'] as $k=>$v){
            $str_title = $v['title'];

            $start_date = $v['starttime'];
            if(!empty($v['starttime'])){
                $start_date = date("Y-m-d",$v['starttime']);
            }

            $boughtperhour = floor($v['boughtperhour']*24);

            $no = $k+1;
            if($k<3){
                if(strlen($v['title'])>16){
                    $str_title = mb_substr($v['title'],0,16,"utf-8");
                } 

                $rzt .= "<li>";
                $rzt .= "<div class='dingwei3'><img src='/images/no.{$no}.gif' width='63' height='63' /></div>";
                $rzt .= "<p class='p'><a href='{$v['url']}' target='_blank' rel='nofflow'><img src='{$v['image']}' width='158' height='111' /></a>";
                $rzt .= "<span class='ss'><span class='biaoti'><a href='{$v['url']}' target='_blank' rel='nofflow'>{$str_title}</a></span><span class='xinxi'>信息来源：<a href='####' title='日均IP：{$v['ip']}'>{$v['web_name']}</a></span><span class='xiaoshou'>销售额：￥{$v['Sales']}</span>";
                $rzt .= "</span></p>";
                $rzt .= "<p class='pp'><span class='sp'>购买量：{$v['bought']}</span><span class='spa'>上团日期：{$start_date}</span>";
                $rzt .= "<span class='spp'>日均购买量：{$boughtperhour}</span><span class='saa'>团购价：￥{$v['price']}</span>";
                $rzt .= "</p></li>";
                if($k==2){ $rzt .= "|||||";}
            } else {

                $rzt .= "<div class='content4'><div class='content4_l'>";
                $rzt .= "<span class='shuzi'>{$no}.</span>";
                $rzt .= "<span class='im'><a href='{$v['url']}' target='_blank' rel='nofflow'><img src='{$v['image']}' width='195' height='145' /></a></span>";
                $rzt .= "</div><div class='content4_r'>";
                $rzt .= "<h2><a href='{$v['url']}' target='_blank' rel='nofflow'>{$str_title}</a><br/></h2>";
                $rzt .= "<p class='ppp'><span class='gou'>购买量：{$v['bought']}</span><span class='gou'>销售额：￥{$v['Sales']}</span>";
                $rzt .= "<span class='startdate'>上团日期：{$start_date}</span>"; 
                $rzt .= "<span class='gou'>日均购买量：{$boughtperhour}</span><br/><span class='jia'>团购价：￥{$v['price']}</span>";
                $rzt .= "<span class='jia'>市场价：￥{$v['value']}</span>";
                $rzt .= "<span class='source'>信息来源：{$v['web_name']}</span><span class='jia'>日均IP：{$v['ip']}</span></p>";
                $rzt .= "</div></div>";

            }
        }
    }

    echo $rzt;
    exit();
}
?>
