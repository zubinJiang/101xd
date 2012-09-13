<?php
if(!isset($_GET['action']) || 'update'!=$_GET['action']) { return; }
if(!isset($_GET['id']) || empty($_GET['id'])) { return; }
if(!isset($_GET['style']) || empty($_GET['style'])) { return; }

$id = intval($_GET['id']);
$type = $_GET['style'];

if($type == 'local'){
    header("Location:local?action=update&id={$id}");
} elseif ($type== 'net'){
    header("Location:releasenets?action=update&id={$id}");
} else {
    header("Location:goldroll?action=update&id={$id}");
}

