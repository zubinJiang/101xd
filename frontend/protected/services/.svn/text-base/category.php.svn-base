<?php
if(isset($_GET['action']) && 'get'==$_GET['action']) {
	if(empty($_GET['id'])) { return; }

	NBee::import('app/models/MCategory');
	$this->category = new MCategory();
	
	$id = $_GET['id'];

	$id = intval($id);
	if($id<=0) {
		return ;
	}

	$data = $this->category->getById($id);

	$result = '';
	if(!empty($data)) {
	
		foreach($data as $v) {
			$result .= "<option value='{$v['id']}'>{$v['name']}</option>";
		}
	}

	exit($result);
}

?>
