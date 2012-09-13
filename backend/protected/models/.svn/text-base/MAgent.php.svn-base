<?php

class MAgent extends CModel
{  
    
    public function addAgentData($data) {

        $this->db->table('`agent`')->insert($data);

        return $this->db->last_insert_id();

    }

}

?>
