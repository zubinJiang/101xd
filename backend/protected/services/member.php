<?php
session_start();
if(!isset($_GET['id']) || empty($_GET['id'])) { return; }
NBee::import('app/models/MUser');
NBee::import('app/models/MBusiness');
$this->user     = new MUser();
$this->business = new MBusiness();

// user login validate
$output = "<div id='detail'><ul><li>很抱歉，您还没有登录，请登录后再进行操作！</li></ul></div>";

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
if(!empty($array_cookie['0']) && isset($_SESSION['login_user_id']) && isset($_SESSION['login_user_name'])) {
    $flag = $this->user->checkUserByIdAndName($array_cookie[0], $array_cookie[2]);
}

if(!$flag) {
    echo $output;
    exit;
}

$user_id = intval($array_cookie['0']);
// end user login validate

//权限判断
function hasPermission($user, $user_id, $module_id, $active_id) {
    
        $umr = $user->userRolePermssion($user_id, $module_id);

        if(empty($umr)) { return FALSE; }

        $flag = $umr['permission'] & $active_id;
        if($flag != $active_id) { return FALSE; }

        return TRUE;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
if(empty($action)) {
$id   = intval($_GET['id']);
$user = $this->user->getUserData($id);

if(empty($user)) {
    echo "<div id='detail'><ul><li>抱歉，参数错误！</li></ul></div>";
    exit;
}
$flog = hasPermission($this->user, $user_id, 6, 2);
            
if(!$flog) {
    exit('对不起,您无权操作此页面');
}
$output = "<div id='detail'>
	<ul>
    	<li><label>会员名：</label>{$user['Name']}</li>";

if($user['UserType']==1) {
    $user_type = '渠道商';
    $data = $this->user->getGroupByUserId($id);

    $output .= "<li><label>会员类型：</label>{$user_type}</li>
        <li><label>网站名称：</label>{$data['name']}</li>
        <li><label>网站地址：</label>{$data['url']}</li>";

} else {
    $user_type = '供货商';
    $data = $this->business->getNameAndCategory($id);

    $output .= "<li><label>会员类型：</label>{$user_type}</li>
        <li><label>商家名称：</label>{$data['name']}</li>
        <li><label>经营范围：</label>{$data['category_name']}</li>";
}

if($user['UserTel']==$id) {
    $user['UserTel'] = '';
}
$output .= "
        <li><label>联系电话：</label>{$user['UserTel']}</li>
    </ul>
</div>
";
echo $output;
} elseif ('delete'==$action) {

    $id = $_GET['id'];
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

    $result = $this->user->delUser($str_id);
    echo json_encode(array('result'=>$result));
    exit;
}
?>
