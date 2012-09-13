<?php

class MLog extends CModel
{  
    
    public function addLogData($data) {

        $this->db->table('`log`')->insert($data);

        return $this->db->last_insert_id();

    }
}