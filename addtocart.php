<?php
session_start();
require_once('dboconnection.php');
$object=new Dbh();


// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//   echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
// } else {
//   echo "Please log in first to see this page.";
// }

if(isset($_GET['id'])&&isset($_GET['uid'])== true)
  {
    $product_id=preg_replace('#[^0-9]#i','',$_GET['id']);
    $user_id=preg_replace('#[^0-9]#i','',$_GET['uid']);
   if($product_id==''||$user_id==''){
    header( "Location:login.php");
   }
  $res=$object->connect()->prepare("SELECT category_id FROM product where product_id= ? "); 
  $res->execute(array($product_id));
  $row = $res->fetch(PDO::FETCH_BOTH);
  $cat_id=$row['category_id'];
  $p_array=[
    'uid'=>$user_id,
    'cid' => $cat_id,
    'pid'=>$product_id
];
$stmt=$object->connect()->prepare("SELECT * FROM cart where user_id= ? AND product_id=?"); 
$stmt->execute(array($user_id,$product_id,));
if($stmt->rowCount()>0) 
{
  
header( "Location:index.php");
$result='<div class="alert alert-success"  role="alert">Thank You! I will be in touch</div>';
// echo '<script type="text/javascript">alert("Item already in the cart");</script>';
              
}
else{
  $sql="INSERT INTO cart (user_id,category_id,product_id)
         VALUES (:uid,:cid,:pid)";
         $query=$object->connect()->prepare($sql);
         $query->execute($p_array);
        

        

        if($query){
            header( "Location:cart.php?uid=.$user_id.");
      }
      

}
  

  }
 
?>

           