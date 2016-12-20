<!DOCTYPE html>
<?php
require_once 'WebCrawler.php';

class CrawlDomain extends WebCrawler
{
    function HandleReponse($url, $content, $tagName)
    {
        echo $url."<br>";
        echo $content."<br><br>";
        echo "tag name: ".$tagName."<br><br>";
    }
    
}

$crawlUrl = new CrawlDomain ();
$crawlUrl->SetDepth(3);//1 to 6
$crawlUrl->SetURL("http://www.loreal.com/");
$crawlUrl->SetKeyword("weapon");
$crawlUrl->GO();

$info = $crawlUrl->GetInfo();
echo $info->NoTags;