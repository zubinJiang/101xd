<?php
class MSite extends CModel
{  

    public function get_Web_Data($id){

        $data = $this->db->table('`website`')
            ->select('distinct id, name, photo, url, `desc`, `scale`, flow, `sort`, level, fans, comments')
            ->where("id = '{$id}'")
            ->getFirst();
        return $data;
    }

    public function get_Area_Data($id){

        $data = $this->db->table('`website_area`')
            ->select('area_id')
            ->where("website_id = '{$id}'")
            ->getList();

        if(!empty($data)){
            $data_arr = array();
            foreach ($data as $v){
                $data_arr[] = $v['area_id'];
            }
            $str = implode($data_arr,',');

            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("id in ({$str}) ")
                ->getList();      
        } else {

            $area = '';
        }   
        return $area;

    }

    public function getdata($id=1) {

        if( $id == '1' ) {
            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("hot=1")
                ->order('datetime', 'desc')
                ->getList();

        } else if( $id == '2' ) {
            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("id<>296")
                ->order('hot', 'desc')
                ->getList();

        } else {
            $area = $this->db->table('`area`')
                ->select('id, `area`, first_name, hot, datetime')
                ->where("first_name='{$id}'")
                ->getList();
        }

        return $area;	
    }

    public function web_getdata_areas($area=array(), $web_id=1) {

        if(empty($area)) { return; }

        $area_str = implode($area,',');
        $data = ($web_id == 1) ? 'w.`scale`' : 'w.cn_rank';
        $sort = ($web_id == 1) ? 'desc' : 'asc';
        $data = $this->db->table('`website` w, `website_area` wa')
            ->select('w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.flow, w.`sort`, w.level,w.cn_rank')
            ->where('w.id=wa.website_id')
            ->where('w.cn_rank > 0')
            ->where("wa.area_id in ({$area_str})")
            ->order($data, $sort)
            ->getList();

        return $data;
    }

    public function web_getdata($id=1, $web_id=1) {

        $data = ($web_id == 1) ? 'w.`scale`' : 'w.cn_rank';
        $sort = ($web_id == 1) ? 'desc' : 'asc';
        $data = $this->db->table('`website` w, `website_area` wa')
            ->select('w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.flow, w.`sort`, w.level,w.cn_rank')
            ->where('w.id=wa.website_id')
            ->where("wa.area_id={$id}")
            ->where("w.level=0")
            ->order($data, $sort)
            ->getList();

        return $data;
    }

    public function web_getdata_index($id=1,$web_id=1, $hot=false){

        $data = ($web_id == 1) ? 'w.`scale`' : 'w.cn_rank';
        $sort = ($web_id == 1) ? 'desc' : 'asc';
        if($id == 1) {
            $data = $this->db->query("select * from website where id in (select distinct wa.website_id as id from website_area as wa,area as a where wa.area_id=a.id and a.hot=1) and cn_rank>0 and level=0 order by scale desc"); 
        } else {
            $data = $this->db->table('`website` w')
                ->select("w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.`sort`, w.level,w.cn_rank")
                ->where("w.cn_rank>0")
                ->where("w.level=0")
                ->order($data, $sort)
                ->getList();
        }

        return $data;
    }


    public function services_area_getdata($id, $web_id) {

        $data = ($web_id == 1) ? 'w.`scale`' : 'w.cn_rank';
        $sort = ($web_id == 1) ? 'desc' : 'asc';
        $data = $this->db->table('`website` w, `website_area` wa, `area` a')
            ->select('distinct w.id as id, w.name, w.photo, w.url, w.`desc`, w.`scale`, w.cn_rank, w.`sort`, w.level')
            ->where('w.id=wa.website_id')
            ->where("a.first_name='{$id}'")
            ->where('a.id=wa.area_id')
            ->where('w.cn_rank>0')
            ->where('w.level=0')
            ->order($data, $sort)
            ->getList();

        return $data;
    }

    public  function addWebData($data){  //添加网站
        $data = $this->db->table('`website`')
            ->insert($data);

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

    public function getProvinceData() {    //获取所有省份列表
        $data = $this->db->table('`province`')
            ->select('id, name')
            ->getList();
        return $data;
    }

    public function getAreaList($id) {     //根据省份id获取地区

        $data = $this->db->table('`city`')
            ->select('id, name')
            ->where("province_id={$id}")
            ->getList();
        return $data;
    }

    public function addFreeData($data) { //添加邮寄城市
        $data = $this->db->table('`free_city`')
            ->insert($data);
        return $data;
    
    }

    public function getProvinceAreaID($id){//获取直辖市对应的地区表ID

        $data = $this->db->table('`city`')
            ->select('id')
            ->where("province_id={$id}")
            ->getFirst();
        return $data; 
    }

    //后台首页web排序
    public function getNewList($id){

        $order= ($id == 1) ? '`scale`' : 'cn_rank';
        $sort = ($id == 1) ? 'desc' : 'asc';
        $data = $this->db->table('`website`')
            ->select('id,name,url')
            ->where('cn_rank>0')
            ->where('level=0')
            ->order($order, $sort)
            ->getNum(10);
        return $data;
    }

    //获取供应商关注渠道商的数据
   public function getGroupData($id) {

       return $this->db->table('`company` c, `user` u')
                ->select('c.id as cid, c.name as cname')
                ->where('u.CompanyID=c.id')
                ->where("u.UserID='{$id}'")
                ->getFirst();
    }

    //update邮寄城市
    public function updateFreeData($data){
        $data = $this->db->exec("update `free_city` set product_id='{$data['product_id']}', city_id='{$data['area_id']}' where id='{$data['id']}'");
        return $data;

    }

    //查询邮寄城市
    public function getFreeCityData($id){

        $data = $this->db->table('`free_city`')
            ->select('city_id')
            ->where("product_id={$id}")
            ->getFirst();

        if(!empty($data)){
            $id = implode(',',$data);

            $city = $this->db->table('`city`')
                ->select('id,name')
                ->where("id in ({$id})")
                ->getList();

            $query = array('id'=>$id,'city'=>$city);
        
        } 

        return $query;
    }

}

?>
