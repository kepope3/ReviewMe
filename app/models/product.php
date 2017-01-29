<?php

class Product
{
    private $verb,$params;
    
    public function setParams($verb,$params)
    {
        $this->verb=$verb;
        $this->params=$params;
    }

}
