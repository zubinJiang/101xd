<?php
/*
require_once('lib/db_active_record.php');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'test1');
define('DB_DEBUG', true);


$this->db = new DB_active_record();
*/

// --------------------- select ---------------------
// | common
$this->db->query('select * from aaa where name like "%hei%"');

// | active record
$this->db->table('aaa')->select('name, `nick name`')
    ->order('name', 'DESC')
    ->getList();

'total: ' 
$this->db->table('aaa')->getCount();
'list: '
$array = $this->db->table('aaa')->slect('')->where('id=5')->order('date','desc')->getNum(5, 1);
'get by id:'
foreach($array as $value) {
    echo $value['name']
}

$item= $this->db->table('aaa')->getItem('id', 1);
$item=this->db->table('aaa')->getFirst();
echo $item['name'] 
// --------------------------------------------------
// explain
$this->db->explain('SELECT * FROM aaa limit 9,5');

// --------------------- insert ---------------------
'insert rows: ' 
$this->db->exec( 'insert into aaa (name) value ("junwang")');
'insert rows: ' 
$this->db->exec( 'replace into aaa (name) value ("junwang")');

// | active record
$data = array (
    'id' => '',
    'name' => '黄永德',
    'nick name' => 'ade_","hu:",/"";l;l"\'\sdf\sdf\sdf\sdf\sdf\sdf\ang',
);

'insert rows: ' 
$this->db->table('aaa')->insert($data, true);
'last_insert_id: '
$this->db->last_insert_id();

$data1 = array (
    'id' => '1',
    'name' => '黄永德',
    'nick name' => 'ade_huang',
);
$data2 = array (
    'id' => '2',
    'name' => '王君',
    'nick name' => 'jun_wang',
);
$datas = array( $data1, $data2 );
'insert rows: ' 
$this->db->table('aaa')->batch_insert($datas, true);
'last_insert_id: '
$this->db->last_insert_id();
// --------------------------------------------------

// --------------------- delete ---------------------
// | common
'delete rows : ' 
$this->db->exec('delete from aaa where id=1');

// | active record
'delete rows : '
$this->db->table('aaa')->delete('id=54');
$this->db->table('aaa')->where('id=1');

'delete rows : '
$this->db->table('aaa')->delete();
// --------------------------------------------------

// ------------- update (not complete) -------------- 

// | common
"update rows: "
$this->db->exec("update aaa set name='james' where id=1");

// | active record
$data = array (
    'name' => 'heiheixcvxcvxv',
    'nick name' => 'ade huang',
);
"update rows: "
$this->db->table('aaa')->update($data, "id=1");


$res = $this->db->table('aaa')->getItem('id', 1);
$res['name']='hahahasdfklsldfjsklf';
$res['nick name']='jun wang wang wangsdlkfjskldfjksldfjkl';
"update rows: "
$this->db->table('aaa')->save($res, 'id');


$res = $this->db->table('aaa')->getNum(2, 0);
$res[0]['name'] = 'test';
$res[0]['nick name'] = 'test';
$res[1]['name'] = 'test1';
$res[1]['nick name'] = 'test1';
$res[2]['name'] = 'ejks';
$res[2]['nick name'] = 'ejks';

"update rows: "
$this->db->table('aaa')->save($res, 'id');
