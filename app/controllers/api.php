<?php

class api extends Controller {

    private $user;

    public function __construct()
    {
        $this->set_params();
        $this->user = $this->getModel('user');
    }

    public function review()
    {
        switch ($this->verb)
        {
            case 'GET':
                if (isset($this->params['usr_name']) && isset($this->params['public_key']) &&
                        $this->params['code_type'] && $this->params['code'])
                {
                    //check user exists
                    $user = $this->user->getUser($this->params['usr_name'], $this->params['public_key']);
                    if (is_null($user))
                    {
                        $data = USER_NOT_EXIST;
                    } else
                    {
                        //check user is admin
                        if ($user->usr_type->name == 'Admin')
                        {
                            if ($this->params['code_type'] == 'ASIN')
                            {
                                //check product exists
                                $p = $this->getModel('product');
                                $product = $p->getProduct_with_ASIN($this->params['code']);
                                
                                if (is_null($product))
                                {
                                    //check product exists on amazon
                                    $data = $p->getAmazonReview($this->params['code']);
                                    //insert rating on database                                    
                                }
                                
                            }
                        } else
                        {
                            $data = NOT_ADMIN;
                        }
                    }
                } else
                {
                    $data = '{"error":"missing param; ensure usr_name,public_key,'
                            . 'code_type,code are included"}';
                }
                $this->view("review/{$this->format}", $data);
                break;
        }
    }
    public function User()
    {
        switch ($this->verb)
        {
            case 'POST':
                $this->addUser();
                break; //create
            case 'DELETE':  //delete
                $this->deleteUser();
                break;
        }
    }

    private function deleteUser()
    {
        if (isset($this->params['usr_name']) && isset($this->params['public_key']))
        {
            $data = $this->user->deleteUser($this->params['usr_name'], $this->params['public_key']);
        } else
        {
            $data = '{"error":"missing param; ensure usr_name,'
                    . 'public_key are included"}';
        }
        $this->view("delete_user/{$this->format}", $data);
    }

    private function addUser()
    {

        if (isset($this->params['usr_type']) && isset($this->params['usr_name']) &&
                isset($this->params['admin_name']) && isset($this->params['admin_key']))
        {
            $usr_type = $this->getModel('usr_type');
            $usr_type = $usr_type->where('name', '=', $this->params['usr_type'])->first();
            if ($usr_type)
            {
                $this->params['usr_type'] = $usr_type->id;
                $data = $this->user->createUser($this->params);
            } else
            {
                $data = '{"error":"need valid user type"}';
            }
        } else
        {
            $data = '{"error":"missing param; ensure usr_type,usr_name,'
                    . 'admin_name,admin_key are included"}';
        }
        $this->view("create_user/{$this->format}", $data);
    }

}
