<?php

class App {

    private $controller = "api"; //default controller
    private $method = "";

    public function __construct()
    {
        $url = $this->parseUrl();

        //if controller exists from first element of url array
        if (file_exists("../app/controllers/{$url[1]}.php"))
        {
            $this->controller = $url[1];
        }

        require_once "../app/controllers/{$this->controller}.php";

        //instantiate new controller
        $this->controller = new $this->controller();

        //get method
        if (isset($url[2]))
        {
            $this->method = $url[2];
            if (method_exists($this->controller, $this->method))
            {
                call_user_func([$this->controller, $this->method]);
            }
            else
            {
                echo "method does not exist! XML";
            }
        }
        else
        {
            echo "required method in url XML";
        }
    }

    public function parseUrl()
    {
        //explode url and remove any trailing /
        return $url = explode('/', filter_var(rtrim($_SERVER['PATH_INFO'], '/'), FILTER_SANITIZE_URL));
    }

}
