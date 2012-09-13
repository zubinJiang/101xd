<?php
class   ExcelPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
    }

    public function read(){

        error_reporting(E_ALL);   

        $data = new spreadsheet_excel_reader(); 

        var_dump($data);

        $temp=file("/mnt/bak/dev/frontend/demo.xlsx");//连接EXCEL文件,格式为了.csv  
        
        for ($i=0;$i<count($temp);$i++){  
            $string=explode(",",$temp[$i]);//通过循环得到EXCEL文件中每行记录的值  
            mb_convert_encoding("gb2312", "UTF-8", $string[$i]);
            echo $string[$i];
        }

    }
    public function __main__() {

        $this->read();
    }
}
