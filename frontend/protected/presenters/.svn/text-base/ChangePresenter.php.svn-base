<?php
class ChangePresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();
    }

    private function changeRegester() {
        $user_list = $this->db->table('user')->getList();
        foreach($user_list as $v) {
            if($v['UserType']) {
                $group = $this->db->table('`bbs_group_user` gu, `bbs_group` g')
                        ->select('g.*')
                        ->where('gu.group_id = g.id')
                        ->where("gu.user_id='{$v['UserID']}'")
                        ->getFirst();
                if($group) {
                    $data = array(
                        'user_id' => $v['UserID'],
                        'name'    => $group['name'],
                        'url'     => $group['url']
                        );

                    $this->db->table('`company`')->insert($data);
                    $com_id = $this->db->last_insert_id();
                    $this->db->exec("update `user` set CompanyID=$com_id where UserID='{$v['UserID']}'");
                }

            } else {
                $business = $this->db->table('`bbs_business`')
                            ->select('id, category_id, name')
                            ->where("(category_id is not null) and user_id='{$row['UserID']}'")
                            ->getFirst();
                if($business) {
                $data = array(
                        'user_id' => $v['UserID'],
                        'name'    => $business['name'],
                        'category_id'=> $business['category_id']
                        );

                    $this->db->table('`company`')->insert($data);
                    $com_id = $this->db->last_insert_id();
                    $this->db->exec("update `user` set CompanyID=$com_id where UserID='{$v['UserID']}'");
                }

            }
        }

        echo 'game over!';
    }

    public function countProduct() {
        $user = $this->db->table('`user`')->getList();
        foreach($user as $v) {
            $count_Product = $this->db->table('product')->where("user_id='{$v['UserID']}'")->getCount();
            if(!$count_Product) { $count_Product=0 ;} 

            $count_Message = $this->db->table('`message`')->where("receiver_id='{$v['UserID']}'")->getCount();
            if(!$count_Message) { $count_Message=0 ;} 

            if(!$count_Message && !$count_Product) {
                continue;
            }

            $this->db->exec("update `user` set CountProducts={$count_Product},CountMessages={$count_Message} where UserID='{$v['UserID']}'");
        }
    
        echo 'over';
    }

    public function insertCompanyVip() {
    
        $user = array(
            'UserType' =>1,
            'Name'     => 'xing800com',
            'ContactName' => '封胜利',
            'UserTel'  => '18610119898',
            'Password' => '101xd123456',
            'Email'    => 'shengli.feng@pnova.com',
            'QQ'       => ''
            );
    
        $user['Password'] = $this->passWordHash->HashPassword($user['Password']);

        $this->db->table('`user`')->insert($user);
        $user_id = $this->db->last_insert_id();

        $address = array(
            'province_id' => 11,
            'area_id'     => 8201,
            'desc'        => '金台里甲9号铜牛大厦二层',
            'type'        => 'bussiness'
        );
        
        $this->db->table('`address`')->insert($address);
        $address_id = $this->db->last_insert_id();

        $company = array(
            'user_id'   => $user_id,
            'name'      => '紫星信息技术有限公司',
            'site_name' => '星800',
            'url'       => 'http://www.xing800.com/',
            'desc'      => '星800是一家审核严格，商品齐全的团购网站，承诺“为消费者提供价格极具震撼力同时品质优良的商品”,是目前中国团购市场中最具竞争力的一线网站之一。',
            'ip'        => '87600',
            'validate'  => 1,
            'address_id'=> $address_id,
            'website_id'=> 1685 
        );
        
        $this->db->table('`company`')->insert($company);
        $com_id = $this->db->last_insert_id(); 
        
        $this->db->exec("update `address` set related_id={$com_id} where id='{$address_id}'");
        $this->db->exec("update `user` set CompanyID={$com_id} where UserID='{$user_id}'");

        $company_vip = array(
            'company_id' => $com_id,
            'delivery'     => '0', //发货
            'intelligence' => '1', //资质
            'money_local'  => '532', //本地打款
            'money_net'    => '快递发出3个工作日打款80%，一个月后付尾款20%', //打款精品
            'money_time'   => '', //最长打款时间
            'examine_local'=> '7天', //审批时间本地
            'examine_net'  => '7天', //审批时间精品
            'additional'   => '', //附加值
            'remark'       => '', //备注
            'auth_local'   => '营业执照|税务登记证|组织机构代码证|银行开户许可证|法人身份证复印件（正反两面）|商家授权书（可转授权）', //认证本地
            'auth_net'     => '税务登记证|组织机构代码证|商家授权书', //认证精品
            'contact_name' => '封胜利', //联系人老大 
            'contact_position' => '高级项目经理', //职位
            'contact_tel'  => '010-65202293-821', //座机
            'contact_mobile' => '18610119898', //手机
            'contact_fax'    => '010-65202568', //传真
            'contact_email'  => 'shengli.feng@pnova.com' //邮箱
        );
        
        $this->db->table('`company_vip`')->insert($company_vip);

        echo 'over';
    }
    
    public function __main__() {
    
        //$this->countProduct();
        //$this->changeRegester();
        //$this->insertCompanyVip();
    }
}
