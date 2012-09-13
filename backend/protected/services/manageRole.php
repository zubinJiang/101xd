<?php
if(!isset($_GET['action']) || 'del'!=$_GET['action']) { return; }
if(!isset($_GET['id']) || empty($_GET['id'])) { return; }

NBee::import('app/models/MRole');
NBee::import('app/models/MUser');

$this->user = new MUser();
$this->role = new MRole();   

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
if(!$user_id) {  //没有登录
    echo json_encode(array('result'=>0));
    exit;
}

$tmp_array  = $this->role->findRoleByUserId($user_id);
if(empty($tmp_array)) { //没有角色的成员

    echo json_encode(array('result'=>2));
    exit;
} else {

    $role_array = array();
    foreach($tmp_array as $v) {
        $role_array[] = $v['role_id'];
    }

    if(!in_array('1',$role_array)) {  //不是超级管理员
        echo json_encode(array('result'=>2));
        exit;
    }
}

$id   = trim($_REQUEST['id']);
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
$result = $this->role->delRole($str_id);
if($result) {
    $manage_result = 1;
} else {
    $manage_result = 3;
}

echo json_encode(array('result'=>$manage_result));
?>
