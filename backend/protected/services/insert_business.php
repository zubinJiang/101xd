<?php
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) { exit('2');}

NBee::import('app/models/MBusiness');
NBee::import('app/models/MAddress');

$this->business = new MBusiness();
$this->address  = new MAddress();

$business_id = intval($_GET['id']);

$data = $this->business->getDataById($business_id);
$address = $this->address->getAddressById($data['address_id']);
//$province = $this->province->getProvinceById($data['province_id']);

$data['province']       = $address['pname'];
$data['province_id']    = $address['pid'];
$data['city']           = $address['cname'];
$data['city_id']        = $address['cid'];
echo json_encode($data);
exit;
?>
