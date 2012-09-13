<?php

define('BEE_DEBUG', true);

$NBee   = '/mnt/lib/NBee/1.0/NBee.php';
$config = dirname(__FILE__).'/protected/config/main.php';

require( $NBee );

NBee::createWebApplication($config)->run();

?>
