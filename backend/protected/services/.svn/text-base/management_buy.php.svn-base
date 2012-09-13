<?php
$action = (!isset($_GET['action'])) ? "" :  $_GET['action'];

NBee::import('app/models/MConfirmsupply');

$this->confirmsupply = new MConfirmsupply();

if(empty($action)) {

    $product = $this->confirmsupply->getProductIdData($_COOKIE['idcookie']);

    $result = '';
    if(empty($product)){
        $result='';
    } else {
        foreach ($product as $k=>$v) {
            $result .= "<span>{$v['Name']}</span>&nbsp;&nbsp;<span class={$k} ><a href='#' class='confirm' key={$k} ref={$_COOKIE['idcookie']}>确认</a><span>/</span>
                <a href='#' class='refused' key={$k} ref={$_COOKIE['idcookie']}>拒绝</a></span><br/>";
        }
    }
    echo $result;

}
?>
