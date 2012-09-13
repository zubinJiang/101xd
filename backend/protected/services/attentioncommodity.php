<?php
if(!isset($_GET['action']) || 'cancel'!=$_GET['action']) { return; }
if(!isset($_GET['id']) || empty($_GET['id'])) { return; }

NBee::import('app/models/MAttention');
NBee::import('app/models/MLog');
NBee::import('app/models/MUser');

$this->attention = new MAttention();
$this->log       = new MLog();
$this->user      = new MUser();

function checkSysCookie($user) {

    if(!isset($_COOKIE['_userv_'])) { return false; }

    $sys_cookie = $_COOKIE['_userv_'];
    $sys_cookie = base64_decode($sys_cookie);
    $array_cookie = explode("|", $sys_cookie);
    if(count($array_cookie)<3) { return false;}

    $flag = false;
    if(is_numeric($array_cookie['2'])) {
        $flag = $user->checkUserByIdAndSinaId($array_cookie[0], $array_cookie[2]);
    } else {
        $flag = $user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
    }

    return $flag;
}
$user_id = checkSysCookie($this->user);
if(!$user_id) { 
    echo '';
    exit;
}
    $str = $_GET['id'];
    
    $data = $this->attention->cancelAttentionData($user_id, $str);
    if(!empty($data)){
    $log_arr = array(
                    "user_id"=>$user_id,
                    "table_name"=>"attention_product",
                    'table_id'=>$str,
                    "record"=>"取消关注"
    );
    $this->log->addLogData($log_arr);
   }
    echo $data;
?>
