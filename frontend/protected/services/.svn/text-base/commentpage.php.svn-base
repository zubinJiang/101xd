<?php
if ( isset($_GET['action']) && !empty($_GET['action'])) {
    if ('comment' != $_GET['action']) exit;
    if (!isset($_GET['id'])) exit;

    NBee::import('app/models/MSite');
    NBee::import('plugin/Page/1.0/Page');

    $this->site = new MSite();

    $id   = intval($_GET['id']);
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $num  = 5;
    $data = $this->site->getNetComment($id, $page, $num);

    function stars($value) {
        if($value<=1) {
            return '很差';
        }elseif(1<$value && $value<3) {
            return '还行';
        }elseif(3==$value) {
            return '一般';
        }elseif(3<$value && $value<5) {
            return '好';
        }elseif(5==$value) {
            return '非常好';
        }
    }

    $html = '';
    if(!empty($data)) {

        $count = count($data['data']);
        if(!empty($data['data'])) {
            $i = 0;
            foreach($data['data'] as $v) {
                $html .= '<ol>';
                if($v['anonymity']==1){
                    $name = '匿名显示';
                } else {
                    $name = $v['user_name'];
                }

                $key_one = stars($v['product_quality']);
                $key_two = stars($v['after_service']);
                $key_thr = stars($v['product_price']);

                $html .= <<<EOF
        <li>用户名：{$name}</li>
        <li>购买商品名称：{$v['product_name']}</li>
        <li>商品质量：{$key_one}({$v['product_quality']})</li>
        <li>售后服务：{$key_two}({$v['after_service']}分)</li>
        <li>商品价格：{$key_thr}({$v['product_price']}分)   补充理由：{$v['reason']}</li>
EOF;
            $html .= '</ol>';

            if($i!=4) {
            $html .= '<ol><li class="blankline">&nbsp;</li></ol>';    
        }

            $i++;
            }
        }


        $page=new Page(array('total'=>$data['count'],'perpage'=>$num,'page_name'=>'page'));

        $html .= '<p>' . $page->show(4) . '</p>';
    }

    exit($html);

}
?>
