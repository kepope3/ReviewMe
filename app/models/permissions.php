<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class permissions extends Eloquent
{
    public $timestamps = [];
    protected $fillable = ['permission_name'];
    
       
}

