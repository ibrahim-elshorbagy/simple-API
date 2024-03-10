<?php

declare(strict_types=1);

    //======= simple autoloading ===============//

spl_autoload_register(function($class){
    require __DIR__ . "/src/$class.php";
});
set_error_handler("Errorhandler::handelError");
set_exception_handler("ErrorHandler::handlerException");


$data= file_get_contents("https://official-joke-api.appspot.com/random_joke");

header("Content-Type: application/json; charset=UTF-8");



    //======= simple routing only work with /products ===============//

$parts = explode('/',$_SERVER['REQUEST_URI']);

    if($parts[1]!='products')
        {
            http_response_code(404);
            exit;
        }

    $id = $parts[2] ?? null;

    //========================= object ===========================//

$database = new Database(); //start con
$gateway = new ProductGateway($database); //handling the data 
$controller = new ProductController($gateway); //controller

    //========================= Run ===========================//

$controller->processRequest($_SERVER['REQUEST_METHOD'],$id);//Run 
?>
