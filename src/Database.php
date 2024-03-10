<?php

class Database
{   
    /*
    
    con to database
    */
    
    private $host = 'localhost';
    private $name = 'product_db';
    private $user = 'root';

    public function getConnection(){
            try {
            $db = new PDO("mysql:host=$this->host;dbname=$this->name;charset=utf8", $this->user);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES ,false);
            $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES ,false);
            return $db;
        } 
        catch (PDOException $e) 
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}