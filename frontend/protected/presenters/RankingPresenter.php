<?php
class RankingPresenter extends InitPresenter
{

    public function __init__() {

        parent::__init__();
            
        NBee::import('app/models/MRebang');

        $this->rebang = new MRebang();
    }

    public function index(){

        $data = $this->rebang->getListData();
        $this->__p__['data'] = $data['data'];
        $this->__p__['count']= $data['count'];

        $page=new Page(array('total'=>$data['count'], 'perpage'=>'10', 'page_name'=>'page'));
        $this->__p__['page'] = $page;

    }
    public function __main__() {

        $this->index();

    }
}