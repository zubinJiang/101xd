<?php
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


$rzt = $this->vipproduct->deleteVipproductData($user_id, $id);

echo $rzt;exit;
?>
