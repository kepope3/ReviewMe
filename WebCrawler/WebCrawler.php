<?php

class WebCrawler {

    private $depth = 1; //default depth    
    private $iniURL = "";
    private $keyword = "";
    private $URLFilter = "";
    private $TagFilter = "";
    protected $endSearch;
    private $info;
    private $scannedUrl;
    private $urlIndex;
    ///////////////////////////
    ////INFO VARS/////////////
    ///////////////////////////
    private $noUrlsSearched;
    private $timeTaken;

    function GetNoUrlsSearched()
    {
        return $this->noUrlsSearched;
    }

    function SetTagFilter($filter)
    {
        $this->TagFilter = $filter;
    }

    function SetURLFilter($filter)
    {
        $this->URLFilter = $filter;
    }

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
        $this->endSearch = false;
        $this->scannedUrl = array(); //initialise array

        $this->noUrlsSearched = 0;

        $dom = new DOMDocument('1.0');

        if ($this->iniURL == "" || $this->keyword == "")//url,keyword not set
        {
            echo "Ensure url and keyword is set";
            return;
        }

        //1 deep

        $urlList[0] = $this->iniURL;
        $this->LoopList($urlList, $dom);

        ##############################
        #####Searching deeper#########
        ##############################
        if ($this->depth > 1)
        {
            //2 deep
            $urlList = $this->LinkFinder($this->iniURL, $dom);
            $this->LoopList($urlList, $dom);

            if ($this->depth > 2)
            {
                //3 deep
                foreach ($urlList as $url)
                {
                    $urlList1 = $this->LinkFinder($url, $dom);
                    $this->LoopList($urlList1, $dom);

                    if ($this->depth > 3)
                    {
                        //4 deep
                        foreach ($urlList1 as $url1)
                        {
                            $urlList2 = $this->LinkFinder($url1, $dom);
                            $this->LoopList($urlList2, $dom);

                            if ($this->depth > 4)
                            {
                                //5 deep
                                foreach ($urlList2 as $url2)
                                {
                                    $urlList3 = $this->LinkFinder($url2, $dom);
                                    $this->LoopList($urlList3, $dom);
                                    if ($this->depth > 5)
                                    {
                                        //6 deep
                                        foreach ($urlList3 as $url3)
                                        {
                                            $urlList4 = $this->LinkFinder($url3, $dom);
                                            $this->LoopList($urlList4, $dom);
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

    private function LoopList($urlList, $dom)
    {
        //if links found
        if ($urlList[0] != "")
        {
            foreach ($urlList as $url)
            {
                if (!$this->endSearch)
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
                        //echo $url . "<br>";
                        $this->urlIndex++;
                        $this->scannedUrl[$this->urlIndex] = $url;
                        @$dom->loadHTMLFile($url); //load html into dom
                        //loop through all elements of dom                    
                        $this->TextFinder($dom, $url);
                    }
                }
            }
        }
    }

    private function LinkFinder($url, $dom)
    {
        $urlList[0] = "";
        if (!$this->endSearch)
        {
            @$dom->loadHTMLFile($url);            
            $anchors = $dom->getElementsByTagName('a');
            $x = 0;
            foreach ($anchors as $element)
            {
                $href = $element->getAttribute('href');

                //if user wants to filter url with keyword
                if ($this->URLFilter != "")
                {
                    if (preg_match("/" . $this->URLFilter . "/i", $href))
                    {
                        $href = $this->FixUrl($href, $url);
                        $urlList[$x] = $href;
                        $x++;
                    }
                } else//add all urls
                {
                    $href = $this->FixUrl($href, $url);
                    $urlList[$x] = $href;
                    $x++;
                }
            }            
        }
        return $urlList;
    }

    //http://stackoverflow.com/questions/2313107/how-do-i-make-a-simple-crawler-in-php
    private function FixUrl($href, $url)
    {
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
        return $href;
    }

    public function GetInfo()
    {
        return $this->info;
    }

    private function TextFinder($dom, $url)
    {
        $this->noUrlsSearched++;
        //echo "<br>" . $url;
        $tagFilter = '*';
        if ($this->TagFilter != "")
        {
            $tagFilter = $this->TagFilter;
        }
        foreach ($dom->getElementsByTagName($tagFilter) as $element)
        {
            $content = $element->nodeValue;
            $tagName = $element->nodeName;
            foreach ($this->keyword as $key)
            {
                if (preg_match("/" . $key . "/i", $content))
                {
                    $this->HandleReponse($url, $content, $tagName, $key);
                }
            }
        }
    }

    //virtual function
    function HandleReponse($url, $content, $tagName, $key)
    {
        
    }

}
