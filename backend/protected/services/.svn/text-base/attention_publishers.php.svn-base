<?php
if(empty($_GET['action'])) exit;
if(empty($_GET['id'])) exit;

NBee::import('app/models/MUser');
NBee::import('app/models/MAttentionPublishers');
NBee::import('app/models/MLog');

$this->user      = new MUser();
$this->publisher = new MAttentionPublishers();
$this->log = new MLog();

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
if(!$user_id) { 
    echo json_encode(array('result'=>0));
    exit;
}

$action = trim($_GET['action']);
$id     = trim($_GET['id']);
$type   = trim($_GET['type']);

$tmp_id   = array();
$id_array = explode("-", $id);
foreach($id_array as $v) {
    if(is_numeric($v)) {
        $tmp_id[] = intval($v);
    }
}
$publisher_id = implode(",", $tmp_id);

$result = 0;
$id     = 0;

$parameter = array('cancel','all_cancel','all_ignore','cancel_ignore');
if(in_array($action, $parameter)) {
    if('cancel_ignore'==$action) {
        $result = $this->publisher->cancelIgnore($user_id, $publisher_id);
    } elseif('all_ignore'==$action) {
        $result = $this->publisher->ignoreAttention($user_id, $publisher_id, $type);
    } else {
        $result = $this->publisher->cancelAttention($user_id, $publisher_id, $type);
    }
}

if(!empty($type)) {
    $count = $this->publisher->getCount($user_id, 'passive');
} else {
    $count = $this->publisher->getCount($user_id);
}

if($result){
    $log_arr = array(
        "user_id"=>$user_id,
        "table_name"=>"attention_publishers",
        'table_id'=>$publisher_id,
        "record"=>"取消关注"
    );
    $this->log->addLogData($log_arr);
}

if(0==$count) { 
    $id=1; 
    $result = '您好，暂时没有数据了。';
}

echo json_encode(array('id'=>$id, 'count'=>$count, 'result'=>$result));
?>
