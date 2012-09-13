<?php
class MContact extends CModel{

    public function addContactData($data){

        if(empty($data['id'])) {
            $this->db->table('`contact`')->insert($data);
            $contact_id = $this->db->last_insert_id();
        } else {

            $this->db->exec("update `contact` set name='{$data['name']}', tel='{$data['tel']}', other_name='{$data['other_name']}', other_tel='{$data['other_tel']}',mobile='{$data['mobile']}', qq='{$data['qq']}', email='{$data['email']}' where id='{$data['id']}'");
            $contact_id = $data['id'];
        }

        return $contact_id;
    }

    public function getContactFromProductId($id) {

        $data = $this->db->table('`contact` as c, `product` as p')
            ->select('c.name,c.tel,c.qq,c.mobile,c.email')
            ->where('c.id=p.contact_id')
            ->where("p.id = '{$id}'")
            ->getFirst();

        return $data;
    }

    public function getUserContactCount($user_id) {
        $count = $this->db->table('`contact`')
            ->where("user_id='{$user_id}'")
            ->getCount();
        
        return $count;
    }

    public function getUserContactList($user_id, $page=1, $num=10) {
        $data = $this->db->table('`contact`')
            ->select('id, name, tel')
            ->where("user_id='{$user_id}'")
            ->getNum($num, ($page-1)*$num);

        return $data;
    }

    public function getDataContactId($id) {

        $data = $this->db->table('`contact`')
            ->select('id,user_id, name, tel, qq, mobile, email, other_name, other_tel')
            ->where("id='{$id}'")
            ->getFirst();

        return $data;
    }

    public function updateContactInfo($data, $admin=FALSE) {
        if(empty($data['id'])) {
            $this->addContactData($data);
        } else {
            if($admin){

                $result = $this->db->exec("update `contact` set name='{$data['name']}', tel='{$data['tel']}', qq='{$data['qq']}', mobile='{$data['mobile']}', email='{$data['email']}',other_name='{$data['other_name']}',other_tel='{$data['other_tel']}' where  id='{$data['id']}'");
            } else {

                $result = $this->db->exec("update `contact` set name='{$data['name']}', tel='{$data['tel']}', qq='{$data['qq']}', mobile='{$data['mobile']}', email='{$data['email']}',other_name='{$data['other_name']}',other_tel='{$data['other_tel']}' where user_id={$data['user_id']} and id='{$data['id']}'");

            }
            return $result;
        }
    }

}

