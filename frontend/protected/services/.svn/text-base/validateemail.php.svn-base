<?php
if ( isset($_GET['action']) && !empty($_GET['action']) && !empty($_GET['email'])) {
    NBee::import('app/models/MUser');
    NBee::import('app/models/MProduct');
    NBee::import('plugin/CSmtp/1.0/Email');
    $this->user    = new MUser();
    $this->product = new MProduct();

    $action = trim($_GET['action']);
    $email  = trim($_GET['email']);
    $id     = trim($_GET['id']);

    function toCharArray($intInput){  
        $len = strlen($intInput);  
        for($intIntJ=0; $intIntJ<$len; $intIntJ++){  
            $char[$intIntJ] = substr($intInput, $intIntJ, 1);      
        }  

        return $char;  
    } 


    function getZcm(){
        $result="";
        $randString='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        $arr= toCharArray($randString);
        for($i=0;$i<16;$i++){
            $result.=$arr[mt_rand(0,strlen($randString)-1)];
        }
        return $result;
    }


    if ('getname' == $action){
        if (empty($email)) {
            echo 0;
            exit;
        }

        $result= $this->user->validateUserByEmail($email, $id);

        echo $result;
    } 

    if ('getpwd'==$action) {

        $this->email = new Email();
        $this->email->initialize($this->config['smtp']);

        $from_user = $this->config['smtp']['fromUser'];
        $from_user = '=?UTF-8?B?'.base64_encode($from_user).'?=';

        $this->email->from($this->config['smtp']['fromEmail'], $from_user);
        $this->email->to($email);

        $subject = '[101团购供货平台] 找回密码通知信';
        $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';

        $host     = $_SERVER['HTTP_HOST'];
        $user     = $this->user->getUserDataById($id);
        $code     = getZcm();

        $this->user->forgetPwdEmail($id, $code);

        $product_list  = $this->product->getRecommend(2);
        if(!empty($product_list)) {

        $html = '<div style="width:720px;height:303px;padding:22px 0 0 30px;"><h2 style="width:720px;height:33px;line-height:33px;font-size:18px;color:#7d7d7d;float:left;">101兄弟－团购供货平台</h2><h3><a href="http://www.101xd.com/" target="_blank">今日商品推荐</a></h3><div style="width:690px;height:213px;float:left;padding:22px 0 0 30px;color:#666;">';

            foreach($product_list as $v) {
                $title = mb_substr($v['title'], 0, 10, 'utf8');

                if($v['market_price']>0 && is_numeric($v['supply_price'])) {
                    $num = $v['supply_price'] / $v['market_price'];
                    $num = $num * 10;
                    $zhe = number_format($num, 1, '.', '');
                    $string = "折扣价：{$zhe}折";
                } else {
                    $string = $v['supply_price'];
                }

                $html .= <<<EOF
<span style="float:left;width:260px;height:162px;margin-right:50px;border:1px #d9d9d9 solid;text-align:center;padding-top:8px;line-height:25px;overflow:hidden"><a href="http://www.101xd.com/product_{$v['id']}.html" target="_blank"><img src="{$v['default_image']}" width="148" height="106" /></a><br/><b style="font-size:14px;"><a href="http://www.101xd.com/product_{$v['id']}.html" target="_blank">{$title}</a></b><br/>
市场价：{$v['market_price']}元 {$string}</span>
EOF;
            }

            $html .= '</div></div>';
        }

        $template = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邮箱密码找回_101兄弟团购供货平台</title>
<style>
body,div,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,form{margin:0;padding:0}
body{font-size:12px;font-family:\5B8B\4F53,Arial;line-height:1.5}ul,ol,li{list-style:none}
h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:bold}input,textarea,select{font-size:12px;vertical-align:middle}
img{border:none}
a{text-decoration:none}
a:hover{text-decoration:underline}
.content_f h3 a{color:#ffb77d}
</style>
</head>
<body>
<div style="margin:0 auto;width:750px;height:121px;padding-top:12px">
  <a href="http://www.101xd.com" target="_blank"><img src="http://www.101xd.com/images/logo.gif" width="203" height="84" style="float:left;"/></a>
  <div style="float:right; width:438px; height:28px; position:absolute; left:567px; top:39px; background:#ffca85; border:1px #ff974a solid; line-height:28px; text-align:center;">您好，欢迎来到团购供货平台，企业营销新选择！ <a href="http://www.101xd.com" target="_blank">返回101兄弟首页</a></div>
</div>
<div style="margin:0 auto;width:750px;height:615px;background:url(http://www.101xd.com/images/content_bj.gif) repeat-x;">
  <div style="width:720px;height:255px;border-bottom:1px #CCC dashed;padding:37px 0 0 30px;">
    <h2 style="font-size:16px;float:left;width:720px;height:35px;line-height:35px">亲爱的用户 {$user['Name']}：您好！</h2>
    <p style="font-size:14px;padding-top:15px;float:left;width:720px;line-height:32px">您收到这封电子邮件是因为您 (也可能是某人冒充您的名义) 在101兄弟网站使用了密码找回功能。假如这不是<br />您本人所申请, 请不用理会这封电子邮件, 但是如果您持续收到这类的信件骚扰, 请您尽快联络网站客服人员。<br />
    <span style="font-weight:bold;">请点击以下链接启用密码：</span><br/>
    <a href="http://{$host}/forgetpwd?action=editpass&checknum={$code}&user_id={$id} " target="_blank">http://{$host}/forgetpwd?action=editpass&checknum={$code}&user_id={$id} </a>
    <br/><span style="font-weight:bold;float:right;">101兄弟</span>
    </p>
  </div>
  {$html}
</div>
<div style="margin:0 auto;width:750px;height:80px;border-top:1px #CCC solid;text-align:center;line-height:25px;padding-top:10px">WWW.101xd.com – 团购网站供货平台，企业营销新选择！<br />用户服务支持：service@101xd.com</div>
</body>
</html>
EOF;
        $this->email->subject($subject);
        $this->email->set_mailtype('html');
        $this->email->message($template);
        $this->email->send();

        $html = <<<EOF
       <div class="kuang7">
    <ul>
      <li>我们已将账户密码确认信息发送到您的注册邮箱：{$email}，请您尽快查收！</li>
      <li class="inp">
        <input type="botton" value="确&nbsp;定" name="input" rel="{$email}" />
      </li>
    </ul>
  </div> 
EOF;
        echo $html;
    }
}
?>

