<?php
//if(!isset($_GET['id']) || empty($_GET['id'])) { return; }
//if(!isset($_GET['action']) || 'getList' != $_GET['action'])) { return; }

NBee::import('app/models/MSite');
NBee::import('app/models/MLog');

$id = intval($_GET['id']);
$this->site  = new MSite();

$data = $this->site->getNewList($id);

if(!empty($data)){
    $rzt = '';
    foreach ($data as $v){
        $rzt .= "<a id={$v['id']}>{$v['name']}</a>";
    }
}
exit($rzt);
?>
