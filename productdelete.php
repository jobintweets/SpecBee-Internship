<?php
session_start();
require_once('dboconnection.php');
$object=new Dbh();
if(isset($_GET['id']))
{
  $product_id=preg_replace('#[^0-9]#i','',$_GET['id']);
 

$res=$object->connect()->prepare("DELETE  FROM product where product_id=?"); 
$res->execute(array($product_id));
// $row = $res->fetch(PDO::FETCH_BOTH);
if($res){
    header( "Location:retailerpanel.php");
}


}


?>