<?php
session_start();

$output = "<div id='detail'><ul><li>很抱歉，您还没有登录，请登录后再进行操作！</li></ul></div>";

if(!isset($_COOKIE['_userv_']) || empty($_GET['action'])) { 
    echo $output;
    exit;
}
NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');
NBee::import('app/models/MLog');

$this->product = new MProduct();
$this->user = new MUser();
$this->log = new MLog();

$sys_cookie = $_COOKIE['_userv_'];
$sys_cookie = base64_decode($sys_cookie);
$array_cookie = explode("|", $sys_cookie);
if(count($array_cookie)<3) { 
    echo $output;
    exit;
}

$flag = FALSE;
if(!empty($array_cookie['0']) && isset($_SESSION['login_user_id']) && isset($_SESSION['login_user_name'])) {
    $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
}

if(!$flag) {
    echo $output;
    exit;
}

$user_id = intval($array_cookie['0']);

function hasPermission($user, $user_id, $module_id, $active_id) {
    
    $umr = $user->userRolePermssion($user_id, $module_id);

    if(empty($umr)) { return FALSE; }

    $flag = $umr['permission'] & $active_id;
    if($flag != $active_id) { return FALSE; }

    return TRUE;
}

if('through'==$_GET['action']) {

    $id = intval($_GET['id']);
    $output = "<div id='detail'>
        <ul>
        <li><label>理由：</label><input type='hidden' value='{$id}' id='pid' /></li>";

    $output .= "<li><textarea name='reason' id='reason' rows='6' cols='40'></textarea></li>";
    $output .= "<li></li>";
    $output .= "<li><input type='button' name='sure' calss='sure' value='确定' style='width:80px;height:30px;'></li>";
    $output .= '</ul></div>';

    echo $output;
    exit;
}

if('submit'==$_GET['action']) {
    $pid = intval($_POST['id']);
    $msg = trim($_POST['msg']);

    $flag = $this->product->notThrough($user_id, $pid, $msg);

    if($flag) {
        $output = '审核成功，产品没有通过';
    } else {
        $output = '审核失败，可能该产品已经是不通过状态';
    }

    $log_arr = array(
        'user_id'     => $user_id,
        'table_name'  => 'product',
        'table_id'    => $pid,
        'record'      => $output
    );
    $this->log->addLogData($log_arr);

    
    echo $output;
    exit;
}

?>
