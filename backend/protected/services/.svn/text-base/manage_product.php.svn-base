<?php
if(empty($_GET['action'])) exit;
if(empty($_GET['id']) || !is_numeric($_GET['id'])) exit;

NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');
NBee::import('app/models/MLog');

$this->user    = new MUser();
$this->product = new MProduct();
$this->log = new MLog();
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
//添加日志
function addlog($log, $user_id, $table_name, $table_id, $record){
    $log_arr = array(
        'user_id'     => $user_id,
        'table_name'  => $table_name,
        'table_id'    => $table_id,
        'record'      => $record
    );
    $log->addLogData($log_arr);
}  
$user_id = checkSysCookie($this->user);

//判断权限
function hasPermission($user, $user_id, $module_id, $active_id) {

    $umr = $user->userRolePermssion($user_id, $module_id);

    if(empty($umr)) { return FALSE; }

    $flag = $umr['permission'] & $active_id;
    if($flag != $active_id) { return FALSE; }

    return TRUE;
}

if(!$user_id) { 
    echo json_encode(array('result'=>0));
    exit;
}

$action        = trim($_GET['action']);
$id            = intval($_GET['id']);
$user_type     = trim($_GET['user_type']);


$result = 0;
if('delete'== $action) {

    if('admin' == $user_type){
        $flog = hasPermission($this->user,$user_id, 2, 2);
            
        if(!$flog) {
                exit('对不起,您无权操作此页面');
        }
    }

    $result = $this->product->deleteProduct($user_id, $id);
    addlog($this->log,$user_id, 'product', $id, '删除商品');
    

} elseif('again'==$action) {

    $result = $this->product->againProduct($user_id, $id);
    addlog($this->log,$user_id, 'product', $id, '重发商品品');

} elseif('shelf'==$action) {
    $result = $this->product->shelfProduct($user_id, $id);
    addlog($this->log,$user_id, 'product', $id, '下架商品');

} elseif('shelves'==$action) {
    $result = $this->product->shelvesProduct($user_id, $id);
    addlog($this->log,$user_id, 'product', $id, '上架商品');

}
    
echo json_encode(array('result'=>$result));
?>
