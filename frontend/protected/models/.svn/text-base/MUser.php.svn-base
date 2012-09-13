<?php
class MUser extends CModel
{ 
    //查看id和name的一致性
    public function checkUserByIdAndName($id, $name) {
        $tmp = $this->db->table('`user`')
            ->where("UserID='{$id}'")
            ->where("Name = '{$name}'")
            ->getFirst();
        if(empty($tmp)) { return false; }
            return true;
    }
    //验证电话
    public function validateTel($tel) {
        $tmp = $this->db->table('`user`')
            ->select('UserID, Name, UserTel')
            ->where("UserTel='{$tel}'")
            ->getFirst();
        if(!empty($tmp)) { return false; }

        return true;
    }

    //根据id获取用户数据
    public function getUserDataById($id) {
        $tmp = $this->db->table('`user`')
            ->select('UserID, Name, Email, UserType,CompanyID,Complete')
            ->where("UserID='{$id}'")
            ->getFirst();
        return $tmp;
    }

    //获取登陆用户的数据
    public function loginByName($name){
        $user = $this->db->table('`user`')
            ->select('UserID,Password,Name,UserType,Photo, UserTel, DateLastActive')
            ->where("Name = '{$name}'")
            ->getFirst();
        return $user;
    }

    //更新登陆时间和访问次数
    public function updateLastActiveData($user_id) {
        $time = date('Y-n-j H:i:s');
        $this->db->exec("update `user` set CountVisits=CountVisits+1,DateLastActive='{$time}' where UserID='{$user_id}'");
    }

    //获取用户的关联数据
    public function getUserRelateData($user_id) {
        $data = $this->db->table('`user`')
            ->select('*')
            ->where("UserID={$user_id}")
            ->getFirst();
        //检查关联的company表是否存在
        if($data['CompanyID']) {
            $company = $this->db->table('`company`')->select('*')->where("id={$data['CompanyID']}")->getFirst();
            $data['company'] = $company;
            $data['ip']=$company['ip'];
            //检查类别category关联表是否存在
            if($company['category_id']) {
                $category = $this->db->table('`category`')->select('*')->where("id={$company['category_id']}")->getFirst();
                $data['category'] = $category;
            }
            if ($company['address_id']) {
                $address = $this->db->table('`address`')->select('*')->where("id={$company['address_id']}")->getFirst();
                $province = $this->db->table('`province`')->select('*')->where("id={$address['province_id']}")->getFirst();
                $province = $province['name'];
                $city = $this->db->table('`city`')->select('*')->where("id={$address['area_id']}")->getFirst();
                $city = $city['name'];
                $address['province'] = $province;
                $address['city'] = $city;
                $data['address'] = $address;
            }
        }
        return $data;
    }
    //检查用户名是否存在
    public function findUserByName($name) {
        $user = $this->db->table('`user`')
            ->select('UserID, Name')
            ->where("Name = '{$name}'")
            ->getFirst();
        return $user;
    }
    //检查邮箱是否存在
    public function findUserByEmail($email) {
        $user = $this->db->table('`user`')
            ->select('UserID, Name')
            ->where("Email = '{$email}'")
            ->getFirst();
        return $user;
    }
    //验证验证码是否正确
    public function VerifyCode($mobile,$code){
        $r_ = $this->db->table('`auth_code`')
            ->select('*')
            ->where("code = {$code}")
            ->where("tel_ip = {$mobile}")
            ->order('insert_date','desc')
            ->getFirst();
        if (!empty($r_['code'])){return true;}
            return false;
    
    }
    //验证手机发送短信是否超过配额
    public function  VerifyMobile($mobile){
        $code = $this->db->table('`auth_code`')
            ->select('*')
            ->where("tel_ip = {$mobile}")
            ->order('insert_date', 'desc')
            ->getFirst();
        $codes = $this->db->table('`auth_code`')
            ->select('*')
            ->where("tel_ip = {$mobile}")
            ->order('insert_date', 'desc')
            ->getList();
        
        $last = intval($code['insert_date']);
        //echo '最后一条的时间';
        //echo $last;
        $now = time();
        //echo '当前时间';
        //echo $now;

        $interval = intval((intval($now)-$last));
        //echo $interval;
        //$res = new array();
        //验证是否在发送时间是否超过一分钟
        if ($interval>60){
            $res['result_minute'] = 1;
            $res['msg_minute'] = '离上一条短息发送时间超过60秒';
        }
        else{
            $res['result_minute'] = 0;
            $res['msg_minute'] = '离上次发送时间不超过一分钟';
        };
        //验证是否在小时内超过发送的配额
        $item = $codes[5];
        if (intval(intval($now)-3600) > intval($item['insert_date'])){
            $res['result_hour'] = 1;
            $res['msg_hour'] = '上一个小时内的发送数量小于限制数量';
        }
        else{

            $res['result_hour'] = 0;
            $res['msg_hour'] = '上一个小时的发送数量超过限制数量';
            }

        return $res;
    }

