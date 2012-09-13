<?php
session_start();
if(!isset($_GET) && empty($_GET)){ return; }

NBee::import('app/models/MUser');
NBee::import('app/models/MProduct');
$this->product = new MProduct();
$this->user    = new MUser();

$url = $_GET['url'];
// user login validate
$output = "<div class='collect_form' style='display:none'>
    <div class='collect_body'>
        <p><span>很抱歉</span></p>
        <p>很抱歉，您还没有登录，请登录后再进行操作！<a href='/login?url={$url}'>登录</a></p>
    </div>
</div>";

if(!isset($_COOKIE['_userv_'])) { 
    echo $output;
    exit;
}

$sys_cookie = $_COOKIE['_userv_'];
$sys_cookie = base64_decode($sys_cookie);
$array_cookie = explode("|", $sys_cookie);
if(count($array_cookie)<3) { 
    echo $output;
    exit;
}

$flag = FALSE;
if(!empty($array_cookie['0'])) {
    $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
}

if(!$flag) {
    echo $output;
    exit;
}

$user_id = intval($array_cookie['0']);
// end user login validate

$pid = intval($_GET['id']);
if($pid) {
    $product = $this->product->getProductTitle($pid);
    $title   = $product['title'];
}

$action = isset($_POST["action"]) ? $_POST["action"] : "";

if(empty($action)) {
    $flag = $this->product->validateFavorite($user_id, $pid);

    $output = "<div class='collect_form' style='display:none'>
            <div class='collect_body'>
                <p><span>抱歉</span></p>
                <p>您已经收藏过这个商品，请<a href='/user/favorite'>查看收藏夹！</a></p>
            </div>
        </div>";

    if($flag) {
        $output = "<div class='collect_form' style='display:none'>
            <div class='collect_body'>
                <p><span>添加收藏</span></p>
                <p><input type='text' name='title' value='{$title}' /><select name='folder'><option value='0'>默认分类</option><option value='1'>精品网货</option><option value='2'>本地商品</option></select><input type='hidden' id='product_id' value='{$pid}'/><input type='submit' value='确 定' class='rine' /></p>
                <div class='contact-message' style='display:none'></div>
                <div class='contact-loading' style='display:none'></div>
            </div>
        </div>";
    } 

    echo $output;
} elseif('send'==$action) {
    $pid    = intval($_POST['id']);
    $title  = trim($_POST['title']);
    $folder = intval(trim($_POST['folder']));
    switch($folder) {
    case 1:
        $string = '精品网货';
        break;
    case 2:
        $string = '本地商品';
        break;
    default:
        $string = '默认分类';
    }

    $data = array(
        'user_id' => $user_id,
        'favorite_folder' => $folder,
        'product_id'      => $pid,
        'product_title'   => $title
        );

    $count = $this->product->addFavoriteData($data);

    $output = "<a href='javascript:void(0);' onclick='$.modal.close();' title='Close' class='modal-close'>x</a><div class='collection'><p>商品收藏成功！您已将商品收藏到“{$string}”的分类中；您共收藏了{$count}件商品，<a href='/user/favorite'>查看收藏夹！</a></p></div>";

    echo $output;
}
?>
