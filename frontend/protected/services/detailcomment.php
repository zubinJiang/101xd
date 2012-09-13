<?php
session_start();
if(!isset($_COOKIE['_userv_']) || empty($_SESSION['login_user_id']) || empty($_SESSION['login_user_name'])) { 
    echo json_encode(array('id'=>2, 'result'=>'请先登录后再发布评论！')); 
    exit; 
}

if(!isset($_GET['action']) || 'comment'!=$_GET['action']) { exit; }

NBee::import('app/components/Cookies');
NBee::import('app/models/MUser');
NBee::import('app/models/MComment');

$this->user    = new MUser();
$this->comment = new MComment();

$web_id  = trim($_GET['wid']);
$name    = trim($_GET['name']);
$quality = intval($_GET['quality']);
$services= intval($_GET['services']);
$price   = intval($_GET['price']);
$reason  = trim($_GET['reason']);
$niming  = intval($_GET['niming']);

if(empty($name)) {
    echo json_encode(array('id'=>3, 'result'=>'请先填写购买的商品名称！'));
    exit; 
}

if(1==$quality || 1==$services || 1==$price) {
    if(empty($reason)) {
        echo json_encode(array('id'=>3, 'result'=>'请先填写购买的商品名称！'));
        exit; 
    }
}

$sys_cookie = $_COOKIE['_userv_'];
$sys_cookie = base64_decode($sys_cookie);
$array_cookie = explode("|", $sys_cookie);
if(count($array_cookie)<3) { 
    echo json_encode(array('id'=> 2, 'result'=>'请登录后再发布评论！'));
    exit;
}

$flag = FALSE;
if(!empty($array_cookie['0'])) {
    $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
}

if(!$flag) {
    echo json_encode(array('id'=> 2, 'result'=>'请登录后再发布评论！'));
    exit;
}

$user_id = intval($array_cookie['0']);
if($user_id<1) {
    echo json_encode(array('id'=>2, 'result'=>'请登录后再发布评论！'));
    exit;
}

$user_name = $array_cookie['2'];

$data = array(
    'website_id' => $web_id,
    'user_id'    => $user_id,
    'user_name'  => $user_name,
    'product_name' => $name,
    'product_quality' => $quality,
    'after_service'   => $services,
    'product_price'   => $price,
    'reason'          => $reason,
    'anonymity'       => $niming
    );

$result = $this->comment->insertComment($data);
if(!$result) {
   echo json_encode(array('id'=>4, 'result'=>'发布失败，请联系网站管理员！'));
   exit;
} 

echo json_encode(array('id'=>1, 'result'=>'发布成功！'));
exit;
?>
