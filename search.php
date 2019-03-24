<?php
 
  require_once('dboconnection.php');
  $object=new Dbh();

  if(isset($_POST['key']))
  {
$str=$_POST['key'];


$stmt=$object->connect()->prepare("SELECT * from product WHERE product_name LIKE '%$str%' OR product_brand LIKE '%$str%' OR product_model LIKE '%$str%' ");
$stmt->execute(array($str));
if($stmt->rowCount()>0)
{
   
while ($row=$stmt->fetch()){ 
$images='uploads/'.$row['product_image1'];
?>
     
      
          
       <div class="mt-3">
        <div class="card" style="width: 18rem;">
         <div class="inner">
         <a href='productdetails.php?id=<?php echo $pid; ?>'><img class="card-img-top"src="<?php echo $images;?>" alt="Card image cap"></a>
        </div>
         <div class="card-body">
        <center><h4 class="card-text"> <?php echo $row['product_name'];?></h4><center>
        <a href='addtocart.php?id=<?php echo $pid; ?>&amp;uid=<?php echo urlencode($user_id);?>' onclick="return alert('Item added to cart')" class="btn btn-outline-primary btn-lg btn-block">Add to cart</a>
        </div>
        </div>
        </div>
      
                   
<?php }
}
else{
    echo "no search results";
}

}
?>
