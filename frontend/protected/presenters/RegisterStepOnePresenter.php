<?php
class RegisterStepOnePresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
        NBee::import('app/models/MCode');
        $this->code    = new MCode();
    }
    public function CheckData() {
        $_POST['username'] ? $_POST['username'] : '';
        $_POST['usercom'] ? $_POST['usercom'] : '';
        $_POST['userpass'] ? $_POST['userpass'] : '';
        $_POST['userpassconf'] ? $_POST['userpassconf'] : '';
        $_POST['email'] ? $_POST['email'] : '';
        $_POST['phone'] ? $_POST['phone'] : '';
        $data = array();
        //验证POST的数据是否合法
        if (!empty($_POST['username'])){
            $user = $this -> user -> findUserByName($_POST['username']);
            if ($user){
                $data['username_msg']['status'] = 0;
                $data['username_msg']['msg'] = '用户名存在';
                }
            else{
                $data['username_msg']['status'] = 1;
                $data['username_msg']['msg'] = '可以注册';
                }
        }
        else{
            $data['username_msg']['status'] = 0;
            $data['username_msg']['msg'] = '用户名必须填写';
        };
        if (!empty($_POST['usercom'])){
            $data['usercom_msg']['status'] = 1;
            $data['usercom_msg']['msg'] = '可以注册';
        }
        else{
            $data['usercom_msg']['status'] = 0;
            $data['usercom_msg']['msg'] = '企业名输入有误';
        }
        if (!empty($_POST['userpass']) && !empty($_POST['userpassconf'])){
            $data['userpass_msg']['status'] = 1;
            $data['userpass_msg']['msg'] = '可以注册' ;
        }
        else{
            $data['userpass_msg']['status'] = 0;
            $data['userpass_msg']['msg'] = '用户密码输入不合法' ;
        }
        if (!empty($_POST['email'])){
            $data['email_msg']['status'] = 1;
            $data['email_msg']['msg'] = '可以注册';
        }
        else{
            $data['email_msg']['status'] = 0;
            $data['email_msg']['msg'] = '邮箱地址必须填写';
        }
        if (!empty($_POST['phone'])){
            $data['phone_msg']['status'] = 1;
            $data['phone_msg']['msg'] = '可以注册';
        }
        else{
            $data['phone_msg']['status'] = 0;
            $data['phone_msg']['msg'] = '电话号码必须填写';
            }
        if ($data['username_msg']['status'] && $data['usercom_msg']['status'] && $data['email_msg']['status'] && $data['phone_msg']['status'] && $data['userpass_mag']['status']){
        
        $user = array();
        $user['UserType'] = intval($_POST['user_type_hidden']);
        $user['Name']     = $_POST['username'];
        $user['UserTel']  = $_POST['phone'];
        $user['Password'] = $_POST['userpass'];
        $user['Email']    = $_POST['email'];
        $user['CompanyName'] = $_POST['usercom'];
        
        $this -> user -> regisNewUser($);
        }
        echo json_encode($data);
            exit;
        }

    public function CheckUserExist(){
        $data = array();
        if (!empty($_GET['username'])){
            $user = $this -> user -> findUserByName($_POST['username']);
            if ($user){
                $data['username_msg']['status'] = 0;
                $data['username_msg']['msg'] = '用户名存在';
                }
            else{
                $data['username_msg']['status'] = 1;
                $data['username_msg']['msg'] = '可以注册';
                } 
            }
        else{
            $data['username_msg']['status'] = 0;
            $data['username_msg']['msg'] = '用户名必须输入';
        }
        echo json_encode($data);
        exit;
    }

    //验证手机号码是否存在
    public function VerifyMobile($mobile){
        $res = $this->user->validateTel($moblie);
        return $res;
    }
    public function SendSMS($mobile, $content){
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
        } 
        fclose($fp); 
        return $line;
    } 

    public function SendCode(){
    $_GET['action'] ? $_GET['action'] :'';
    if ($_GET['action'] == 'checkusername'){
        $this->CheckUserExist(); 
    }
    //发送验证码
    if ($_GET['action'] == 'sendsms'){
        for($i=0;$i<6;$i++){
            $rand = mt_rand(0,9);
            $rand_str .= $rand;
            };
        $content = "欢迎使用101兄弟手机短信会员注册，您的验证码是".$rand_str."，请在页面填写验证码完成验证。（如非本人操作，可不予理会）";
        $t_ = $this->VerifyMobile($mobile);
        if ($t_){
            $res_ = $this->SendSMS($_GET['mobile'],$content);
            if ($res_ ==1 ){ 
                $data['status'] = 1;
                $data['msg'] = '手机号码可用';
                $data['code'] = $rand_str;
                $data['mobile'] = $_GET['mobile'];
                echo json_encode($data);
                exit;}
            else{
                $data['status'] = 2;
                $data['msg'] = '发送短信系统故障';
                echo json_encode($data);
                exit;
                    }
                }
        else{
            $data['status'] = 0;
            $data['msg'] = '该手机号码已经注册';
            echo json_encode($data);
            exit;
            }
            }
    else{   
        }
        }
  
    
    
    }
public function __main__() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->CheckData();
        }     
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $this->SendCode();
        }
    }
