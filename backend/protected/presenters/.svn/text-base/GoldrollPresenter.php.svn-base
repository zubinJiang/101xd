<?php
class GoldrollPresenter extends InitPresenter
{
    public function __init__() {

        parent::__init__(); 
    }

    public function indexAdderssData() {

        $province_data = $this->site->getProvinceData(); //获取所有省份数据
        $this->__p__['province'] = $province_data;
    }

    public function index($user_id){

        //提交数据验证
        if(!isset($_GET['action']) || 'index'!=$_GET['action']) { exit();}  
        if(!isset($_POST) ||  empty($_POST)) { return; }
        if(!isset($_POST['w_name']) ||  empty($_POST['w_name'])) { exit("网站名称不能空"); }
        if(!isset($_POST['w_url']) ||  empty($_POST['w_url'])) { exit("网站网址不能空"); } 
        if(!isset($_POST['price_x']) ||  empty($_POST['price_x'])) { exit('产品市场价必须填写'); }
        if(!isset($_POST['price_y']) ||  empty($_POST['price_y'])) { exit('供货价必须填写'); }
        if(!isset($_POST['p_name']) ||  empty($_POST['p_name'])) { exit("联系人姓名不能空"); }
        if(!isset($_POST['p_tel']) ||  empty($_POST['p_tel'])) { exit("联系人电话不能空"); }
        if(!isset($_POST['b_province']) ||  empty($_POST['b_province'])) { exit("商家所省份必选项"); }
        if(!isset($_POST['b_area']) ||  empty($_POST['b_area'])) { exit("商家所在城市必选项"); }
        if(!isset($_POST['b_address']) ||  empty($_POST['b_address'])) { exit("商家详细地址不能为空"); }

        $product = array();
        $contact = array();
        $address = array();

        //图片数据 
        $product['content']      = $_POST['content'];

        //产品数据
        $product['w_type']      = $_POST['w_type'];
        $product['w_name']      = $_POST['w_name'];
        $product['w_url']       = $_POST['w_url'];
        $product['w_amount']    = $_POST['w_amount'];
        $product['w_title']     = $_POST['w_title'];
        $product['w_address']   = $_POST['w_address'];
        $product['price_x']     = $_POST['price_x'];
        $product['price_y']     = $_POST['price_y'];

        //联系人数居
        $contact['p_name']  = $_POST['p_name'];
        $contact['p_tel']   = $_POST['p_tel'];
        $contact['p_qq']    = $_POST['p_qq'];
        $contact['p_email'] = $_POST['p_email'];
        $contact['other_name']  = $_POST['other_name']; 
        $contact['other_tel']   = $_POST['other_tel'];

        //其他数据
        $product['onlineper']   = $_POST['onlineper'];
        $product['term']        = strtotime($_POST['term']);
        $product['way']         = $_POST['way'];
        $product['expired']     = $_POST['expired'];

        //地址数据
        $address['b_province']  = $_POST['b_province'];
        $address['b_area']  = $_POST['b_area'];
        $address['b_address']  = $_POST['b_address'];
        $address['lat']  = $_POST['lat'];
        $address['lng']  = $_POST['lng'];

        //联系人入库
        $contact_data = array(
            'user_id'=>$user_id,
            'name'=>$contact['p_name'],
            'tel'=>$contact['p_tel'],
            'qq'=>$contact['p_qq'],
            'other_name'=>$contact['other_name'],
            'other_tel'=>$contact['other_tel'],
            'email'=>$contact['p_email']
        );
        $contact_id = $this->contact->addContactData($contact_data);

        //地址入库
        $address_data = array(
            'province_id'=>$address['b_province'],
            'area_id'=>$address['b_area'],
            'desc'=>$address['b_address'],
            'lat'=>$address['lat'],
            'lng'=>$address['lng'],
            'type'=>'business',
            'related_id'=> $product_id,
            'user_id'=>$user_id
        );
        $address_id = $this->address->addData($address_data);

        //产品入库
        $product_data = array(
            'category'     => $product['w_type'],
            'area_id'         => $address['b_area'],
            'title'           => $product['w_title'],
            'market_price'    => $product['price_x'],
            'supply_price'    => $product['price_y'],
            'amount'          => $product['w_amount'],
            'site_name'       => $product['w_name'],
            'site_url'        => $product['w_url'],
            'description'     => $product['content'],
            'tollcap'         => $product['onlineper'],
            'deadline'        => $product['term'],
            'payment_id'      => $_POST['way'],
            'expire_date'     => $product['expired'],
            'contact_id'      => $contact_id,
            'user_id'         => $user_id,
            'address_id'      => $address_id
        );
        $product_id = $this->product->addProductData($product_data);

        //记录日志
        if(!empty($product_id)) {
            $log_arr = array(
                    'user_id'=>$user_id,
                    'table_name'=>'product',
                    'table_id'=>$product_id,
                    'record'=>'发布网上代金券'
                );
           $this->log->addLogData($log_arr);
        }
        //更新地址中关联的id
        $this->address->updateRelatedId($address_id, $product_id);

        if(!empty($product_id) && !empty($user_id) && !empty($address_id)) {
            $this->redirect("releasesuccess?id={$product_id}");
            exit;
        } else {
            echo "添加失败";
            exit;
        }
    }

