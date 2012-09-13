<?php

// url 路由規則定義
$url = array(
    //'control' => 'index',
    //'separator' => '-',
    'rule' => array(
        'user' => array(        // control
            //'名稱'        =>    '默認值,值模式匹配'
            'filter'        => 'all,^(all|normal|admin)$',
            'order'         => ',^-?[a-zA-Z_]+$',
            'test'          => '中文,^.+$',
            'curPage'       => '1,^[0-9]+$',
            'id'            => '1,^[0-9]+$',
            'xid'           => '1,^[0-9]+\.html$',
        ),
        'xxx' => array(
            //'名稱'        =>    '默認值,值模式匹配'
            'id'            => '1,^[0-9]+$',
            'xid'           => '1,^[0-9]+$',
        )
    ),
    //'serviceRule' => '^services/.+$'
);


return $url;

?>
