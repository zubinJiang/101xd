<?php
class MRole extends CModel
{
    //获取用户权限
    public function getUserAuth($user_id){

        $data = $this->db->table('`admin_user_role`')
            ->select('role_id')
            ->where("user_id='{$user_id}'")
            ->getFirst();
        return $data;
    }
}
