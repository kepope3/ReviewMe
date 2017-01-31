<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class usr_type extends Eloquent
{
    protected $table = 'usr_type';
    public $timestamps = [];
    protected $fillable = ['type_name'];
    
       
}

