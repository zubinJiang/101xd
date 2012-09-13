<?php

class MRole extends CModel
{  
    
    public function getRoleCount() {

        return $this->db->table('`admin_role`')->getCount();
    }

    public function getRoleList() {

        return $this->db->table('`admin_role`')->getList();
    } 

    public function addRole($data) {
    
        $this->db->table('`admin_role`')->insert($data);

        return $this->db->last_insert_id();
    }

    public function delRole($role_id) {
    
        $tmp = $this->findUserByRoleId($role_id);
        $result = 0;
        if(empty($tmp)) {
            $result = $this->db->exec("delete from `admin_role` where id in {{$role_id}}");
        }

        return $result;
    }

    public function updateRole($data) {
    
        $result = $this->db->table('`admin_role`')->insert($data, true);

        return $result;
    }

    public function findRoleByUserId($user_id) {
    
        $role = $this->db->table('`admin_user_role`')
            ->where("user_id={$user_id}")
            ->getList();

        return $role;
    }

    public function findUserByRoleId($role_id) {
    
        $tmp = $this->db->table('`admin_user_role`')
            ->where("role_id={$role_id}")
            ->getList();

        return $tmp;
    }

    public function getRoleById($role_id) {
    
        $role = $this->db->table('`admin_role`')
            ->where("id={$role_id}")
            ->getFirst();
        return $role;
    }
    
    public function getPermission($role_id, $module_id) {
        $permission = $this->db->table('`admin_module_role`')
            ->where("role_id={$role_id}")
            ->where("module_id={$module_id}")
            ->getFirst();

        return $permission;
    }

    public function updatePermission($data) {
        
        $result = $this->db->table('`admin_module_role`')
            ->where("role_id={$data['role_id']}")
            ->where("module_id={$data['module_id']}")
            ->getFirst();

        if(empty($result)) {
            $count = $this->db->table('`admin_module_role`')->insert($data);
        } else {
            $count = $this->db->exec("update `admin_module_role` set permission={$data['permission']} where role_id={$data['role_id']} and module_id={$data['module_id']}");
        }

        return $count;
    }

    public function updateUserRole($data) {
        $result = $this->db->table('`admin_user_role`')
            ->where("user_id={$data['user_id']}")
            ->getFirst();

        if(!empty($result)) {
        
            $count = $this->db->exec("update `admin_user_role` set role_id='{$data['role_id']}' where user_id = {$data['user_id']}");
        } else {
            $count = $this->db->table('`admin_user_role`')->insert($data);
        }

        return $count;
    }

    //获取用户权限
    public function getUserAuth($user_id){

        $data = $this->db->table('`admin_user_role`')
            ->select('role_id')
            ->where("user_id='{$user_id}'")
            ->getFirst();
        return $data;
    }
}

?>