    //找回密码的手机号合法性
    public function findUserTel($name) {
        $tmp = $this->db->table('`user`')
            ->select('UserID, UserTel')
            ->where("Name='{$name}'")
            ->getFirst();
        return $tmp;
    }
    
    //找回密码,添加验证码
    public function addCodeUserID($id,$code){
        $now = time();
        $this->db->exec("update  `user` set RegistrationCode='{$code}' where UserID='{$now}'");
    }

    //找回密码,修改密码
    public function updatePassWord($pass,$id){
        return $this->db->exec("update `user` set Password='{$pass}' where UserID='{$id}'");    
    } 

    //找回密码,提取验证码
    public function findUserByCode($id){
        $tmp = $this->db->table('`user`')
            ->select('RegistrationCode')
            ->where("UserID='{$id}'")
            ->getFirst();
        return $tmp['RegistrationCode'];

    } 
    //存储验证码
    public function SaveCode($mobile, $code){
        $now = time();
        $now = intval($now);
        $this->db->exec("INSERT INTO `auth_code` (ctype, tel_ip, code, insert_date) VALUES (3, {$mobile}, {$code}, {$now})");
    }
    // 邮件找回密码
    public function forgetPwdEmail($user_id, $code) {
        $time = time();
        $this->db->exec("update `user` set EmailValidateCode='$code',EmailValidateTime='{$time}' where UserID='{$user_id}'");
    }

    //邮箱找回密码提取的数据
    public function getPwdEmail($user_id) {

        return $this->db->table('`user`')
            ->select('UserID, Name,Email,EmailValidateCode,EmailValidateTime')
            ->where("UserID='{$user_id}'")
            ->getFirst();
    }

    //注册新的用户
    public function regisNewUser($data){
        $data['DateInserted']    = date('Y-m-d H:i:s',time());
        $user    = $this->db->table('`user`')->insert($data);
        $user_id = $this->db->last_insert_id();
        return $user_id;
    }

    //最近加入的渠道商
    public function getNewsUserList(){
        $data = $this->db->table('`user`')
            ->select('UserID,Name')
            ->where('UserType=1')
            ->where('Deleted<>1')
            ->order('UserID','desc')
            ->getNum(5,0);
        return $data;
    }

    //获取关注商家的渠道商名字
    public function getAttentionBusinessName($id){

        $data = $this->db->table('`user`')
            ->select('UserID,Name')
            ->where("UserID='{$id}'")
            ->getFirst();
        return $data;
    }

    //获取被关注次数
    public function getCountAttentioned($user_id) {
        $count = $this->db->table('`attention_publishers`')
            ->where("publisher_id='{$user_id}'")
            ->where("status='1'")
            ->getCount();

        return $count;
    }

    //查询商家经营类别
    public function getStyleList(){
        $data = $this->db->table('`category`')
            ->select('id,name,level')
            ->where('id>4')
            ->getList();
        return $data;
    }

