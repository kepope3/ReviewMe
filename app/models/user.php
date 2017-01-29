<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class user extends Eloquent
{
    public $timestamps = [];
    protected $fillable = ['usr_name','public_key'];
    
    public function permissions()
    {
        return $this->belongsToMany('permissions','usr_permissions',
                'fk2_id','fk1_id');
    }
    public function createUser($name,$public_key)
    {
        if ($this->where('name','=',$name)->first())
        {
            return null;
        }
        else
        {
            //create user
            
            //cannot perform action until permissions are set
        }
    }
    public function setUserPermissions()
    {
        
    }
    public function verifyUser($name,$public_key)
    {        
        $user = $this->where('name','=',$name)->first();
        /*if (password_verify($public_key, $user->public_key))
        {
            
        }*/
        if ($public_key==$user->public_key)
        {
        return $user;
        }
        else
        {
            return null;
        }
        
    }
    private function GenRndStr()
    {
        //include all numeric and alphbet chars + time
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321' . time();
        //get the length of the $character string
        $charactersLength = strlen($characters);
        $randomString = '';
        //loop through entire length of Characters string, picking random chars from characters string
        //and adding them to the randomstring variable
        for ($i = $charactersLength; $i > 0; $i--)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

