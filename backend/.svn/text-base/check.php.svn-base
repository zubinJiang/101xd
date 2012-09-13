<?php
header('Content-type: image/png;');
session_start();

$check_code = mt_rand(1000, 9999);
$_SESSION['check_code'] = $check_code;

$im         = imagecreatetruecolor(75, 25);
$text_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
imagestring($im, 5, 18, 5,  $check_code, $text_color);
imagepng($im);
imagedestroy($im);
