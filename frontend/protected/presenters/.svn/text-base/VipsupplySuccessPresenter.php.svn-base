<?php
class vipsupplySuccessPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }


    public function getData($id){

        $company_data = $this->company->getVipIdCompany($id);

        $this->__p__['company'] = $company_data;
    
    }

    public function __main__() {

        $id = $_GET['id'];

        $this->getData($id);
    }
}



