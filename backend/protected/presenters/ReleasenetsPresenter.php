<?php
class ReleasenetsPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function getAreaData(){
        $area_data = $this->site->getdata(2);
        $this->__p__[''] = $area_data;
    }

    //提交数据验证
    public function validationData(){ 
        if(!isset($_POST) ||  empty($_POST)) { return; }
        if(!isset($_POST['title']) ||  empty($_POST['title'])) { exit("商品标题不能为空"); }
        if(!isset($_POST['content']) ||  empty($_POST['content'])) {  exit("商品内容描不能为空"); }
        if(!isset($_POST['price']) ||  empty($_POST['price'])) { exit('产品市场价必须填写'); }
        if(!isset($_POST['price_s']) ||  empty($_POST['price_s'])) { exit('供货价必须填写'); }
        if(!isset($_POST['price']) ||  empty($_POST['price'])) { exit('对外销售价必须填写'); }
        if(!isset($_POST['p_name']) ||  empty($_POST['p_name'])) { exit("联系人姓名不能为空"); }
        if(!isset($_POST['p_tel']) ||  empty($_POST['p_tel'])) { exit("联系人电话不能为空"); }
        if(!isset($_POST['b_province']) ||  empty($_POST['b_province'])) { exit("联系人所在省份为必选项"); }
        if(!isset($_POST['b_area']) ||  empty($_POST['b_area'])) { exit("联系人区域为必选项"); }
        if(!isset($_POST['b_address']) ||  empty($_POST['b_address'])) { exit("联系人详细地址不能空"); }
        if(!isset($_POST['b_address']) ||  empty($_POST['b_name'])) { exit('商家名字必须填写。');} 
    }
    public function acceptProductData($user_id){
        $product = array();
        //产品数据
        $product['w_type']      = $_POST['w_type'];
        $product['w_name']      = $_POST['w_name'];
        $product['category_id'] = $_POST['category_id'];
        $product['w_url']       = $_POST['url'];
        $product['title']       = $_POST['title'];
        $product['keywords']    = $_POST['keywords'];
        $product['price']       = $_POST['price'];
        $product['price_s']     = $_POST['price_s'];
        $product['foreign_price'] = $_POST['foreign_price'];

        if(empty($_POST['storage'])){
            $product['storage'] = '-1';
        } else {
            $product['storage'] = $_POST['storage'];
        }
        //图片路径
        $product['product_pic'] = $_POST['product_pic1'];
        $product['defaultpic']  = $_POST['defaultpic'];
        $content = str_replace("'",'""',$_POST['content']);
        $product['content']     = $content;
        $product['vedio']       = $_POST['vedio'];

        if($_POST['expired']=='0'){
            $product['expired'] = '0';
        } elseif ($_POST['expired']=='qita' || $_POST['expired']==''){
            $product['expired'] = $_POST['expire_data'];
            $product['expired'] = time() + ($product['expired'] * 86400);
        } else {
            $product['expired'] = intval($_POST['expired']);
            $product['expired'] = time() + ($product['expired'] * 86400);
        }

        $product_data = array(
            'id'                => isset($_POST['product_id']) ? $_POST['product_id'] : '',
            'category'          => $product['w_type'],
            'title'             => $product['title'],
            'keywords'          => $product['keywords'],
            'category_id'       => $product['category_id'],
            'market_price'      => $product['price'],
            'supply_price'      => $product['price_s'],
            'default_image'     => $product['defaultpic'],
            'image'             => $product['product_pic'],
            'foreign_price'     => $product['foreign_price'],
            'description'       => $product['content'],
            'vedio'             => $product['vedio'], 
            'sale_date'         => $product['start_date'],
            'payment_id'        => $_POST['way'],
            'freight'           => $_POST['delivery'],
            'gonghuoren'        => intval($_POST['identity']),
            'free_mail'         => $_POST['mailing'],
            'unit'              => $_POST['unit'],
            'cycle'             => $_POST['cycle'],
            'storage'           => $product['storage'],
            'expire_date'       => $product['expired'],
            'user_id'           => $user_id
        );
        return $product_data;
    }
    public function acceptContactData($user_id){
        $contact = array();
        //联系人数据
        $contact['p_name']      = $_POST['p_name'];
        $contact['p_tel']       = $_POST['p_tel'];
        $contact['p_qq']        = $_POST['p_qq'];
        $contact['p_email']     = $_POST['p_email'];  
        $contact['mobile']      = $_POST['p_mobile']; 
        $contact['other_name']  = $_POST['other_name']; 
        $contact['other_tel']   = $_POST['other_tel']; 
        $contact_data = array(
            'id'        => isset($_POST['contact_id']) ? $_POST['contact_id'] : '',
            'user_id'   => $user_id,
            'name'      => $contact['p_name'],
            'tel'       => $contact['p_tel'],
            'other_name'=> $contact['other_name'],
            'other_tel' => $contact['other_tel'],
            'mobile'    => $_POST['p_mobile'],
            'qq'        => $contact['p_qq'],
            'email'     => $contact['p_email']
        );
        return $contact_data;
    
    }

    public function acceptAddressData($user_id){
        $address = array();
        //地址数据
        $address['b_province']  = $_POST['b_province'];
        $address['b_area']      = $_POST['b_area'];
        $address['b_address']   = $_POST['b_address'];
        $address['lat']  = $_POST['lat'];
        $address['lng']  = $_POST['lng'];

        $address_data = array(
            'id'         => isset($_POST['address_id']) ? $_POST['address_id'] : '',
            'province_id'=> $address['b_province'],
            'area_id'    => $address['b_area'],
            'desc'       => $address['b_address'],
            'lat'        => $address['lat'],
            'lng'        => $address['lng'],
            'type'       => 'bussiness',
            'user_id'    => $user_id
        );

        return $address_data;
    }

    public function acceptBusinessData($user_id){
        $business_data = array(
            'id'        => isset($_POST['business_id']) ? $_POST['business_id'] : '',
            'user_id'   => $user_id,
            'name'      => $_POST['b_name'],
            'legal_name'=> $_POST['legal_name'],
            'legal_tel' => $_POST['legal_tel']
        );
        return $business_data;
    }

    public function acceptFreeCity($user_id,$product_id){
        $free_city = $_POST['mailing_city'];
        if(!empty($free_city)) {
            $len_free  = strlen($free_city);
            $str_free  = substr($free_city,0,$len_free-2);
            $free_data = array(
                'product_id'  => $product_id,
                'city_id'     => $str_free
            );
        }
        return $free_data;
    }
    public function index($user_id){
        if(!isset($_GET['action']) || 'index'!=$_GET['action']) { return; }
        $this->validationData();
        //地址入库
        $address_data = $this->acceptAddressData($user_id);
        $address_id    = $_POST['import_address_id'];
        if(!empty($address_id)){
            $address_data['id'] = $address_id;
            $this->address->updateData($address_data);
        } else {
            $address_id = $this->address->addData($address_data);
        }
        //查询导入联系人的数据是否和库中数据一致
        $contact_data = $this->acceptContactData($user_id);
        $contact_id = $_POST['import_contact_id'];
        if(!empty($contact_id)) { $getContecat = $this->contact->getDataContactId($contact_id); }
        if(!empty($contact_id) && $contact_data['name']==$getContecat['name']){
            $contact_data['id'] = $contact_id;
            $this->contact->updateContactInfo($contact_data);
        } else {
            $contact_id = $this->contact->addContactData($contact_data);//联系人入库
        }
        //商家信息入库
        $business_data = $this->acceptBusinessData($user_id);
        $business_id = $_POST['import_business_id'];
        if(!empty($business_id)){ $business_name = $this->business->getDataById($business_id); }
        if(!empty($business_id) && $business_name==$_POST['name']){
            $business_data['id'] = $business_id;
            $this->business->updateData($business_data);
        } else {
            $business_id = $this->business->addData($business_data);   
        }
        //产品入库
        $product_data = $this->acceptProductData($user_id);
        $product_data['contact_id'] = $contact_id;
        $product_data['address_id'] = $address_id;
        $product_data['business_id'] = $business_id;
        $product_id = $this->product->addProductData($product_data);

         //邮寄城市入库
        $free_data  =  $this->acceptFreeCity($user_id,$product_id);
        $free_id    = $this->site->addFreeData($free_data);

        $this->address->updateRelatedId($address_id, $product_id);
        
        //记录日志
        if(!empty($product_id)) {
            $this->writeLog($user_id, $product_id, 'product', '发布精品网货');
        }
        if(!empty($product_id)){ $this->redirect("releasesuccess?id={$product_id}"); exit; }
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
        if(!empty($product['contact_id'])) {
            $contact = $this->contact->getDataContactId($product['contact_id']);
            $contact['id'] = $product['contact_id'];
            $this->__p__['contact']  = $contact;
        }
        if(!empty($product['address_id'])){
            $address = $this->address->getAddressData($product['address_id'], 'bussiness');
            $this->__p__['address']  = $address;
        }
        if(!empty($product['business_id'])){
            $business= $this->business->getDataById($product['business_id']);
            $this->__p__['business'] = $business;
        }
        if(!empty($address)) {
            $city_province_list = $this->province->getCityList($address['province_id']);
            $this->__p__['city_list'] = $city_province_list;
        }

        $free_city = $this->site->getFreeCityData($product_id);
        
        $this->__p__['city'] = $free_city;
        $this->__p__['product']  = $product;
    }

    public function updateProcess($user_id){
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return false; }
        if(!isset($_GET['id']) || empty($_GET['id'])) { return false; }
            
        $this->validationData();
        if(!empty($_POST['user_type']) && in_array($_POST['user_type'], array(1,189,175))) { $admin = TRUE; }
        //update地址
        $address_data = $this->acceptAddressData($user_id);
        $address_data['id'] = intval($_POST['address_id']);
        $address_id = $this->address->updateData($address_data, $admin);

        //update联系人
        $contact_data = $this->acceptContactData($user_id);
        $contact_data['id'] = intval($_POST['contact_id']);
        $this->contact->updateContactInfo($contact_data,$admin);
        
        //update商家信息
        $business_data = $this->acceptBusinessData($user_id);
        $business_data['address_id'] = $address_id;
        $this->business->updateData($business_data, $admin);

        //update产品
        $product_data = $this->acceptProductData($user_id);
        $product_data['id']           = intval($_POST['product_id']); 
        $product_data['contact_id']   = intval($_POST['contact_id']);
        $product_data['business_id']   = intval($_POST['business_id']);
        $product_data['address_id']   = intval($address_data['id']);

        $result = $this->product->updateProductData($product_data, $admin);

        //update邮寄城市
        $free_data  =  $this->acceptFreeCity($user_id,$result);
        $free_id = $this->site->updateFreeData($free_data);
        
        if($result) { $this->redirect("releasesuccess?action=updateresult&id={$result}"); }
    
    }
    
    public function __main__() {
        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->__p__['type'] = 'net';
        $this->__p__['title'] = '发布精品网货';

        $this->getIndexAdderssData();
        $this->getCategoryData(3);
        $this->getAllPaymentData();
        $this->index($user_id);
        $this->getRelativeCount($user_id);
        $this->getAreaData();
        $this->toUpdate($user_id);
        $this->updateProcess($user_id);
    }

}

?>

