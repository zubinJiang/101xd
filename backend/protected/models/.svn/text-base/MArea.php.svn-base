<?php
class MArea extends CModel
{
    public function getAreaById($area_id) {
        $data = $this->db->table('`area`')
            ->where("id={$area_id}")
            ->getFirst();

        return $data;
    }
}
