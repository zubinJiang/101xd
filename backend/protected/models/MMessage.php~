<?php

class MMessage extends CModel
{  
    public function sendMessage($sender_id,$receive_id,$message,$type=1) {
        $data = array(
            'sender_id'=> $snder_id,           
            'receiver_id'=> $receiver_id,           
            'maintext'=> $maintext,
            'type'=> $type,
        );
        $this->db->table('message')->insert($data,true);
    }
    /**
     * 删除或者隐藏就是改变status的值
     * 0未读, 1已读, 4已删除
     */
    public function delMessage($message_id) {
        $this->db->exec("update message set status=4 where id=".strval($message_id));
    }

    /**
     * 阅读短消息
     */
    public function getReadMessage($message_id) {
        $this->db->exec("update message set status=1 where id=".strval($message_id));
    }

    /**
     * 获取短消息的总条数
     */
    public function getAllMessageCount($user_id,$type='receiver_id') {
        $all_message_count = $this->db->table('message')
            ->where("{$type}={$user_id}")
            ->where("status!=4")
            ->getCount();
        return $all_message_count;
    }

    /**
     * 获取未读消息的总条数
     */
    public function getNewsMessageCount($user_id,$type='receiver_id') {
        $unreadcount = $this->db->table('message')
            ->where("{$type}={$user_id}")
            ->where('status=0')
            ->getCount();

        $this->db->exec("update `user` set CountMessages={$unreadcount} where UserID={$user_id}");
        
        return $unreadcount;
    }
    /**
     * 该函数实现用户分页查询显示
     * 用户可以根据类型查询发送的消息和收到的消息
     * one_page_show表示每页显示的消息的数量
     * page_number为页码
     */
    public function getDataList($user_id,$page,$num,$type='receiver_id') { 
        $res = $this->db->table('`message`')
            ->where("{$type} = {$user_id}")
            ->where('status!=4')
            ->order('status','ASC')
            ->getNum($num, ($page-1)*$num);

        $RichRes= array();
        /*
         * 此处为查询发送者和收信者的信息
         * 信息包括用户名和头像
         */
        foreach($res as $item) {
    
            $sender = $this->db->table('user')
                ->select('Name,Photo')
                ->where('UserID='.$item[sender_id])
                ->getFirst();

            $receiver = $this->db->table('user')
                ->select('Name,Photo')
                ->where('UserID='.$item[receiver_id])
                ->getFirst();

            if ($item[status]=='0') {
                $item['readstatus']='未读';
                $item['color']='red';
                }
            elseif ($item[status]=='1'){
                $item['readstatus']='已读';
                $item['color']='#999';
            } else{
                $item['readstatus']='未知';
            }
            
            $item[sender]=$sender;
            $item[receiver]=$receiver;
            array_push($RichRes,$item);
        }
        return $RichRes;    

    }
    //统计未读消息数目
    public function countunread($user_id,$type='receiver_id'){
        $unreadcount = $this->db->table('message')
            ->select('id')
            ->where("{$type}={$user_id}")
            ->where('status=0')
            ->getCount();

        $this->db->exec("update `user` set CountMessages={$unreadcount} where UserID={$user_id}");

        return $unreadcount;
    }

    /*
    public function GetPageList($user_id,$page_id,$page_show) {
        $start = (intval($page_id)-1)*$page_show;
        $res = $this->db->table('message') ->select('*')->where('receiver_id='.$user_id)-> getNum($page_show, $start);
        return $res;
    }*/


}

?>
