<?php
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { exit('2');}

NBee::import('app/models/MContact');
NBee::import('app/models/MArea');
NBee::import('app/models/MProvince');

$this->contact = new MContact();
$contact_id = intval($_GET['id']);

$data = $this->contact->getDataContactId($contact_id);

echo json_encode($data);
exit;
?>
