<?php
class ForgetPresenter extends InitPresenter
{
    public function __init__() {
        session_start();

        parent::__init__();
        NBee::import('app/models/MCode');
        $this->code = new MCode();
    }

    public function validateCode() {
        if(!isset($_GET['code']) || empty($_GET['code'])) { return; }

        $code = trim($_GET['code']);
        $code = strtolower($code);

        $ip = $_SERVER['REMOTE_ADDR'];
        $db_code = $this->code->get($ip, '2');

        if(empty($db_code) || $code!=$db_code['code']) {
            $this->__p__['error_msg'] = '请填写正确的验证码！';
        }
    }

    public function validateName() {
        if(!isset($_GET['name']) || empty($_GET['name'])) { return; }

        $name = trim($_GET['name']);

        $tmp = $this->user->findUserByName($name);

        if(empty($tmp)) {
            $this->__p__['error_msg'] = '用户名不存在，请重新填写！';
        }

        $this->__p__['user_id'] = $tmp['UserID'];

        $this->ajaxValidateName($tmp);
    }

    private function ajaxValidateName($tmp) {
        if(!isset($_GET['action']) || 'getname'!= $_GET['action']) { return; }
            if(empty($tmp)) { 
                echo FALSE;
            } else {
                echo TRUE;
            }
        exit;
    }

    private function num_rand($lenth){
        mt_srand((double)microtime() * 1000000);
        for($i=0;$i<$lenth;$i++){
            $randval.= mt_rand(0,9);
        }
        $randval=substr(md5($randval),mt_rand(0,32-$lenth),$lenth);

        $ip = $_SERVER['REMOTE_ADDR'];
        $data = array(
            'ctype'  => '2',
            'tel_ip' => $ip,
            'code'   => $randval,
            'insert_date' => time()
        );
        $this->code->add($data);

        return $randval;
    }

    private function generetion() {
        if('gecode'==$_GET['action']) {
            $x_size=120;
            $y_size=25;

            $nmsg= $this->num_rand(4);

            $aimg = imagecreate($x_size,$y_size);
            $back = imagecolorallocate($aimg, 255, 255, 255);
            $border = imagecolorallocate($aimg, 0, 0, 0);
            imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
            imagerectangle($aimg, 2, 2, $x_size - 1, $y_size - 1, $border);

            for ($i=0;$i<strlen($nmsg);$i++){
                imageString($aimg,5,$i*$x_size/4+3,2, $nmsg[$i],$border);
            }

            header("Content-type: image/png");
            imagepng($aimg);
            imagedestroy($aimg);
            exit;
        }
    }

    public function __main__() {

        $this->generetion();
        $this->validateName();
        $this->validateCode();
    }
}
