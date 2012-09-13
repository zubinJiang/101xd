<?php
NBee::import('plugin/Image/1.0/Image');

$img   = $_GET['img'];
$x     = $_GET['x'];
$y     = $_GET['y'];
$width = $_GET['w'];
$height= $_GET['h'];

//$img = str_replace('_660X420','',$img);
$server_path = $this->config['fileupload']['rootpath'] ;
$url_path = $this->config['fileupload']['urlpath'] ;

$config = array();
$config['image_library']    = 'imagemagick';
$config['library_path']     = '/usr/bin/';

$newImg = str_replace($url_path, $server_path, $img);
$image = new image();
// crop image
$cropConfig = $config;
$cropConfig['width']            = $width;
$cropConfig['height']           = $height;
$cropConfig['source_image']     = $newImg;
$cropConfig['maintain_ratio']   = false;
$cropConfig['x_axis'] = $x;
$cropConfig['y_axis'] = $y;

$image->initialize($cropConfig);
$image->crop();

$targetImg = str_replace('660X420', '192X135', $newImg);
$resizeConfig = $config;
$resizeConfig['source_image']   = $newImg;
$resizeConfig['master_dim']     = 'auto';
$resizeConfig['width']          = 192;
$resizeConfig['height']         = 135;
$resizeConfig['new_image']      = $targetImg;
$resizeConfig['maintain_ratio'] = TRUE;
$image->initialize($resizeConfig);
$image->resize();


header("Cache-Control:post-check=0,pre-check=0",false);    
header("Pragma:no-cache");
exit($img . '?c=' . date('YmdHis'));
?>
