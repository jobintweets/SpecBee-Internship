<?php
session_start();
require_once('dboconnection.php');
$object=new Dbh();
if(isset($_GET['uid'])&&isset($_GET['cpid']))
{
    $user_id=preg_replace('#[^0-9]#i','',$_GET['uid']);
  $product_id=preg_replace('#[^0-9]#i','',$_GET['cpid']);
  echo $user_id;
  echo $product_id;
  $p_array=[
    'uid'=>$user_id,
    'pid' => $product_id
  
];

$res=$object->connect()->prepare("DELETE  FROM cart where user_id=? AND product_id=?"); 
$res->execute(array($user_id,$product_id));
// $row = $res->fetch(PDO::FETCH_BOTH);
if($res){
  
    header( "Location:cart.php?uid=.$user_id.");
  
}


}
?>