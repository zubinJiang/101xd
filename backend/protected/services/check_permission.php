<?php
if(!isset($_GET['action']) || 'check'!=$_GET['action']) { return; }
if(!isset($_GET['id']) || empty($_GET['id'])) { return; }

NBee::import('app/models/MRole');
NBee::import('app/models/MUser');

$this->user = new MUser();
$this->role = new MRole();   

$id = $_GET['id'];
$id_array  = explode("-", $id);
$module_id = intval($id_array[0]);
$permission= intval($id_array[1]);

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
if(!$user_id) {  //没有登录
    echo json_encode(array('result'=>0));
    exit;
}

$tmp_array = $this->role->findRoleByUserId($user_id);
$role_user = $tmp_array[0];

$role_array= explode(",",$role_user['role_id']);
$per_array = array();
foreach($role_array as $v) {
    $per = $this->role->getPermission($v, $module_id);
    $per_array[] = $per['permission'];
}

function checkAuth($per_array, $permission) {
    foreach($per_array as $v) {
        if($v&$permission) {
            return true;
        }
    }
    return false;
}

if(checkAuth($per_array, $permission)) {
    echo json_encode(array('result'=>1));
    exit;
} else {
    echo json_encode(array('result'=>2));
    exit;
}
?>
