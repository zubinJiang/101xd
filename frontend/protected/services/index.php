<?php
    NBee::import('app/models/MProduct');
    $this->product = new MProduct();
    $pic_url  = $this->config['fileupload']['urlpath'];
    $pic_path = $this->config['fileupload']['rootpath'];

    $type = !empty($_GET['type']) ? intval($_GET['type']) : 0;

    $product_list = $this->product->getIdexProductList($type);

    if(!empty($product_list)) {
        foreach($product_list as $v) {
            $photo = 'images/zanwu.gif';
            if(!empty($v['default_image'])) {
                $photo = $v['default_image'];

                $tmp  = pathinfo($photo);
                $tmp['filename']  = str_replace('660X420', '192X135', $tmp['filename']);
                $tmp['extension'] = strstr($tmp['extension'], '?', true);
                $file_name = $tmp['dirname'] . '/' . $tmp['filename'] .'.'. $tmp['extension'];
                $tmp_name  = str_replace($pic_url, $pic_path, $file_name);
                if(file_exists($tmp_name)) {
                    $photo = $file_name;
                }

            } elseif(!empty($v['image'])){
                $images = explode('|',$v['image']);
                $photo  = current($images);

                $tmp  = pathinfo($photo);
                $file_name = $tmp['dirname'] . '/' . $tmp['filename'] . '_660X420.' . $tmp['extension'];
                $tmp_name  = str_replace($pic_url, $pic_path, $file_name);
                if(file_exists($tmp_name)) {
                    $photo = $file_name;
                }
            }

            //$photo = str_replace('http://image.101xd.com/', 'http://fast.101xd.com/', $photo);

            if(strlen($v['title'])>15){
                $v['title'] = mb_substr($v['title'],0,15,"utf-8");
            }

            $v['market_price'] = empty($v['market_price']) ? 0 : $v['market_price'];
            if($v['market_price']>0 && is_numeric($v['supply_price'])) {
                $num = $v['supply_price'] / $v['market_price'];
                $num = $num * 10;
                $zhe = number_format($num, 1, '.', '');
                $string = "折扣价：<b style='color:#f00;'>{$zhe}</b>折";
            } else {
                $string = "<b style='color:#f00;'>{$v['supply_price']}</b>";
            }

            $html .= <<<EOF
        <div class="product">
            <div class="pic"><a href="product_{$v['id']}.html" target='_blank'><img src="{$photo}" width="193" height="135" /></a></div>
            <div class="price">
                <div class="title_pro"><a href="product_{$v['id']}.html" target='_blank'>{$v['title']}</a></div>
                <div class="price_pro"><span class='m_p_pro'>市场价：<b style="color:#f00">{$v['market_price']}</b>元</span><span class='s_p_pro'>{$string}</span></div>
            </div>
        </div>
EOF;
        }

        echo $html;
        exit;
    }
?>

