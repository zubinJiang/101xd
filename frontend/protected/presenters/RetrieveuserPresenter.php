<?php
class RetrieveuserPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();

    }

    public function send($mobile, $content) {

        $serail = $this->config['sms']['serial'];
        $pass   = $this->config['sms']['pass'];

        $content .= '[101兄弟]';
        $content = mb_convert_encoding($content, 'GB2312', 'utf8');
        $flag = 0; 
        //要post的数据 
        $argv = array( 
            'sn'=> $serail, 
            'pwd'=> $pass, 
            'mobile'=>$mobile,
            'content'=>$content
        ); 
        //构造要post的字符串 
        foreach ($argv as $key=>$value) { 
            if ($flag!=0) { 
                $params .= "&"; 
                $flag = 1; 
            } 
            $params.= $key."="; $params.= urlencode($value); 
            $flag = 1; 
        } 
        $length = strlen($params); 
        $fp = fsockopen("sdk2.entinfo.cn",80,$errno,$errstr,10) or exit($errstr."--->".$errno); 
        $header = "POST /z_send.aspx HTTP/1.1\r\n"; 
        $header .= "Host:sdk2.entinfo.cn\r\n"; 
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
        $header .= "Content-Length: ".$length."\r\n"; 
        $header .= "Connection: Close\r\n\r\n"; 
        //添加post的字符串 
        $header .= $params."\r\n"; 
        //发送post的数据 
        fputs($fp,$header); 
        $inheader = 1; 
        while (!feof($fp)) { 
            $line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
            if ($inheader && ($line == "\n" || $line == "\r\n")) { 
                $inheader = 0; 
            } 
            if ($inheader == 0) { 
                // echo $line; 
            } 
        } 
        fclose($fp); 

        return $line;
    }


    public function getPass() {
        if(empty($_GET['action']) || 'getmess'!=$_GET['action']) { return; }
        if(empty($_GET['tel'])) { return; }
        if(empty($_GET['name'])) { return; }
        $user_tel  = $_GET['tel'];
        $user_name = $_GET['name'];
        $db_tel  = $this->user->findUserTel($user_name);
 
        if($user_tel!=$db_tel['UserTel']){
            echo json_encode(array('id'=>2, 'result'=>'您输入的手机号不是绑定此账号的手机！'));
            exit;
        } else {

            $data = array(
                'user_id' => $db_tel['UserID'],
                'mobile'  => $user_tel
            );

            for($i=0;$i<6;$i++){
                $rand = mt_rand(0,9);
                $rand_str .= $rand;
            }
            $content = "欢迎使用101兄弟手机短信密码找回，您请求的验证码是".$rand_str."，请在页面填写验证码完成验证。（如非本人操作，可不予理会）";
            $result = $this->send($user_tel, $content);
            if($result==1) {
                $data['status'] = 1; 
                $data['error_msg'] = '获取成功，请稍后查收';
                $this->user->addCodeUserID($db_tel['UserID'],$rand_str);

                $data['content'] = $content;
                $this->user->addUserSms($data);

                echo json_encode(array('id'=>1, 'uid'=>$db_tel['UserID'], 'result'=>''));
                exit;
            } else {
                $data['status'] = 2; 
                $data['error_msg'] = '对不起，序列号密码错误！';
                if('-1'==$result) {
                    $data['error_msg'] = '对不起，获取失败！';
                } elseif('-2'==$result) {
                    $data['error_msg'] = '对不起，参数有误！';
                    
                }

                $this->user->addUserSms($data);

                echo json_encode(array('id'=>2, 'result'=>$data['error_msg']));
                exit;
            }
        }

        exit;
    }


    public function updatepass(){
    
        if(empty($_GET['action']) || 'updatepass'!=$_GET['action']) { return; }
        if(empty($_POST['news_tel'])) { return; }
        if(empty($_POST['news_pass'])) { return; }
        $news_tel = $_POST['news_tel'];
        $news_pass = $_POST['news_pass'];
        $id = $_POST['user_id'];

        $this->__p__['user_name'] = $_POST['name'];
        $pass = $this->passWordHash->HashPassword($news_pass);
        $data = $this->user->updatePassWord($pass,$id);

        if(!empty($data)){
            $this->__p__['error_msg'] = "密码重新绑定成功";
        } else {
            $this->__p__['error_msg'] = "对不起，绑定失败";
        }

    }

    public function validateCode() {
        if(empty($_GET['action']) || 'code'!=$_GET['action']) { return; }
        $id = intval($_POST['user_id']);
        $code = trim($_POST['code']);

        $result = $this->user->findUserByCode($id);

        if(empty($code) || $result!=$code) {
            $this->__p__['error_tag'] = 2;
            $this->__p__['error_msg'] = '验证码有误，重新操作！';
        }
        $this->__p__['user_tel'] = $_POST['tel'];
    }

    public function __main__() {       
        if(empty($_GET['name']) && empty($_SERVER['HTTP_REFERER'])) {
            header('Location:/forget');
            exit;
        }

        
        $this->getPass();

        $this->validateCode();

        $this->updatepass();

    }
}
