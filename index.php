<?php

header("Content-Type: application/json; charset=UTF-8");

require_once("src\Application.php");
$app = new Application();
$app->run();//Run 

?>
