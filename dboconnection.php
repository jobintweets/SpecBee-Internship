<?php

class Dbh{
private $servername;
private $username;
private $password;
private $dbname;
private $charset;

function connect()
{
    $this->servername="localhost";
    $this->username="root";
    $this->password="root";
    $this->dbname="ecommerce";
    $this->charset="utf8mb4";

    try
    {
        $dsn="mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
        $dbConnection=new PDO($dsn,$this->username,$this->password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     
        return $dbConnection;


    }
    catch(PDOException $e)
    {
        echo "Connection failed :".$e->getMessage();
    }
}


}



?>  

