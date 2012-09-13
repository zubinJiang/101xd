<?php
if(empty($_REQUEST['action'])) exit;
if(empty($_REQUEST['id'])) exit;

NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');
NBee::import('app/models/MLog');

$this->product = new MProduct();
$this->user    = new MUser();
$this->log     = new MLog();

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
$user_id = intval($user_id);
if($user_id==0) { 
    echo json_encode(array('result'=>0));
    exit;
}

$action = trim($_REQUEST['action']);
$id     = trim($_REQUEST['id']);

$tmp_id   = array();
$id_array = explode(",", $id);
foreach($id_array as $v) {

    if(is_numeric($v)) {
        $tmp_id[] = $v;
    }
}

if(empty($tmp_id)) exit('请确认id为整数');

$result = 0;
$str_id = implode(",", $tmp_id);

if('all_delete' == $action) {
    $result = $this->product->delFavoriteData($user_id, $str_id);
    if(!empty($result)){
    $log_arr = array(
                    "user_id"=>$user_id,
                    "table_name"=>"favorite",
                    'table_id'=>$str_id,
                    "record"=>"删除收藏商品"
    );
    $this->log->addLogData($log_arr);
    }
}
echo json_encode(array('result'=>$result));
?>
