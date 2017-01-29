<?php

class api extends Controller
{
    private $user;
    public function __construct()
    {
        $this->set_params();
        $this->user = $this->model('user');        
    }
    public function review()
    {
        $product = $this->model('product');
        $product->setParams($this->verb,$this->params);
        $this->view("review/{$this->format}", $data=[]);
    }
    public function alterUser()
    {        
        //check credential params are present
        if (isset($this->params['usr_name'])&&isset($this->params['public_key']))
        {            
            switch($this->verb)
            {
                case 'GET': //get user details
                    $data = $this->user->verifyUser($this->params['usr_name'],
                            $this->params['public_key']);
                    $this->view("user_details/{$this->format}", $data);
                    break;                
                case 'PUT'://update                    
                    break;
                case 'DELETE': break;//delete
                case 'POST':                    
                    $data = $this->user->createUser($this->params['usr_name'],
                            $this->params['public_key']);
                    $this->view("create_user/{$this->format}", $data);
                    break;//create
            }
            
            
        }
        /*$this->user->create([
           'name' => 'keith',
            'public_key' => 'password'         
        ]);*/
        //$admin_per = $this->model('permissions')->find(1);
        //$keith = $this->user->find(1);
        //foreach ($keith->permissions as $p)
        //{
        //    echo $p->permission_name;
        //}
        //$keith->permissions()->attach($admin_per);
        
        
    }
    private function checkUser()
    {
        //check credential params are present
        if (isset($this->params['usr_name'])&&isset($this->params['public_key'])
                &&isset($this->params['secret_key']))
        {
            echo $userKeith = $this->user->where('usr_id','=','2')->first();
        }
    }
    
}

