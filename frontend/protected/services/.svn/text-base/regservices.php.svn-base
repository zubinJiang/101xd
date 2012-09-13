<?php
session_start();
if ( isset($_GET['action']) && !empty($_GET['action'])) {
    if ('reg' != $_GET['action']) exit;
    NBee::import('app/models/MUser');

    $this->user = new MUser();

    $name = trim($_GET['name']);

    if(empty($name)) {
        echo json_encode(array('id'=>2, 'result'=>'用户名不能为空！'));
        exit;
    }

    $tmp = $this->user->findUserByName($name);

    if(empty($tmp)) {
        echo json_encode(array('id'=>1, 'result'=>'用户名可用！'));
        exit;
    }

    echo json_encode(array('id'=>2, 'result'=>'用户名已存在！'));
    exit;
}
?>
