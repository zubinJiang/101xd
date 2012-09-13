<?php

NBee::import('app/models/MBusiness');
NBee::import('app/models/MUser');
NBee::import('app/models/MLog');
NBee::import('plugin/Page/1.0/Page');

$this->business = new MBusiness();
$this->user     = new MUser();

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
if(empty($user_id)) {
    echo <<<EOF
    请登录后，再进行操作。
EOF;
    exit;
}
$num  = 10;
$page = empty($_GET['page']) ? 1 : $_GET['page'];
$list = $this->business->findDataByUserId($user_id, $page, $num);
$count= $this->business->getCountByUser($user_id);
if(empty($list)) {
   echo <<<EOF
   您以前没有添加过商家信息。
EOF;
    exit;
} 

$page=new Page(array('total'=>$count,'perpage'=>$num,'page_name'=>'page'));

$html = <<<EOF
<div id="inbound">
  <ul>
EOF;
foreach($list as $v) {

    $name  = mb_substr($v['name'], 0, 8, 'utf-8');
    $html .= <<<EOF
       <li><input type="radio" name="business" value="{$v['id']}" /><span>{$name} {$v['tel']}</span></li>
EOF;
}
$html .= <<<EOF
 </ul>
EOF;
echo <<<EOF
</div>
EOF;
echo $html;
echo $page->show(4);
exit;
?>
