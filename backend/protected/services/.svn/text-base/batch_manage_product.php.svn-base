<?php
if(empty($_REQUEST['action'])) exit;
if(empty($_REQUEST['id'])) exit;

NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');
NBee::import('app/models/MLog');

$this->product = new MProduct();
$this->user    = new MUser();
$this->log    = new MLog();
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
//权限判断
function hasPermission($user, $user_id, $module_id, $active_id) {
    
        $umr = $user->userRolePermssion($user_id, $module_id);

        if(empty($umr)) { return FALSE; }

        $flag = $umr['permission'] & $active_id;
        if($flag != $active_id) { return FALSE; }

        return TRUE;
}
//添加日志
function  addlog($log, $user_id, $table_name, $table_id, $record){
    $log_arr = array(
        'user_id'     => $user_id,
        'table_name'  => $table_name,
        'table_id'    => $table_id,
        'record'      => $record
    );
    $log->addLogData($log_arr);
}  

$user_id = checkSysCookie($this->user);
if(!$user_id) { 
    echo json_encode(array('result'=>0));
    exit;
}

$action        = trim($_REQUEST['action']);
$id            = trim($_REQUEST['id']);
$user_type     = trim($_GET['user_type']);

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
    if('admin' == $user_type){
        $flog = hasPermission($this->user, $user_id, 2, 2);
            
        if(!$flog) {
                exit('对不起,您无权操作此页面');
        }
    }

    $result = $this->product->batchDeleteProduct($user_id, $str_id);
    if(!empty($result)){
        addlog($this->log, $user_id, 'product', $str_id, '批量删除商品');
    }
} elseif('all_again'==$action) {
  
    $result = $this->product->batchAgainProduct($user_id, $str_id);
    if(!empty($result)){
       addlog($this->log, $user_id, 'product', $str_id, '批量重发商品'); 
    }
} elseif('all_expired'==$action) {

    $result = $this->product->batchExpiredProduct($user_id, $str_id);
    if(!empty($result)){
        addlog($this->log, $user_id, 'product', $str_id, '批量转为过期商品'); 
    }
}

echo json_encode(array('result'=>$result));
?>
