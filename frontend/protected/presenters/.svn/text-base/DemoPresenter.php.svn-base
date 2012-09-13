<?php
class DemoPresenter extends InitPresenter
{

    public function __init__() {
        parent::__init__();
	echo 'start';
    }

    public function load(){
    $time = date("Y-m-d",time());
$xmlitem = <<<XMLITEM
<url> 　　
<loc>http://www.101xd.com</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>always</changefreq> 　　
<priority>1.0</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/local</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>always</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/net</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>always</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/login</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/register</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/contact</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url> 
<url> 　　
<loc>http://www.101xd.com/profile</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/agent</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/daohang</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/ranking</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.95</priority> 　　
</url>
<url> 　　
<loc>http://www.101xd.com/forget</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.90</priority> 　　
</url>
XMLITEM;
    return  $xmlitem;
    }

    public function outtype(){

        $data = $this->category->getListData();
        $time = date("Y-m-d",time());
        if(!empty($data)){
            foreach($data as $v){
                $type_url = "http://www.101xd.com/childpages?id={$v['id']}";
$xmlitem .= <<<XMLITEM
<url> 　　
<loc>{$type_url}</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>daily</changefreq> 　　
<priority>0.90</priority> 　　
</url>
XMLITEM;
            }
        }
        return $xmlitem;
    }

    public function getproduct(){
        $data = $this->product->getProductidList();
        if(!empty($data)){
            foreach($data as $v){
                $type_url = "http://www.101xd.com/product_{$v['id']}.html";
                $date = strtotime($v['insertdate']);
                $time = date("Y-m-d",$date);
$xmlitem .= <<<XMLITEM
<url> 　　
<loc>{$type_url}</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.85</priority> 　　
</url>
XMLITEM;
            }
        }
        return $xmlitem;
    }

    public  function  getWebSite(){
        $time = date("Y-m-d",time());
        $data = $this->site->getSitemapWebsiteList();
        if(!empty($data)){
            foreach($data as $v){
                $type_url = "http://www.101xd.com/detail?id={$v['id']}";
$xmlitem .= <<<XMLITEM
<url> 　　
<loc>{$type_url}</loc> 　　
<lastmod>{$time}</lastmod> 　　
<changefreq>weekly</changefreq> 　　
<priority>0.8</priority> 　　
</url>
XMLITEM;
            }
        }
        return $xmlitem;

    
    }
    public function index(){
        
        $xmload = $this->load();
        $xmltype = $this->outtype();
        $xmlproduct = $this->getproduct();
        $xmlwebsite = $this->getWebSite();
$xmloutput = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<urlset>
{$xmload}
{$xmltype}
{$xmlproduct}
{$xmlwebsite}
</urlset>
XML;

        $this->__p__['xmloutput'] = $xmloutput;
        unset($xmlitems);
    }

    public function __main__() {

        $this->index();
    
    }
}
