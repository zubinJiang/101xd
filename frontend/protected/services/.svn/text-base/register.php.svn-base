<?php
if (isset($_GET['action']) && !empty($_GET['action'])) {
session_start();
    NBee::import('app/models/MUser');
    NBee::import('app/models/MSite');
    $this->user = new MUser();
    $this->site = new MSite();
    if ('getname' == $_GET['action']){
        if (empty($_GET['name'])) {
            echo 0;
            exit;
        }

        $name = trim($_GET['name']);
        $data = $this->user->findUserByName($name);

        echo $data['UserID'];exit();
    } 


    if('getarea'==$_GET['action']){
        if(empty($_GET['id'])) { exit("<option value=0>--请选择地区--</option>"); }
        $id = intval($_GET['id']);
        if($id<0) {
		    return;
        } else {
        $rzt = $this->site->getAreaList($id);
	    $result = '';
	    if(!empty($rzt)) {
	
		    foreach($rzt as $v) {
			    $result .= "<option value='{$v['id']}'>{$v['name']}</option>";
		    }
	    }
        }

	    echo $result;exit();
    
    }

    if('validation'==$_GET['action']){
        if(empty($_GET['code'])){ exit(); }
        if($_SESSION['regis_user_code']==$_GET['code']){
            echo "ok";
        } else {
            echo "no";
        }
        exit();
    }
}
?>

