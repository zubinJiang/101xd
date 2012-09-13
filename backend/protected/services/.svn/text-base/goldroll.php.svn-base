<?php
if(isset($_GET['action']) && 'get'==$_GET['action']) {
if(empty($_GET['id'])) { exit("<option value=0>--请选择地区--</option>"); }

	NBee::import('app/models/MSite');
	$this->site = new MSite();
	
    $id = intval($_GET['id']);
 
    if($id<0) {
		return;
    } else {
        $data = $this->site->getAreaList($id);

	    $result = '';
	    if(!empty($data)) {
	
		    foreach($data as $v) {
			    $result .= "<option value='{$v['id']}'>{$v['name']}</option>";
		    }
	    }
    }
	exit($result);
}

?>
