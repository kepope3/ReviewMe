<!DOCTYPE html>
<?php
require_once 'WebCrawler.php';

class CrawlDomain extends WebCrawler
{
    function HandleReponse($url, $content, $tagName,$key)
    {
        echo $url."<br>";        
        echo "tag name: ".$tagName."<br><br>";
        echo "key: {$key}<br><br>"; 
        echo $content."<br><br>";
        $this->endSearch=true;//will end and return only tags from this page
    }
    
}

$depth = 3;//$_GET['depth'];
$key[0] = "animal testing";
$key[1] = "human rights";
$key[2] = "weapon";
$key[3] = "environmental";
$urlfil = '';//only for 1st depth(find links of home)

$url = "http://gb.bicworld.com/";//$_GET['url'];


$crawlUrl = new CrawlDomain ();
$crawlUrl->SetDepth($depth);//1 to 6
$crawlUrl->SetURL($url);
$crawlUrl->SetKeyword($key);
$crawlUrl->SetURLFilter($urlfil);
$crawlUrl->SetTagFilter("");
$crawlUrl->GO();
