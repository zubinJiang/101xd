<?php
if(empty($_GET['action'])) exit;

NBee::import('app/models/MVipproduct');
NBee::import('app/models/MUser');
NBee::import('plugin/Page/1.0/Page');

$this->user    = new MUser();
$this->vipproduct = new MVipproduct();
$id = $_GET['id'];
$num = 15;
$page = isset($_GET['page']) ? $_GET['page'] : "1";

//获取用户ID
function checkSysCookie($user) {

    if(!isset($_COOKIE['_userv_'])) { return false; }

    $sys_cookie = $_COOKIE['_userv_'];
    $sys_cookie = base64_decode($sys_cookie);
    $array_cookie = explode("|", $sys_cookie);
    if(count($array_cookie)<3) { return false;}

    $flag = false;
    if(!empty($array_cookie['0'])) {
        $flag = $user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
    }

    return $flag;
}

$user_id = checkSysCookie($this->user);

if($_GET['action']=='category'){

    $data = $this->vipproduct->getCategoryVipproductList($user_id, $id, $page, $num);
}

if($_GET['action']=='user_name'){

    $data = $this->vipproduct->getUsernameVipproductList($user_id, $id, $page, $num);

}

if($_GET['action']=='collect'){

    $data = $this->vipproduct->getCollectVipproductList($user_id, $id, $page, $num);

}

if($_GET['action']=='trac'){

    $data = $this->vipproduct->getTrackVipproductList($user_id, $id, $page, $num);

}

if($_GET['action']=='page'){

    $data = $this->vipproduct->getPageVipproductList($user_id, $page, $num);

}


if($_GET['action']=="set_trac"){

    $trac = $_GET['trac'];

    $query = $this->vipproduct->processTracVipproductData($trac, $id, $user_id);

    exit($query);
}
$rzt = "";
if(!empty($data['list'])){
    foreach($data['list'] as $v){ 
        if($v['category']=='1'){
            $category_type = "本地商品";
        } else if($v['category']=='2'){
            $category_type = "精品网货";
        } elseif($v['category']=='0') {
            $category_type = "其它";
        }

        if($v['state']=='0'){
            $state_comd = "未处理";
        } else if($v['state']=='1'){
            $state_comd = "审核通过";
        } else {
            $state_comd = "拒绝";
        }

        if($v['ad']=='0'){

            $ad_comd = "否";
        } else {

            $ad_comd = "是";
        }

        if($v['delivery']=='0'){
            $delivery_comd = "否";
        } else if($v['delivery']=='1') {
            $delivery_comd = "是";
        } else {
            $delivery_comd = "皆可";
        }

        if(!empty($v['insertdate'])){
        
            $date = date("Y-m-d", $v['insertdate']);
        }

        if($v['collect']=='1'){
            $collect_comd = "加入收藏";
        }elseif($v['collect']=='2'){
            $collect_comd = "已忽略";
        }else{
            $collect_comd = "推送区";
        }

            switch($v['trac'])
            {
            case 1: $trac_comd = "跟踪中"; break;
            case 2: $trac_comd = "已签合同"; break;
            case 3: $trac_comd = "已上团"; break;
            case 4: $trac_comd = "其它"; break;

            default: $trac_comd = "无记录";
            
            }

        $str_title = $v['title'];
        if(strlen($v['title'])>22){

            $str_title = mb_substr($v['title'],0,22,"utf-8")."...";
        }

        $rzt .= "<div class='neirong'><ul>";
        $rzt .= "<li class='mc'><a href='vipdetail?id={$v['id']}'>{$str_title}</a></li>";
        $rzt .= "<li style='width:84px;text-align:center'>{$v['uname']}</li>";
        $rzt .= "<li style='width:84px;text-align:center'>{$category_type}</li>";
        $rzt .= "<li style='width:84px;text-align:center'>{$v['cname']}</li>";
        $rzt .= "<li style='width:70px;text-align:center'>{$date}</li>";
        $rzt .= "<li style='width:50px;text-align:center'>{$delivery_comd}</li>";
        $rzt .= "<li style='width:70px;text-align:center'>{$ad_comd}</li>";
        $rzt .= "<li style='width:105px;text-align:center'>
        <span class='default_trac'><span class='trac_data_{$v['id']}'>{$trac_comd}</span>
        <a href='#' class='default_trac_edit'>（修改）</a>
        </span>
        <span class='edit_trac' style='display:none'>
        <select name='trac' class='edit_trac_select_{$v['id']}'>
            <option value='1'>跟踪中</option>
            <option value='2'>已签合同</option>
            <option value='3'>已上团</option>
            <option value='4'>其它</option>
        </select>
        <a href='javascript:void(0)' class='edit_trac_save' value='{$v['id']}'>保存</a>
        </span>
        </li>";
        $rzt .= "<li style='text-align:center;width:84px;margin:0'>{$collect_comd}</li>";
        $rzt .= "</ul></div>";

    }

}
$rzt .= "|";

$page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));

$rzt .= $page->show(4);

echo $rzt;exit;
?>
