<?php

class MMedia extends CModel
{

    public function getMediaList($page, $num, $q='',$postDate=false) {

        $qCond = '';
        if (!empty($q)) {
            $qCond = "title like '%$q%'";
        }
    
        $dateCond = '';
        if (!empty($postDate)) {
            $dateCond = "DATE_FORMAT(datetime, '%Y%m') = '{$postDate}'";
        }

        return $this->db->table('meta')
            ->where($qCond)
            ->where($dateCond)
            ->order('id', 'desc')
            ->getNum($num, ($page-1)*$num);
    
    }

    public function getMediaDate() {
    
        return $this->db->table('meta')
            ->select('distinct DATE_FORMAT(datetime, "%Y %m") as date')
            ->order('id', 'desc')
            ->getList();
    }

    public function getMediaItem($id) {
    
        return $this->db->table('meta')
            ->getItem('id', $id);
    
    }


    public function getCount($search='', $date=false) {

        $searchCond = false;
        if (!empty($search)) {
            $searchCond = "title like '%{$search}%'";
        }

        $dateCond = '';
        if (!empty($date)) {
            $dateCond = "DATE_FORMAT(datetime, '%Y%m') = '{$date}'";
        }

        $count = $this->db->table('meta')
            ->where($searchCond)
            ->where($dateCond)
            ->getCount();
        
        return $count;

    }


    public function saveMedia($name, $description='', $meta_value, &$id=0) {

        $misc_data = array();
        $misc_data['name']          = $name;
        $misc_data['description']   = $description;
        $misc_data['meta_value']    = $meta_value;

        if (empty($id)) {
            $res = $this->db->table('meta')->insert($misc_data);
            if ($res) {
                $id = $this->db->last_insert_id();
            }
        } else {
            $res = $this->db->table('meta')->where("id = $id")
                ->update($misc_data);
        }

        return (bool)$res;
    
    }

    public function deleteMedia($id) {

        if (empty($id)) return false;

        if (is_array($id)) {
            $id = implode(',', $id);
        }

        $res = $this->db->table('meta')->where("id in ($id)")->delete();

        return (bool)$res;
    
    }
}

?>
