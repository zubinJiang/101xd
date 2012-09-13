<?php

class common {

    public static function hello($db) {
        
        $data = $db->table('data')->getFirst();

        return $data;
    
    }

}

?>
