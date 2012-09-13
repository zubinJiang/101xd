<?php
class ProductPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();

        NBee::import('app/models/MRole');
        $this->role = new MRole();
    }

    public function GetHotProduct($id){//获取热门产品，排除当页的显示产品
        $this->__p__['HotProducts'] = $this->product->GetHotProduct($id);
    }

    public function AttentionBusiness($id){//查询那些渠道商关注商家
        $this->__p__['attention']= $this->product->getAttentionBusiness($id);
    } 

    //查询关注的状态
    private function attentionStatus($id) {
        $user_id = $this->getUserStatus();
        if(!$user_id) { return false;}

        $tmp = $this->attention->getAttention($user_id, $id);
        if($tmp) { return true;}

        return false;
    }

    public function index($id){

        //查询产品的详细数据
        $product = $this->product->getItemOneData($id);
        if($product['vip']) { exit('vip');}
        if(empty($product)) { header("Location:404");}

        $product['favorite']   = $this->product->getFavoriteCount($id);  //收藏人气 

        //查询产品对应的联系人数据
        $role_id = $this->__p__['user_auth']['role_id'];
        if($role_id=='1' || $role_id=='2' || $this->attentionStatus($product['user_id'])) {
            $this->__p__['attention_flag'] = TRUE;

            if(!empty($product['contact_id'])) {
                $contact = $this->product->getItemContact($product['contact_id']);
                $this->__p__['contact'] = $contact;
            }
        }

        //查询产品对应的商家数据
        $business = $this->product->getItemBusiness($product['business_id'],$product['address_id']);
        $this->__p__['business'] = $business;

        if(!empty($product['category'])){
            if($product['category'] == 'local'){
                $leval = 2;
            }  elseif ($product['category'] == 'net'){
                $leval = 3;
            } else {
                $leval = 4;
            }
            $type = $this->product->getNextType($leval);

            $style = array();
            if(!empty($type)){
                foreach($type as $k=>$v){
                    $sum = $v['count'];
                    if($sum > 0){
                        $style [$v['id']]= $v['name']; 
                    }
                }
            }

            $this->__p__['style'] = $style;
        }

        //查询包邮城市
        if($product['free_mail']=='2'){
            $free_city = $this->product->getFreeCityData($product['id']);
            $this->__p__['free_city'] = $free_city;
        
        }

        // 注册用
        $this->__p__['category_list']  = $this->user->getStyleList();

        $this->__p__['product'] = $product;

        // seo
        $this->seo($product);
    }

    private function seo($product) {
        $this->__p__['title']   = $product['title'] . '_团购供货_101兄弟';
        $keyword = explode(' ', $product['keywords']);
	    //对个位十位百位取2的模，在组合顺序二进制得到0-7的数
        $id_ = $product['id'];
        $ge = (($id_%10)/1)%2;
        $shi = (($id_%100)/10)%2;
        $bai = (($id_%1000)/100)%2;
        $keywords_base = array('货源','批发','b2b','供货','渠道','代销','供应商','供货商');
        $index_1 = $bai*2*2+$shi*2+$ge;
        $index_2 = $ge*2*2+$bai*2+$shi;
        $key_1  = $keywords_base[$index_1];
        $key_2  = $keywords_base[$index_2];
	if ($key_1 == $key_2){
	$key_3 = $keywords_base[$shi*2*2+$bai*2+$ge];
	if ($key_3 == $key_1)
		{
		$key_4 = $keywords_base[$bai*2*2+$ge*2+$shi];
		if ($key_4 == $key_1)
			{
			$key_5 = $keywords_base[$ge*2*2+$shi*2+$bai];
			if ($key_5 == $key_1)
				{
				$key_6 = $keywords_base[$shi*2*2+$ge*2+$bai];
				$key = $key_1.' , '.$key_6;
				}
			else
				{
				$key = $key_1.' , '.$key_5;
				}
			}
		else
			{
			$key = $key_1.' , '.$key_4;
			}
		}
	else
		{
		$key = $key_1.' , '.$key_3;
		} 
	}
	else{
    $key = $key_1.' , '.$key_2;}
	//个位，十位，百位全部相等的时候,
	if ($bai == $shi && $shi == $ge)
		{
		$key = $keywords_base[0].' , '.$keywords_base[5];
		}
        $this->__p__['keywords']    = $key;//'|'.$index_1.'&'.$index_2.'|'.$bai.'|'.$shi.'|'.$ge;
        $arr = array('\r', '\n', '\r\n');
        $tmp = str_replace($arr, '', $product['description']);
        $tmp = strip_tags($tmp);
        $tmp = str_replace('&nbsp;', '', $tmp);
        $this->__p__['description'] = trim(mb_substr($tmp,0,255,"utf-8"));
        unset($i);
        unset($tmp);
        unset($key);
    }

    public function __main__() {
        if(!isset($_GET['id']) || empty($_GET['id'])) { header("Location:404");}

        $user_id= $this->checkSysCookie();
        if($user_id) {
            $this->__p__['user_id']   = $user_id;
            $this->__p__['user_auth'] = $this->role->getUserAuth($user_id);
        }

        $id = intval($_GET['id']);
        $this->index($id);
        $this->GetHotProduct($id);
        $this->AttentionBusiness($id);
    }
}
