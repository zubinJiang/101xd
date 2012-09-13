<?php
if(empty($_GET['action']) || 'delete'!=$_GET['action']) { exit; }

$img = $_GET['image'];

$product_id = $_GET['product'];
$product_id = intval($product_id);
$target_value      = trim($_GET['value']);
$target     = trim($_GET['target']);

NBee::import('app/models/MProduct');

$this->product = new MProduct();

$server_path = $this->config['fileupload']['rootpath'] ;
$url_path    = $this->config['fileupload']['urlpath'] ;

$value = explode('|',$img);

foreach($value as $mv) {
    $photo = str_replace($url_path, $server_path, $mv);
    if (is_file($photo) && file_exists($photo)) {
        @unlink($photo);
    }
}

if($product_id) {
    if('default'==$target) {
        $this->product->updateDefaultImage($product_id);
    } else {
        $this->product->updateProductImage($product_id, $target_value);
    }
}

exit('ok');
?>
