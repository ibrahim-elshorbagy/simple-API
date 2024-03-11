<?php

//======= simple autoloading ===============//
spl_autoload_register(function($class){
    require __DIR__ . "/$class.php";
});
set_error_handler("Errorhandler::handelError");
set_exception_handler("ErrorHandler::handlerException");


class Application {

    public $database;
    public $gateway;
    public $controller;
    public $routing;

    public function __construct()
    {
    //========================= objects ===========================//

        $this->database   = new Database(); //start con
        $this->gateway    = new ProductGateway($this->database); //handling the data 
        $this->controller = new ProductController($this->gateway); //controller


    }
    //============================ Run ==========================//

    public function run()
    {
        $this->path();
    }

    //=================== Simple routing ===========================//
    public function path()
    {
        
        $path = explode('/',$_SERVER['REQUEST_URI']);
        
        switch($path[1])
        {
            case "products":

                $id = $path[2] ?? null;
                $this->controller->processRequest($_SERVER['REQUEST_METHOD'],$id);//Run 

            break;

            default:
            echo "Not Found";
            http_response_code(404);
            exit;

        }
    }

}