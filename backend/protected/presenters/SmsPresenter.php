<?php
class SmsPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();

        NBee::import('app/models/MSms');
        $this->sms = new MSms();
    }

    public function send($mobile, $content) {

        $serail = $this->config['sms']['serial'];
        $pass   = $this->config['sms']['pass'];

        $content .= '[101兄弟]';
        $content = mb_convert_encoding($content, 'GB2312', 'utf8');
        $flag = 0; 
        $argv = array( 
            'sn'=> $serail, 
            'pwd'=> $pass, 
            'mobile'=>$mobile,
            'content'=>$content
        ); 

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
        $header .= $params."\r\n"; 
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

    public function addSMS($user_id) {
        if(empty($_GET['action']) || 'send'!=$_GET['action']) { return; }

        if(!$this->hasPermission($user_id, 4, 2)) { exit('not auth!'); }

        $tmp_mobile = trim($_POST['mobile']);
        $tmp_content= trim($_POST['content']);

        if(empty($tmp_mobile) || empty($tmp_content)) {
            $this->__p__['error_msg'] = '手机号或内容为空！';
        }

        if(empty($this->__p__['error_msg'])) {

            $mobile_array = explode(' ', $tmp_mobile);
            $tmp = array();
            foreach($mobile_array as $v) {
                $tmp[] = $v;
            }
            $mobile = implode(',', $tmp);

            $data = array(
                'user_id' => $user_id,
                'mobile'  => $mobile,
                'content' => $tmp_content
            );

            $result = $this->send($mobile, $tmp_content);
            if($result==1) {
                $data['status'] = 1; 
                $this->__p__['error_msg'] = '短信,发送成功！';
            } else {
                $data['status'] = 2; 
                $data['error_msg'] = '短信,序列号密码错误！';
                if('-1'==$result) {
                    $data['error_msg'] = '短信,发送失败！';
                } elseif('-2'==$result) {
                    $data['error_msg'] = '短信,参数错误！';
                }
                $this->__p__['error_msg'] = $data['error_msg'];
            }

            $rzt = $this->sms->addSms($data);

            $this->writeLog($user_id, $rzt, 'sms', $this->__p__['error_msg']);

            unset($data);
            unset($result);
            unset($mobile);
            unset($tmp_mobile);
            unset($tmp_content);
        }
    }

    public function hasSend($user_id) {
        if(empty($_GET['action']) || 'post'!=$_GET['action']) { return; }

        if(!$this->hasPermission($user_id, 4, 1)) { exit('not auth!'); }

        $num = 10;
        $page= isset($_GET['page']) ? intval($_GET['page']) : 1;
    
        $data = $this->sms->getDataList($user_id, $page, $num); 

        $this->__p__['data_list'] = $data['list'];
        $this->__p__['page']=new Page(array('total'=>$data['count'], 'perpage'=>$num, 'page_name'=>'page'));
    }


    public function __main__() {
        $user_id = $this->checkLoginStatus(); 
        if(!$this->hasPermission($user_id, 4, 1)) { exit('not auth!'); }

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->addSMS($user_id);
        $this->hasSend($user_id);
    }

}

?>
