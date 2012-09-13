<?php
class BasePresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function __main__() {
        if(!$this->checkSysCookie()) { 
            $this->redirect('register');
        } else {
            $this->redirect('/');
        }
    }
}


