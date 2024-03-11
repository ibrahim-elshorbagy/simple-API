<?php

set_error_handler("Errorhandler::handelError");
set_exception_handler("ErrorHandler::handlerException");

class Errorhandler
{
    
    public static function handlerException(Throwable $exception)
    {

        http_response_code(500);

        $errorDetails = array(
            "message" => $exception->getMessage(), 
            "code" => $exception->getCode(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine() 
        );

        echo json_encode(array("error" => $errorDetails));

    }

    public static function handelError(int $errno,
        string $errstr,
        string $errfile,
        int $errline
        ):bool
        {
            throw new ErrorException( $errstr,0,$errno,$errfile,$errline);
        } 

}