<?php
if(empty($_GET['action']) || 'delete'!=$_GET['action']) { exit; }

$img = $_GET['image'];

$server_path = $this->config['fileupload']['rootpath'] ;
$url_path    = $this->config['fileupload']['urlpath'] ;

$photo = str_replace($url_path, $server_path, $img);
if (is_file($photo) && file_exists($photo)) {
    @unlink($photo);
}

exit('ok');
?>