    //添加发送的短消息
    public function addUserSms($data) {
        $day = date('Y-m-d H:i:s', time());
        $data['insert_date'] = isset($data['insert_date']) ? $data['insert_date'] : $day;
        if(empty($data['insert_date'])) {
            $data['insert_date'] = $day;
        }
        $this->db->table('`sms`')->insert($data);
        return $this->db->last_insert_id();
    }

    public function validateUserByEmail($email,$id) {
        $tmp = $this->db->table('`user`')
            ->select('UserID')
            ->where("Email='{$email}' and UserID='{$id}'")
            ->getFirst();
        if(empty($tmp)) { return 0; }
            return $tmp['UserID'];
    }

    //update user表的企业ID
    public function updateUserCompanyID($company_id,$user_id){
        $this->db->exec("update `user` set CompanyID='{$company_id}' where UserID='{$user_id}'");
    }

    public function getUserRoleId($user_id) {

        $tmp = $this->db->table('`admin_user_role`')
            ->select('role_id')
            ->where("user_id='{$user_id}'")
            ->getFirst();

        if(empty($tmp)) { return 0;}

            return $tmp['role_id'];
    }

    //统计渠道商用户数
    function getChannelCount(){

        $data = $this->db->table('`user`')
            ->where("UserType='1'")
            ->getCount();
        return $data;
    }

    function addUserCompleteAuth($user_id){

        $this->db->exec("update `user` set  Complete='1' where UserID='{$user_id}'");
    }

    function getUserCompleteAuth($user_id) {

        return $this->db->exec("select Complete from `user` where UserID='{$user_id}'");
    }
    /*
    *筛选复合条件的渠道商[有金牌渠道商 和 一般渠道商]
    *在vip_company表里面传入vipproduct的id
    */
    function filterPushCompany($pid){
        $vp = $this->db->table('`vipproduct`')
                ->select('*')
                ->where("id={$pid}")
                ->getFirst();
        if ($vp){
            $zizhi=explode('|',$vp['check_qualification']);
            /*  这样写的确有点不好用，不过之前的db设计也太栏啦哈，
             *  我是迫不得已的...
             */
            $zizhimap=array('license'=>'营业执照',
                            'tax'=>'税务登记证',
                            'certificate'=>'身份证',
                            'org'=>'组织机构代码证',
                            'bui'=>'商家授权书',
                            'account'=>'银行开户',
                            'qc'=>'质量检测',
                            'logo'=>'商标',
                        );
            $wh = array();
            foreach($zizhi as $z){
                array_push($wh," auth_net like '%{$zizhimap[$z]}%' ");
            };
            $wst = join(' or ',$wh);
            $cids = $this->db->table('`company_vip`')
                        ->select('*')
                        ->where($wst)
                        ->getList();
            $uids = array();
            foreach($cids as $c){
                $userid = $this->db->table('`company`')
                        ->select('user_id')
                        ->where("id='{$c['company_id']}'")
                        ->getFirst();
                $user = $this->db->table('`user`')
                        ->select('`UserID`,`UserType`,`Name`,`CompanyName`,`vip`')
                        ->where("UserID='{$userid['user_id']}'")
                        ->getFirst();
                array_push($uids,$user);
            }
            return $uids; 
        }
    }

    /**
     * 统计vip用户的数量
     */
    function getVipChannelCount(){

        $count = $this->db->table('`user`')
            ->where("UserType='1'")
            ->where("vip!='0'")
            ->getCount();
        return $count;
    
    }

     //开通专业的普通vip用户
    function getVipUserList(){
    
        $data = $this->db->table('`user`')
            ->select("UserID, Name")
            ->where("UserType='1'")
            ->where("vip='2'")
            ->getList();
        return $data;

    }

    //其他
    function getQitaUserList(){

        $data = $this->db->table('`user`')
            ->select("UserID, Name")
            ->where("UserType='1'")
            ->where("vip='0'")
            ->getList();
        return $data;
    }

    //search
    function searchUserName($key){

        $data = $this->db->table('`user`')
            ->select("UserID, Name")
            ->where("UserType='1'")
            ->where("Name like '%{$key}%'")
            ->getList();
        return $data;
    }
}
