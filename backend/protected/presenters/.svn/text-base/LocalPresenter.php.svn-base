<?php
class LocalPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__();

        NBee::import('plugin/Qqwry/1.0/QQwry');
        $ip   = '125.65.108.147';
        $this->qqWry    = new QQWry;
        $ifErr=$this->qqWry->QQWry($ip);
        $country = $this->qqWry->Country;
        $local   = $this->qqWry->Local;
        if($country!='局域网' && '本地网络'!=$country) {
            $country = mb_convert_encoding($country, "UTF-8", "GBK");
            $local   = mb_convert_encoding($local, "UTF-8", "GBK");
            $this->__p__['address'] = $country; // . $local;
            $this->__p__['address'] = ''; // . $local;
        }
    }
    public function regPostDta(){
        if(!isset($_POST['title']) || empty($_POST['title'])) { return; }
        if(empty($_POST['market_price']) || empty($_POST['supply_price'])) { exit('产品市场价或供货价必须填写。'); }
        if(empty($_POST['content'])) { exit('项目内容必须填写。'); }
        if(empty($_POST['b_name'])) { exit('商家名字或电话必须填写。'); }
        if(empty($_POST['p_name']) || empty($_POST['p_tel'])) { exit('联系人名字或电话必须填写。'); }
    }
    public function acceptProduct($user_id) {  // 产品
        $product = array();
        //产品
        $product['product_id']   = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $product['category_id']  = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $product['user_id']      = $user_id;
        $product['category']     = $_POST['w_type'];
        $product['title']        = $_POST['title'];
        $product['keywords']     = $_POST['keywords'];
        $product['market_price'] = $_POST['market_price'];
        $product['supply_price'] = $_POST['supply_price'];
        //图片路径
        $product['defaultpic']   = $_POST['defaultpic'];
        $product['product_pic']  = $_POST['product_pic1'];
        $content = str_replace("'",'""',$_POST['content']);
        $product['content']      = $content;
        $product['vedio']        = $_POST['vedio'];
        //其他
        $product['site_number']  = $_POST['site_number']; //合作网站个数
        $product['chain_desc']   = $_POST['chain_desc'];
        $product['payment_type'] = $_POST['way'];
        if($_POST['expired']=='0'){
            $product['expired'] = '0';
        } elseif ($_POST['expired']=='qita' || $_POST['expired']==''){
            $product['expired'] = $_POST['expire_data'];
            $product['expired'] = time() + ($product['expired'] * 86400);
        } else {
            $product['expired'] = intval($_POST['expired']);
            $product['expired'] = time() + ($product['expired'] * 86400);
        }
        return $product;
    }

    public function acceptContact($user_id){   //联系人
        $contact = array();
        $contact['contact_id']   = isset($_POST['contact_id']) ? $_POST['contact_id'] : '';
        $contact['user_id']      = $user_id;
        $contact['p_name']       = $_POST['p_name'];
        $contact['p_tel']        = $_POST['p_tel'];
        $contact['p_mobile']     = $_POST['p_mobile'];
        $contact['p_qq']         = $_POST['p_qq'];
        $contact['p_email']      = $_POST['p_email'];
        $contact['other_name']   = $_POST['other_name']; 
        $contact['other_tel']    = $_POST['other_tel'];
        return $contact;
    }

    public function acceptBusiness($user_id) { // 商家
        $business = array();
        $business['business_id'] = isset($_POST['business_id']) ? $_POST['business_id'] : '';
        $business['user_id']     = $user_id;
        $business['b_name']      = $_POST['b_name'];
        $business['b_year']      = $_POST['b_year'];
        $business['b_seat']      = $_POST['b_seat'];
        $business['area']        = $_POST['area'];
        $business['b_fund']      = $_POST['b_fund'];
        $business['legal_name']  = $_POST['legal_name'];
        $business['legal_tel']   = $_POST['legal_tel'];
        return $business;
    }

    public function acceptAddress($user_id) {  //地址数据
        $address = array();
        $address['address_id']  = isset($_POST['address_id']) ? $_POST['address_id'] : '';
        $address['province_id'] = $_POST['b_province'];
        $address['area_id']     = $_POST['b_area'];
        $address['desc']        = $_POST['b_address'];
        $address['lat']         = $_POST['lat'];
        $address['lng']         = $_POST['lng'];
        $address['type']        = 'business';
        $address['user_id']     = $user_id;
        return $address;
    }
    public function importContact($contact, $method='add', $admin=False) {
        if(empty($contact) || !is_array($contact)) { return; }
        $data = array(
            'id'         => $contact['contact_id'],
            'user_id'    => $contact['user_id'],
            'name'       => $contact['p_name'],
            'tel'        => $contact['p_tel'],
            'qq'         => $contact['p_qq'],
            'mobile'     => $contact['p_mobile'],
            'email'      => $contact['p_email'],
            'other_tel'  => $contact['other_tel'],
            'other_name' => $contact['other_name']
        );
        $contact_id = $data['id'];
        if('update'==$method) {
            $this->contact->updateContactInfo($data, $admin); 
        } else {
            $contact_id = $_POST['import_contact_id'];
            if(!empty($contact_id)){ $getContecat = $this->contact->getDataContactId($contact_id); }
            if($_POST['p_name']==$getContecat['name'] && !empty($contact_id)){
                $data['id'] = $contact_id;
                $this->contact->updateContactInfo($data, $admin);
            } else {
                $contact_id = $this->contact->addContactData($data);
            }
        }
        return $contact_id;
    }

    public function importAddress($address, $method='add', $admin=False) {
        if(empty($address) || !is_array($address)) { return; }
        $data = array(
            'id'          => $address['address_id'],
            'user_id'     => $address['user_id'],
            'province_id' => $address['province_id'],
            'area_id'     => $address['area_id'],
            'desc'        => $address['desc'],
            'lat'         => $address['lat'],
            'lng'         => $address['lng'],
            'zipcode'     => $address['zipcode'],
            'type'        => 'bussiness',
        );
        $address_id = $data['id'];
        if('update'==$method) {
            $this->address->updateData($data, $admin);
        } else {
            $address_id  = $_POST['import_address_id'];
            if(!empty($address_id)){
                $data['id'] = $address_id;
                $this->address->updateData($data, $admin);
            } else {
                $address_id = $this->address->addData($data, $admin);
            }
        }
        return $address_id;
    }

    public function importBusiness($business, $method='add', $admin=False) {
        if(empty($business) || !is_array($business)) { return; }
        $data = array(
            'id'            => $business['business_id'],
            'user_id'       => $business['user_id'],
            'name'          => $business['b_name'],
            'number_years'  => $business['b_year'],
            'seats'         => $business['b_seat'],
            'funds'         => $business['b_fund'],
            'business_area' => $business['area'],
            'address_id'    => $business['address_id'],
            'legal_name'    => $business['legal_name'],
            'legal_tel'     => $business['legal_tel'],
            'address_id'    => $business['address_id']
        );
        $business_id =  $data['id'];
        if('update'==$method) {
            $this->business->updateData($data, $admin);
            $business_id = $business_data['id'];
        } else {
            $business_id = $_POST['import_business_id'];
            if(!empty($business_id)){ $business_name = $this->business->getDataById($business_id);}
            if(!empty($business_id) && $business_name==$_POST['name']){
                $business_data['id'] = $business_id;
                $this->business->updateData($ata, $admin);
            } else {
                $business_id = $this->business->addData($data);   
            }
        }
        return $business_id;
    }
    
    public function importProduct($product, $method='add', $admin=FALSE) {
        if(empty($product) || !is_array($product)) { return; }
        $data = array(
            'id'              => $product['product_id'],
            'category'        => $product['category'],
            'category_id'     => $product['category_id'],
            'user_id'         => $product['user_id'],
            'title'           => $product['title'],
            'keywords'        => $product['keywords'],
            'market_price'    => $product['market_price'],
            'supply_price'    => $product['supply_price'],
            'default_image'   => $product['defaultpic'],
            'image'           => $product['product_pic'],
            'description'     => $product['content'],
            'vedio'           => $product['vedio'],
            'chain_store'     => $product['chain_store'],
            'business_id'     => $product['business_id'],
            'address_id'      => $product['address_id'],
            'contact_id'      => $product['contact_id'],
            'payment_id'      => $product['payment_type'],
            'expire_date'     => $product['expired'],
            'site_number'     => $product['site_number'],
            'chain_desc'      => $product['chain_desc'],
            'contact_id'      => $product['contact_id'],
            'business_id'     => $product['business_id'],
            'address_id'      => $product['address_id']
        );
        $product_id = $data['id'];
        if('update'==$method) {
            $this->product->updateProductData($data, $admin);
            if(!empty($product_id)) {
                $this->writeLog($user_id, $product_id, 'product', '修改本地商品');
            } 
        } else {
            $product_id = $this->product->addProductData($data);
            if(!empty($product_id)) {
                $this->writeLog($user_id, $product_id, 'product', '发布本地商品');
            } 
        }
        return $product_id;
    }

    public function toUpdate($user_id) {
        if(!isset($_GET['action']) || 'toupdate'!=$_GET['action']) { return false; }
        if(!isset($_GET['id']) || empty($_GET['id'])) { return false; }
        if($_GET['type']==1){ 
            $flag = $this->hasPermission($user_id, 2, 4);
            if(!$flag) {
                exit('对不起,您无权操作此页面');
            }
            $this->__p__['user_id'] = 1; 
        } 

        $product_id = intval(trim($_GET['id']));
        $product = $this->product->getUpdateProduct($product_id);
        $business= $this->business->getDataById($product['business_id']);
        $contact = $this->contact->getDataContactId($product['contact_id']);
        $contact['id'] = $product['contact_id'];
        $address = $this->address->getAddressData($product['address_id'], 'bussiness');

        
        $this->__p__['address']  = $address;
        $this->__p__['contact']  = $contact;
        $this->__p__['business'] = $business;
        $this->__p__['product']  = $product;
    }

    public function addData($user_id) {
        if(!isset($_GET['action']) || 'add'!=$_GET['action']) { return; }
        //POST提交数据验证
        $this->regPostDta();
        //联系人入库
        $contact = $this->acceptContact($user_id);
        $contact_id = $this->importContact($contact, 'add');
        //地址入库
        $address = $this->acceptAddress($user_id); 
        $address_id = $this->importAddress($address, 'add');
        //商家数据入库
        $business= $this->acceptBusiness($user_id);
        $business['address_id'] = $address_id;
        $business_id = $this->importBusiness($business, 'add');
        //更新address的关联ID
        $this->address->updateRelatedId($address_id, $business_id);
        //产品入库
        $product = $this->acceptProduct($user_id);
        $product['contact_id']   = $contact_id;
        $product['address_id']   = $address_id;
        $product['business_id']  = $business_id;
        
        $result = $this->importProduct($product);
        if($result) {
            $this->redirect("releasesuccess?id={$result}");
        } 
    }

    public function update($user_id) {
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }
        $this->regPostDta();
        if($_POST['user_id']==1){ $user_id = 1; }
        $admin = FALSE;
        $product = $this->acceptProduct($user_id);
        $contact = $this->acceptContact($user_id);
        $business= $this->acceptBusiness($user_id);
        $address = $this->acceptAddress($user_id);
        
        if(in_array($user_id, array(1,189,175))) { $admin = TRUE; }
        $contact_id = $this->importContact($contact, 'update',$admin);
        
        $address_id = $this->importAddress($address, 'update',$admin);

        $business['address_id'] = $address_id;
        $business_id = $this->importBusiness($business, 'update',$admin);  

        $product['contact_id']   = $contact_id;
        $product['business_id']  = $business_id;
        $product['address_id']   = $address_id;
        $result = $this->importProduct($product, 'update',$admin);
        if($result) {
            $this->redirect("releasesuccess?action=updateresult&id={$result}");
        }
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->getIndexAdderssData();
        $this->getCategoryData(2);
        $this->getAllPaymentData();
        $this->getRelativeCount($user_id);

        $this->__p__['title'] = '发布本地商品';
        $this->__p__['type'] = 'local'; 

        $this->addData($user_id);
        $this->toUpdate($user_id);
        $this->update($user_id);
    }
}
?>
