<?php

class info {

    public $time, $depth, $NoTags = 0;

}

class WebCrawler {

    private $depth = 1; //default depth
    private $iniURL = "";
    private $keyword = "";
    private $info;
    private $scannedUrl;
    private $urlIndex;

    function SetDepth($depth)
    {
        $this->depth = $depth;
    }

    function SetURL($url)
    {
        $this->iniURL = $url;
    }

    function SetKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    function GO()
    {
        //reset scannedurl
        unset($this->scannedUrl);
        $this->urlIndex = -1;
        $this->scannedUrl[0] = $this->iniURL;

        if ($this->iniURL == "" || $this->keyword == "")//url,keyword not set
        {
            echo "Ensure url and keyword is set";
            return;
        }

        //set info class
        $this->info = new info();
        //set depth
        $this->info->depth = $this->depth;
        //set time
        $this->info->time = date("h:i:sa Y/m/d");

        //1 deep
        $urlList[0] = $this->iniURL;
        $this->LoopList($urlList);

        if ($this->depth > 1)
        {
            //2 deep
            $urlList = $this->LinkFinder($this->iniURL);
            $this->LoopList($urlList);

            if ($this->depth > 2)
            {
                //3 deep
                foreach ($urlList as $url)
                {
                    $urlList1 = $this->LinkFinder($url);
                    $this->LoopList($urlList1);

                    if ($this->depth > 3)
                    {
                        //4 deep
                        foreach ($urlList1 as $url1)
                        {
                            $urlList2 = $this->LinkFinder($url1);
                            $this->LoopList($urlList2);

                            if ($this->depth > 4)
                            {
                                //5 deep
                                foreach ($urlList2 as $url2)
                                {
                                    $urlList3 = $this->LinkFinder($url2);
                                    $this->LoopList($urlList3);
                                    if ($this->depth > 5)
                                    {
                                        //6 deep
                                        foreach ($urlList3 as $url3)
                                        {
                                            $urlList4 = $this->LinkFinder($url3);
                                            $this->LoopList($urlList4);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function LoopList($urlList)
    {
        $dom = new DOMDocument('1.0');
        if ($urlList[0] != "")
        {
            foreach ($urlList as $url)
            {
                $foundUrl = false;
                foreach ($this->scannedUrl as $urlLookUp)//ensure url has not already been searched
                {
                    if ($url == $urlLookUp)
                    {
                        $foundUrl = true;
                    }
                }
                if (!$foundUrl)
                {
                    echo $url . "<br>";
                    $this->urlIndex++;
                    $this->scannedUrl[$this->urlIndex] = $url;
                    @$dom->loadHTMLFile($url); //load html into dom
                    //loop through all elements of dom
                    $this->TextFinder($dom, $url);
                }
            }
        }
    }

    private function LinkFinder($url)
    {
        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);
        $urlList[0] = "";
        $anchors = $dom->getElementsByTagName('a');
        $x = 0;
        foreach ($anchors as $element)
        {
            $href = $element->getAttribute('href');
            //if true then edit url to be compatible with loadHTMLFile
            //http://stackoverflow.com/questions/2313107/how-do-i-make-a-simple-crawler-in-php
            if (0 !== strpos($href, 'http'))
            {
                $path = '/' . ltrim($href, '/');
                if (extension_loaded('http'))
                {
                    $href = http_build_url($url, array('path' => $path));
                } else
                {
                    $parts = parse_url($url);
                    $href = $parts['scheme'] . '://';
                    if (isset($parts['user']) && isset($parts['pass']))
                    {
                        $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                    }
                    $href .= $parts['host'];
                    if (isset($parts['port']))
                    {
                        $href .= ':' . $parts['port'];
                    }
                    $href .= $path;
                }
            }
            $urlList[$x] = $href;
            $x++;
        }
        return $urlList;
    }

    public function GetInfo()
    {
        return $this->info;
    }

    private function TextFinder($dom, $url)
    {
        foreach ($dom->getElementsByTagName('*') as $element)
        {
            $content = $element->nodeValue;
            $tagName = $element->nodeName;
            if (preg_match("/" . $this->keyword . "/i", $content))
            {
                $this->info->NoTags++;
                $this->HandleReponse($url, $content, $tagName);
            }
        }
    }

    //virtual function
    function HandleReponse($url, $content, $tagName)
    {
        
    }

}
