<?php
class MSite extends CModel
{  

    /*
     * 根据省份id获取城市列表
     */
    public function getCityList($id) {
        $data = $this->db->table('`city`')
            ->select('id, name')
            ->where("province_id={$id}")
            ->getList();
    
        return $data;
    }


    public function get_Web_Data($id){

        $data = $this->db->table('`website`')
            ->select('id, name, photo, url, `desc`, `scale`, flow, `sort`, level, fans, logo_url, comments, introduction, realpv, cn_rank, tuangou_rank')
            ->where("id = '{$id}'")
            ->getFirst();
        return $data;
    }

    public function get_Area_Data($id){

        $data = $this->db->table('`website_area`')
            ->select('area_id')
            ->where("website_id = '{$id}'")
            ->getList();

        $area = '';
        if(!empty($data)){
            $data_arr = array();
            foreach ($data as $v){
                $data_arr[] = $v['area_id'];
            }
            $str = implode(',', $data_arr);

            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("id in ({$str}) ")
                ->getList();      
        }   

        return $area;
    }

    public function getdata($id=1,$page=1,$num=24){

        if( $id == '1' ) {
            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where('hot=1')
                ->order('id','desc')
                ->getNum($num,($page-1)*$num);
            
            $count = $this->db->table('`area`')
                ->where("hot=1")
                ->getCount();

        } else {
            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("first_name='{$id}'")
                ->getNum($num,($page-1)*$num);
            $count = $this->db->table('`area`')
                ->where("first_name='{$id}'")
                ->getCount();
        }

        $arr = array('data'=>$area,'count'=>$count);

        if(empty($arr['data'])){
            return false;
        } else {
            return $arr;
        }
    }

    public function web_getdata_areas($id,$web_id=1) {
        $data = ($web_id == 1) ? 'w.`scale`' : 'w.realpv';
        if(empty($id)){
            $cond = '';
        } else {
            $cond = "a.first_name='{$id}'";
        }
        $rzt = $this->db->table('`website` w, `website_area` wa, `area` a')
            ->select('distinct w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`,  w.flow, w.`sort`, w.level,w.cn_rank')
            ->where('w.id=wa.website_id')
            ->where('a.id=wa.area_id')
            ->where($cond)
            ->order($data, 'desc')
            ->getList();
        return $rzt;
    }

    public function web_getdata($id=1, $web_id=1) {

        $column = (intval($web_id) == 1) ? 'w.`scale`' : 'w.realpv';
        $data = $this->db->table('`website` w, `website_area` wa')
            ->select('distinct w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.flow, w.`sort`, w.level,w.cn_rank')
            ->where('w.id=wa.website_id')
            ->where("wa.area_id='{$id}'")
            ->order($column, 'desc')
            ->getList();

        return $data;
    }

    public function hotCitySiteByFlow() {
        $data = $this->db->query("select id,name,scale,cn_rank from website where id in (select distinct wa.website_id as id from website_area as wa,area as a where wa.area_id=a.id and a.hot=1) and cn_rank>0 order by realpv desc");
            return $data;
    }

    public function web_getdata_index($id=1,$web_id=1, $hot=false){

        $data = ($web_id == 1) ? 'w.`scale`' : 'w.realpv';
        $id_data = ($web_id == 1) ? '`scale`' : 'realpv';
        if($id == 1) {

            $data = $this->db->query("select id,name,scale,cn_rank,tuangou_rank  from website  order by tuangou_rank asc"); 
            
        } else {
            $data = $this->db->table('`website` w')
                ->select("w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.`sort`, w.level,w.cn_rank, w.tuangou_rank")
                ->order('tuangou_rank', 'asc')
                ->getList();
        }

        return $data;
    }

    public  function addWebData($data){  //添加网站
        $this->db->table('`website`')->insert($data);

        $id = $this->db->last_insert_id();
        return $id;
    }

    public function getWebNameData($name){

        $data = $this->db->table('`website`')
            ->where("name='$name'")
            ->getFirst();
        return $data; 
    }


    public function getWebUrlData($url){
        $data = $this->db->table('`website`')
            ->where("url  like '%$url%' ")
            ->getFirst();
        return $data;

    }

    public function getChannelData() {

        $data = $this->db->table('`website`')
            ->where('level=1 and cn_rank>0')
            ->order('cn_rank','asc')
            ->getList();

        return $data;
    }

    public function createBrowseRecord($website_id, $user_data) {
        $data = array();

        $data['website_id'] = $website_id;
        $data['user_id']    = $user_data['user_id'];
        $data['user_name']  = $user_data['user_name'];

        $tmp = $this->db->exec("select id from `website_record` where website_id='{$website_id}' and user_id='{$data['user_id']}' limit 1");
        if(empty($tmp)) {
            $this->db->table('`website_record`')->insert($data);
        }

        return ;
    }

    public function getBrowseRecord($website_id) {

        return $this->db->table('`website_record`')->where("website_id='{$website_id}'")->getNum(5);
    }

    public function getNetComment($website_id, $page=1, $num=2) {
    
        $data = array();
        $data['data'] = $this->db->table('`website_comment`')
                    ->where("website_id='{$website_id}'")
                    ->order('id','desc')
                    ->getNum($num, ($page-1)*$num);

        $data['count']= $this->db->table('`website_comment`')
                    ->where("website_id='{$website_id}'")
                    ->getCount();

        return $data;
    }

    public function getWebSerach($key){
        $data = $this->db->table('`website`')
            ->select('id,name')
            ->where("name like '%{$key}%' ")
            ->getList();
        return  $data;
    
    }

    public function get_web_citys($id){
        $data = $this->db->table('`website_area`')
            ->where("website_id='{$id}'")
            ->getCount();
        return $data;
    }

    public function getWebsite_logData(){
    
        $data = $this->db->table('`website_log`')
            ->select('insert_date')
            ->order('id','desc')
            ->getFirst();
        return $data;
    }

    public function groupIng($id) {
        $list = $this->db->table('`item`')
            ->select('id, title, image, url')
            ->where("website_id = '{$id}'")
            ->order('id', 'desc')
            ->getNum(5);

        return $list;

    }

     public function getAreaList($id) {     //根据省份id获取地区

        $data = $this->db->table('`city`')
            ->select('id, name')
            ->where("province_id='{$id}'")
            ->getList();
        return $data;
     }

    public function getSitemapWebsiteList(){
        $data = $this->db->table('`website`')
            ->select('id')
            ->getList();
        return $data;
    }

    //vip用户获得website数据
    public function getVipIdWebsite($id){

        $data = $this->db->table('`website`')
            ->select('*')
            ->where("id='{$id}'")
            ->getFirst();
        return $data;
    
    }
}
