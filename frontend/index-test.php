<?php

define('BEE_DEBUG', true);

$max = filemtime(dirname(__FILE__).'/index.php');
$interval = 60 * 60 * 6;
header ("Last-Modified: " . gmdate ('r', $max)); 
header ("Expires: " . gmdate ("r", ($max + $interval))); 
header ("Cache-Control: max-age=$interval"); 

$NBee   = '/mnt/lib/NBee/1.0/NBee.php';
$config = dirname(__FILE__).'/protected/config/main.php';

require( $NBee );

NBee::createWebApplication($config)->run();

?>
