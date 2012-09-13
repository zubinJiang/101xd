<?php
session_start();

$output = "<div id='detail'><ul><li>很抱歉，您还没有登录，请登录后再进行操作！</li></ul></div>";

if(!isset($_COOKIE['_userv_']) || empty($_GET['action'])) { 
    echo $output;
    exit;
}
NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');

$this->product = new MProduct();
$this->user = new MUser();

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
if(!in_array($user_id, array(1,175,189))) {
    echo $output;
    exit;
}

function hasPermission($user, $user_id, $module_id, $active_id) {
    
    $umr = $user->userRolePermssion($user_id, $module_id);

    if(empty($umr)) { return FALSE; }

    $flag = $umr['permission'] & $active_id;
    if($flag != $active_id) { return FALSE; }

    return TRUE;
}

if('move'==$_GET['action']) {
    $flog = hasPermission($this->user, $user_id, 2, 8);
            
    if(!$flog) {
        exit('对不起,您无权操作此页面');
    }

    $id = intval($_GET['id']);

    $product = $this->product->getProductById($id);
    if(empty($product)) {
        echo $output;
        exit;
    }

    $output = "<div id='detail'>
        <ul>
        <li><label>产品标题：</label>{$product['title']}<input type='hidden' value='{$id}' id='pid' /></li>";

    $category = '本地商品';
    if('net'==$product['category']) {
        $category = '网货精品';
    } elseif('goldroll'==$product['category']) {
        $category = '代金券';
    }

    $category_data = $this->product->getProductCateogryList(2);

    $output .= "<li><label>所属类别：</label>{$category} - {$product['cname']}</li>";
    $output .= "<li style='color:red;text-align:center;'>------------------移动到------------------</li>";
    $output .= "<li><label>所属大类：</label><select name='category' id='change_category'><option value='2'>本地商品</option><option value='3'>网货精品</option><option value='4'>代金券</option></select></li>";
    $output .= "<li><label>详细类别：</label><select name='category_id' id='category_id'>";
    foreach($category_data as $v) {
        $output .= "<option value='{$v['id']}'>{$v['name']}</option>";
    }

    $output .="</select></li>";
    $output .= "<li></li>";
    $output .= "<li><input type='button' name='sure' calss='sure' value='确定' style='width:80px;height:30px;'></li>";
    $output .= '</ul></div>';

    echo $output;
    exit;
}

if('moveto'==$_GET['action']) {
    $pid = intval($_POST['id']);
    $cat = intval($_POST['ca']);
    $cid = intval($_POST['ci']);

    $category = 'local';
    if(3==$cat) {
        $category = 'net';
    } elseif(4==$cat) {
        $category = 'goldroll';
    }

    $flag = $this->product->changeCategory($pid, $category, $cid);

    if($flag) {
        $output = '移动产品成功';
    } else {
        $output = '移动产品失败,可能该产品的类别属于您要更改的类别';
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

if('change'==$_GET['action']) {
    $cid = intval($_GET['id']);
    if($cid>4 || $cid<2) { $cid=2; }
    $category_category= $this->product->getProductCateogryList($cid);

    $output = '';
    foreach($category_category as $v) {
        $output .= "<option value='{$v['id']}'>{$v['name']}</option>";
    }

    echo $output;
    exit;
}
?>
