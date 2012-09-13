<?php
class VipsupplysPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function uplodeImages($images){

        if ($_FILES["{$images}"]['error'] > 0) {
		switch ($_FILES["{$images}"]['error'][$i]){
			case 1:
				echo "�ļ���С�д�";
				break;
			case 2:
				echo "��ʾ�����ļ���С������HTML����MAX��FILE��SIZEԪ����ָ�������ֵ";
				break;
			case 3:
				echo "��ʾ�ļ�ֻ����������";
				break;
			case 4:
				echo "��ʾû�������κ��ļ�";
				break;
			default :
				echo "�����������д�";
				break;
		}
	   }else{
	       	$typeArr = explode(".", $_FILES["{$images}"]['name']);
			$finalType = $typeArr[count($typeArr)-1];
				if ($finalType == 'jpg' || $finalType=='png'|| $finalType=='gif' || $finalType=='bmp') {
					$fileSize = 500*1024;
					if ($_FILES["{$images}"]['size'] <= $fileSize) {
						$name = date("Ymd-His").mt_rand(1000,9999);
						$name = $name.".".$finalType;
                        $dir  = $this->config['fileupload']['rootpath'] . "zizhi/";
                        $dirName = $dir.$name;
							if(move_uploaded_file($_FILES["{$images}"]['tmp_name'],$dirName)){
                                //echo "�ϴ��ļ��ɹ���<br>";
                                return "zizhi/".$name;
							}else{
								echo "�ϴ��ļ�ʧ�ܣ�<br>";exit;
							}
					}else{
						echo "��С����<br>";exit;
						
					}
				}else{
					echo "���ʹ���<br>";exit;	
					
				} 	   
        }
    }

    public function regPostDta(){

        if(!isset($_POST['title']) || empty($_POST['title'])) { exit('��Ʒ���ⲻ�ܿ�'); }
        if(empty($_POST['max_buy'])) { exit('����Ź�����������д'); }
        if(empty($_POST['max_pre'])) { exit('ÿ���û��ɹ�������������д'); }
        if(empty($_POST['market_price'])) { exit('��Ʒ�г��۱�����д'); }
        if(empty($_POST['supply_price'])) { exit('��Ʒ�ۿۼ۱�����д'); }
        if(empty($_POST['desc'])) { exit('��ƷժҪ������д'); }
        if(empty($_POST['explain'])) { exit('��Ʒ˵��������д'); }
        if(empty($_POST['product_pic1'])) { exit('��ƷͼƬ������д'); }
        if(empty($_FILES['image_license']) && $_POST['qualification_id']==''){ exit("�ϴ�Ӫҵִ�ղ��ܿ�"); }
    }
 
    public function postProductData(){

        $product = array();
        $product['title']            = $_POST['title'];
        $product['max_buy']          = $_POST['max_buy'];
        $product['max_pre']          = $_POST['max_pre'];
        $product['market_price']     = $_POST['market_price'];
        $product['supply_price']     = $_POST['supply_price'];
        $product['desc']             = trim($_POST['desc']);
        $product['explain']          = trim($_POST['explain']);
        $product['images']           = $_POST['product_pic1'];

        return $product;
    }
    public function postQualificationData(){
    
        $qualification = array();
        
        $qualification['image_license']    = $_POST['image_license'];//Ӫҵִ��
        $qualification['image_certificate']  = $_POST['image_certificate'];//�������֤
        $qualification['image_tax']        = $_POST['image_tax'];//˰��Ǽ�֤
        $qualification['image_account']    = $_POST['image_account'];//�������֤
        $qualification['image_org']        = $_POST['image_org'];//��֯�ṹ
        $qualification['image_qc']         = $_POST['image_license'];//�ʼ�
        $qualification['image_bui']        = $_POST['image_bui'];//��Ȩ��
        $qualification['image_logo']       = $_POST['image_logo'];//�̱�

        if(!empty($_FILES['image_license']['name'])){
            $qualification['image_license']    = $this->uplodeImages("image_license");
        }

        if(!empty($_FILES['image_certificate']['name'])){
            $qualification['image_certificate']    = $this->uplodeImages("image_certificate");
        }

        if(!empty($_FILES['image_tax']['name'])){
            $qualification['image_tax']        = $this->uplodeImages("image_tax");
        }

        if(!empty($_FILES['image_account']['name'])){
            $qualification['image_account']    = $this->uplodeImages("image_account");
        }

        if(!empty($_FILES['image_org']['name'])){
            $qualification['image_org']    = $this->uplodeImages("image_org");
        }

        if(!empty($_FILES['image_qc']['name'])){
            $qualification['image_qc']    = $this->uplodeImages("image_qc");
        }

        if(!empty($_FILES['image_bui']['name'])){
            $qualification['image_bui']    = $this->uplodeImages("image_bui");
        }

        if(!empty($_FILES['image_org']['name'])){
            $qualification['image_org']    = $this->uplodeImages("image_org");
        }

        if(!empty($_FILES['image_logo']['name'])){
            $qualification['image_logo']    = $this->uplodeImages("image_logo");
        }

        return $qualification;
    }
    public function addData($user_id){
 
        if('add'!= $_GET['action'] || empty($_GET['action'])) { return; }

        $this->regPostDta();

        $vipproduct = $this->postproductdata();

        $vipproduct['qualification_id']    = $_POST['qualification_id'];

        if($_POST['import_qualification']!='1'){

            if(empty($_POST['qualification_id'])){
                $qualification = $this->postQualificationData();

                if(!empty($qualification)){

                    $qualification['user_id'] = $user_id;

                    $qualification_rzt = $this->vipproduct->vipAddQualification($qualification);

                    $vipproduct['qualification_id']    = $qualification_rzt;
                
                }

            }else{

                $qualification = $this->postQualificationData();

                foreach($qualification as $k=>$v){

                    if(!empty($v)){

                        $arr_q["{$k}"] = $v;
                    }
                }
            }

            $arr_q_id = $_POST['qualification_id'];

            $qualification_rzt = $this->vipproduct->vipUpdateQualification($arr_q, $arr_q_id);

        } 

        if(!empty($vipproduct)){

            $vipproduct['id']    = $_POST['id'];
            
            $vipproduct_rzt = $this->vipproduct->updateVipproduct($vipproduct);
        }

        $company_id = $this->vipproduct->getCpmpanyId($vipproduct['id']);

        if(!empty($vipproduct_rzt)){
        
            $this->redirect("/vipsupplysSuccess");
        } else {

            exit("������Ʒʧ��");
        }
    }

    public function getData($user_id,$id){

        $company_id = $this->vipproduct->getCpmpanyId($id);

        if(!empty($company_id)){
            $company_data = $this->company->getVipIdCompany($company_id['company_id']);
            $this->__p__['company'] = $company_data;
        }

        $this->__p__['zizhi'] = $this->vipproduct->userVipproductZizhi($user_id);


        $pusher_id = $this->vipproduct->getPusherId($user_id,$id);

        $this->__p__['pusher'] = $pusher_id;

    }

    public function delete($id){

        if('delete'!=$_GET['action']){ return; }
    
        $rzt = $this->vipproduct->deleteVipproductPusher($id);

        if($rzt){

            echo TRUE; exit;

        } else {

            echo FALSE; exit;
        }
    }
    public function __main__() {

        $user_id = $this->checkSysCookie();

        if(empty($user_id)){ $this->redirect('/'); }

        $id = (!empty($_GET['id'])) ? $_GET['id'] : "" ;

        $this->__p__['id'] = $id;

        $this->delete($id);

        $this->getData($user_id,$id);

        $this->adddata($user_id);


    }
}

