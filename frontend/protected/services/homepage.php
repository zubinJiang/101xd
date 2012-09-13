<?php
if(!isset($_GET) && empty($_GET)){ return; }

NBee::import('app/models/MProduct');
NBee::import('app/models/MUser');
NBee::import('plugin/Page/1.0/Page');
$this->product  = new MProduct();
$this->user  = new MUser();

$sort         = isset($_GET['sort']) ? $_GET['sort'] : 'price';
$page         = isset($_GET['page']) ? $_GET['page'] : 1;
$category_id  = isset($_GET['id']) ? $_GET['id'] : 2;
$way 	      = isset($_GET['way']) ? $_GET['way'] : '';

$pic_url = $this->config['fileupload']['urlpath'];
$pic_path = $this->config['fileupload']['rootpath'];

$page  = intval($page);
$num   = 9;

$type = null;
if($category_id==2){
    $type = 'local';
}elseif($category_id==3){
    $type = 'net';
}elseif($category_id==4){
    $type = 'goldroll';
}

$data = $this->product->getProductTypeList($category_id, $sort, $way, $num, $page, $type); 
$rzt = "";
//产品的遍历
    $rzt .= '<ul>';
if(!empty($data['list'])){

    $rand_count = count($data['list']);
    if(!empty($data['list']) && $category_id==3 && $rand_count>9){
        $tmpe = array_rand($data['list'],9);
        $rail = array();
        foreach($tmpe as $v){
            $rail[] = $data['list'][$v];
        }
    } else {
        $rail = $data['list'];
    }
    foreach($rail as $v){
        $photo = 'images/zanwu.gif';
        if(!empty($v['default_image'])) {
            $photo = $v['default_image'];
            $tmp  = pathinfo($photo);
            $tmp['filename']  = str_replace('660X420', '192X135', $tmp['filename']);
            $tmp['extension'] = strstr($tmp['extension'], '?', true);
            $file_name = $tmp['dirname'] . '/' . $tmp['filename'] . '.' . $tmp['extension'];
            $tmp_name  = str_replace($pic_url, $pic_path, $file_name);
            if(file_exists($tmp_name)) {
                $photo = $file_name;
            }
        } elseif(!empty($v['image'])){
            $images = explode('|',$v['image']);
            $photo  = current($images);
            $tmp    = pathinfo($photo);
            $file_name = $tmp['dirname'] . '/' . $tmp['filename'] . '_660X420.' . $tmp['extension'];
            $tmp_name  = str_replace($pic_url, $pic_path, $file_name);
            if(file_exists($tmp_name)) {
                $photo = $file_name;
            }
        }

        $photo = str_replace('http://image.101xd.com/', $pic_url, $photo);
        $photo = str_replace('http://image2.101xd.com/', $pic_url, $photo);
        $photo = str_replace('http://image2.101xd.com/', 'http://fast.101xd.com/', $photo);

        $v['attentions']  = empty($v['attentions']) ? 0 : $v['attentions'];
        $v['market_price']= empty($v['market_price']) ? 0 : $v['market_price'];

        if($v['market_price']>0 && is_numeric($v['supply_price'])) {
            $num = $v['supply_price'] / $v['market_price'];
            $num = $num * 10;
            $zhe = number_format($num, 1, '.', '');
            $string = "折扣价：<strong>{$zhe}</strong>折";
        } else {
                $string = '<font color=red>'.$v['supply_price'].'</font>';
        }
        $att_count = $v['attentions'];
        $len = strlen($v['title']);
        if($len>20){
            $str = mb_substr($v['title'],0,19,"utf-8");
        } else {
            $str = $v['title'];
        }
        
        $rzt .= <<<EOF

        <li>
          <div class="title_li"><a target="_blank" href='product_{$v['id']}.html'><img width='192' src='{$photo}' alt='{$v['title']}' /></a></div>
          <div class="desc_li"><div class='title'><a target="_blank" href='product_{$v['id']}.html' id={$v['id']}>{$str}</a></div><div class='desc'>市场价：{$v['market_price']}元  {$string}</div></div>
        </li>

EOF;
    }
} else {
    $rzt .= "对不起当前没有此分类的商品";
}
    $rzt .= '</ul>';

$rzt .= "%";
$temp = '';
$style = array();
//遍历查询二级分类的产品数量
        if(!empty($data['type'])){
            foreach($data['type'] as $k=>$v){
                if($v['count'] > 0){
                    $rzt .= "<a href='#'>{$v['name']}<span style='color:red'>({$v['count']})</span></a;>"; 
                    $style [$v['id']] = $v['name']; 
                } 
            }
            $i = 1;
            $count = count($style);
            foreach ($style as $k=>$v){
                if($i == $count){
                    $temp .= "<a href='childpages_{$k}.html' value='{$k}'>{$v}</a>"; 
                } else {
                    $temp .= "<a href='childpages_{$k}.html' value='{$k}'>{$v}</a><span>|</span>";
                } 
                $i++;
            }
        }
$rzt .= '%';
$rzt .= $temp;
$rzt .= '%';

$page=new Page(array('total'=>$data['count'],'perpage'=>9,'page_name'=>'page'));
$rzt .= $page->show(4);
exit($rzt);
?>