    public function toupdate() {
    
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
        $contact = $this->contact->getDataContactId($product['contact_id']);
        $contact['id'] = $product['contact_id'];
        $address = $this->address->getAddressData($product['address_id'], 'bussiness');

        $this->__p__['address']  = $address;
        $this->__p__['contact']  = $contact;
        $this->__p__['product']  = $product;
    }
   
    public function update() {
        if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return false; }
        if(!isset($_GET['id']) || empty($_GET['id'])) { return false; }
    
        if(!isset($_POST['w_name']) ||  empty($_POST['w_name'])) { exit('网站名称不能为空！'); }
        if(!isset($_POST['w_url']) ||  empty($_POST['w_url'])) { return; } 
        if(!isset($_POST['price_x']) ||  empty($_POST['price_x']) || !is_numeric($_POST['price_x'])) { exit('产品市场价必须是整型'); }
        if(!isset($_POST['price_y']) ||  empty($_POST['price_y']) || !is_numeric($_POST['price_y'])) { exit('供货价必须是整型'); }
        if(!isset($_POST['p_name']) ||  empty($_POST['p_name'])) { 
            $this->redirect('goldroll?action=toupdate&id='.$_GET['id']);
            return;
        }
        if(!isset($_POST['p_tel']) ||  empty($_POST['p_tel'])) { 
            $this->redirect('goldroll?action=toupdate&id='.$_GET['id']);
            return;
        }
        if(!isset($_POST['b_province']) ||  empty($_POST['b_province'])) { 
            $this->redirect('goldroll?action=toupdate&id='.$_GET['id']);
            return; 
        }
        if(!isset($_POST['b_area']) ||  empty($_POST['b_area'])) { return; }
        if(!isset($_POST['b_address']) ||  empty($_POST['b_address'])) { return; }

        $product = array();
        $contact = array();
        $address = array();

        $product['id']          = $_GET['id'];
        //图片数据 
        $product['content']     = $_POST['content'];

        //产品数据
        $product['w_type']      = $_POST['w_type'];
        $product['w_name']      = $_POST['w_name'];
        $product['w_url']       = $_POST['w_url'];
        $product['w_amount']    = $_POST['w_amount'];
        $product['w_title']     = $_POST['w_title'];
        $product['w_address']   = $_POST['w_address'];
        $product['price_x']     = $_POST['price_x'];
        $product['price_y']     = $_POST['price_y'];

        //联系人数居
        $contact['id']      = $_POST['contact_id'];
        $contact['p_name']  = $_POST['p_name'];
        $contact['p_tel']   = $_POST['p_tel'];
        $contact['p_qq']    = $_POST['p_qq'];
        $contact['p_email'] = $_POST['p_email'];
        $contact['other_name']  = $_POST['other_name']; 
        $contact['other_tel']   = $_POST['other_tel'];


        //其他数据
        $product['onlineper']   = $_POST['onlineper'];
        $product['term']        = strtotime($_POST['term']);
        $product['way']         = $_POST['way'];
        $product['expired']     = $_POST['expired'];

        //地址数据
        $address['id']          = $_POST['address_id'];
        $address['b_province']  = $_POST['b_province'];
        $address['b_area']  = $_POST['b_area'];
        $address['b_address']  = $_POST['b_address'];
        $address['lat']  = $_POST['lat'];
        $address['lng']  = $_POST['lng'];

        //联系人入库
        $contact_data = array(
            'id'  => $contact['id'],
            'name'=>$contact['p_name'],
            'tel'=>$contact['p_tel'],
            'qq'=>$contact['p_qq'],
            'email'=>$contact['p_email']
        );

        $this->contact->updateContactInfo($contact_data, $contact['id']);

        //地址入库
        $address_data = array(
            'province_id'=>$address['b_province'],
            'area_id'=>$address['b_area'],
            'desc'=>$address['b_address'],
            'lat'=>$address['lat'],
            'lng'=>$address['lng'],
            'type'=>'business',
            'related_id'=> $product['id'],
            'user_id'=>$user_id
        );

        $this->address->updateData($data);

        //产品入库
        $product_data = array(
            'id'              => $product['id'],
            'category'        => $product['w_type'],
            'area_id'         => $address['b_area'],
            'title'           => $product['w_title'],
            'market_price'    => $product['price_x'],
            'supply_price'    => $product['price_y'],
            'amount'          => $product['w_amount'],
            'site_name'       => $product['w_name'],
            'site_url'        => $product['w_url'],
            'description'     => $product['content'],
            'tollcap'         => $product['onlineper'],
            'deadline'        => $product['term'],
            'payment_id'      => $_POST['way'],
            'expire_date'     => $product['expired'],
        );

        $result = $this->product->updateProductData($product_data);

        //记录日志
        if(!empty($result)) {
            $log_arr = array(
                    'user_id'=>$user_id,
                    'table_name'=>'product',
                    'table_id'=>$product['id'],
                    'record'=>'修改网上代金券'
                );
           $this->log->addLogData($log_arr);
        
            $this->redirect("releasesuccess?id={$product_id}");
            exit;
        } else {
            echo "修改失败";
            exit;
        }
    }

    public function __main__() {

        $user_id = $this->checkLoginStatus();

         //权限判断
        $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);

        $this->__p__['type'] = 'goldroll';
        $this->__p__['title'] = '发布网站代金券';
        $this->index($user_id);

        $this->indexAdderssData();
        $this->getAllPaymentData();

        $this->toupdate();
        $this->update();
    }

}

?>

