<?php
//关闭报错
session_start();
error_reporting(0);
//图片宽度
$x_size=120;
//图片高度
$y_size=25;

$action = $_GET['action'];
$nmsg=num_rand(4);
$S=$_SERVER['SERVER_PORT']=='443' ? 1:0;
$_SESSION['check_code'] = $nmsg;
setCookie('ck_num',md5($nmsg),0,'/','',$S);

$aimg = imagecreate($x_size,$y_size);
//设置图片背景色
$back = imagecolorallocate($aimg, 255, 255, 255);
//设置字体颜色
$border = imagecolorallocate($aimg, 0, 0, 0);
//从0,0点填充59*19的白色矩形区域
imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
//从0,0点绘制59*19的黑色矩形边框
imagerectangle($aimg, 2, 2, $x_size - 1, $y_size - 1, $border);

for ($i=0;$i<strlen($nmsg);$i++){
    //在图片上写字
    imageString($aimg,5,$i*$x_size/4+3,2, $nmsg[$i],$border);
}
header("Content-type: image/png");
imagepng($aimg);
imagedestroy($aimg);exit;

function num_rand($lenth){
    mt_srand((double)microtime() * 1000000);
    //产生有4个随机数字的字符串
    for($i=0;$i<$lenth;$i++){
        $randval.= mt_rand(0,9);
    }
    //对含有4个数字的字符串使用md5加密,长度是32位的
    //从3长度为32的字符中,自最小数起或最大数32-$lenth起,取长度为$lenth的字符串
    $randval=substr(md5($randval),mt_rand(0,32-$lenth),$lenth);
    return $randval;
}

