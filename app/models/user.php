<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class user extends Eloquent {

    public $timestamps = [];
    protected $fillable = ['name', 'public_key', 'fk1_id'];

    public function usr_type()
    {
        return $this->hasOne('usr_type', 'id', 'fk1_id');
    }

    public function createUser($params)
    {
        $createUser = false;

        //only admin can create new user
        if (isset($params['admin_name']) && isset($params['admin_key']))
        {
            //verify admin
            $admin = $this->getUser($params['admin_name'], $params['admin_key']);
            if (!is_null($admin))
            {
                if ($admin->usr_type->name == 'Admin')
                {
                    $createUser = true;
                }
            } else
            {
                return '{"error":"need valid admin to create user"}';
            }
        }
        //check if user already exists
        $usr = $this->where('name', '=', $params['usr_name'])->first();
        if (is_null($usr) && $createUser)
        {
            //get public key
            $publicKey = sha1($this->GenRndStr());
            //hash public key
            $privateKey = password_hash($publicKey, PASSWORD_DEFAULT);
            //create user
            $this->create([
                'name' => $params['usr_name'],
                'public_key' => $privateKey,
                'fk1_id' => $params['usr_type']
            ]);
            return '{"msg":"user created","user name":"' . $params['usr_name'] . '"'
                    . ',"public key":"' . $publicKey . '"}';
        } else
        {
            return USER_EXISTS;
        }
    }
    public function deleteUser($name, $public_key)
    {
        $user = $this->getUser($name, $public_key);
        if (!is_null($user))
        {
            $user->delete();
            return '{"msg":"user deleted","user name":"' . $name . '"'
                    . ',"public key":"' . $public_key . '"}';
        }
        else
        {
            return USER_NOT_EXIST;
        }
    }
    public function getUser($name, $public_key)
    {
        $user = $this->where('name', '=', $name)->first();
        if ($user && password_verify($public_key, $user->public_key))
        {
            return $user;
        } else
        {
            return null;//'{"error":"user does not exist"}';
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
