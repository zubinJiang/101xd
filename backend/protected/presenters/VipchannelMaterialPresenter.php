<?php
class VipchannelMaterialPresenter extends InitPresenter
{
    public function __init__() {
    
        parent::__init__();
    }

    public function index($user_id){
        $user_data = $this->user->getUserData($user_id);

        $this->__p__['user_data']  = $user_data;

        $this->__p__['province'] = $this->province->getProvinceList();

        $category = $this->vipcategory->getVipcategoryList();

        $this->__p__['category'] = $category;

        
        if(!empty($user_data['CompanyID'])){

            $company_data = $this->company->getCompanyById($user_data['CompanyID']);

            $this->__p__['company_data'] = $company_data;

            if(!empty($company_data['address_id'])){

                $address_data = $this->address->getAddressById($company_data['address_id']);

                if(!empty($address_data['province_id'])) {

                    $city_province_list = $this->province->getCityList($address_data['province_id']);

                    
                    $this->__p__['city_list'] = $city_province_list;
                }

                $this->__p__['address_data'] = $address_data;   
            }
        
        }
    }

    public function postUserData($user_id){
        $user = array();
        $user['Name']        = $_POST['user_name'];
        $user['CompanyName'] = $_POST['comapny_name'];
        $user['Email']       = $_POST['email'];
        $user['UserTel']     = $_POST['tel'];
        $user['CompanyID']   = $_POST['company_id'];
        $user['UserID']      = $user_id;
        $user['UserTel']     = $_POST['usertel'];
        $user['set_cod']     = $_POST['set_code'];
        return $user;
    }

    public function postAssressDaata($user_id){

        $add_array = array();
        $add_array['province_id'] = $_POST['add_province'];
        $add_array['area_id']     = $_POST['add_city'];
        $add_array['desc']        = $_POST['address_desc'];
        $add_array['related_id']  = $_POST['company_id'];
        $add_array['type']        = 'company';
        $add_array['id']          = $_POST['address_id'];
        $add_array['user_id']     = $user_id;

        return $add_array;
    }
    

    public function postCompanyData($user_id){

        $company = array();
        $company['contact_name'] = $_POST['contact_name'];
        $company['position']     = $_POST['position'];
        $company['contact_tel']  = $_POST['contact_tel']; 
        $company['QQ']           = $_POST['QQ'];
        $company['postcode']     = $_POST['postcode'];
        $company['url']          = $_POST['url'];
        $company['category_id']  = $_POST['category'];
        $company['key']          = $_POST['key'][0];
        $company['desc']         = $_POST['com_desc'];
        $company['address_id']   = $_POST['address_id'];
        $company['id']           = $_POST['company_id'];
        if(!empty($_POST['key'][1])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1];
        }
        if(!empty($_POST['key'][2])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1]. "|" . $_POST['key'][2];
        }
        if(!empty($_POST['key'][3])){
            $company['key'] =  $_POST['key'][0]. "|" . $_POST['key'][1]. "|" . $_POST['key'][2]. "|" .$_POST['key'][3];
        }
            
        return $company;
    
    }

    public function update($user_id){

        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }

        if($_POST['set_code']=='1'){

            if($_POST['usertel']==''){ exit("账号绑定的手机不能空"); }
            if($_POST['usercode']==''){ exit("获取的验证码不能空"); }

            $vcode = $this->user->VerifyCode($_POST['usertel'],$_POST['usercode']);

            if (empty($_POST['usercode']) || $vcode=false){

                exit("验证码有误");
            }
        }

        $user = $this->postUserData($user_id);

        $userid = $this->user->updateUserData($user);

        $address = $this->postAssressDaata($user_id);
        
        $address_id = $this->address->updateData($address);

        $company = $this->postCompanyData($user_id);
        if(empty($_POST['address_id'])){
            $company['address_id']   = $address_id;
        }
        $company_id = $this->company->updateCompany($company);

        if($userid || $address_id || $company_id){

            header('refresh:0.01;url=http://bak.101xd.com/user/vipindex');

            echo "<script>alert('修改成功')</script>";
            
            //$this->redirect("vipindex");
        } else {
            
            echo "修改失败"; exit;
        }
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

    public function SendCode() {
        $mobile = trim($_GET['mobile']);
        $res_ = $this->user->VerifyMobile($mobile);
        if ($res_['result_minute']==1 && $res_['result_hour'] ==1){
            if ($_GET['action'] == 'sendsms' && !empty($_GET['mobile'])){
                for($i=0;$i<6;$i++){
                    $rand = mt_rand(0,9);
                    $rand_str .= $rand;
                };
                $content = "欢迎使用101兄弟手机短信会员注册，您的验证码是".$rand_str."，请在页面填写验证码完成验证。（如非本人操作，可不予理会）";
                //$t_ = $this->user->validateTel($mobile);
                $t_ = true;
                if ($t_){
                    $res_ = $this->SendSMS($_GET['mobile'],$content);
                    if ($res_ ==1 ){ 
                        $data['result'] = 1;
                        $data['msg'] = '手机号码可用';
                        $data['mobile'] = $_GET['mobile'];
                        //存储发送的验证码
                        $this->user->SaveCode($mobile, $rand_str);
                        echo json_encode($data); exit;
                    }else{
                        $data['result'] = 2;
                        $data['msg'] = '发送短信系统故障';
                        echo json_encode($data); exit;
                    }
                }else{
                    $data['result'] = 0;
                    $data['msg'] = '该手机号码已经注册';
                    echo json_encode($data); exit;
                }
            }
        }else{//手机发送验证码超过限制条件1：离上一次不超过一分钟，2：上一个小时内发送数量超过限制数量
            $data['result'] = 3;
            $data['msg'] = '该手机号码的发送超过限制';
            echo json_encode($data);
            exit;
        }
    }

    public function __main__() {

        $user_id =  $this->checkSysCookie();

        $this->index($user_id);

        $this->update($user_id);

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if ($_GET['action'] == 'sendsms' ){
                $this->SendCode();
            };
        }
    }

}

?>


