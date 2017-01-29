<?php

class Controller {

    protected $verb;
    protected $format = 'json';
    protected $params;

    public function set_params()
    {
        //get parameters
        parse_str($_SERVER['QUERY_STRING'], $this->params);
        if (isset($this->params['format']))
        {
            $this->format = $this->params['format'];
        }
        //get HTTP request method
        $this->verb = $_SERVER['REQUEST_METHOD'];
    }

    public function model($model)
    {
        require_once "../app/models/{$model}.php";
        return new $model();
    }

    public function view($view, $data)
    {
        require_once "../app/views/{$view}.php";
    }

}
