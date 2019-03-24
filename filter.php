<?php
 session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
  $user_id= $_SESSION['userid'];
  if (isset($_POST["key"])) {
    $query="SELECT * from product WHERE 1";
     if (isset($_POST['cat']) and isset($_POST['rid']))
    {
     $cat_string=implode("','",$_POST['cat']);
       //   join array with a string
       $ret_string=implode("','",$_POST['rid']);
    // //   join array with a string
       $query.=" AND category_id IN ('" .$cat_string . "') AND retailer_id IN  ('".$ret_string ."')" ;
    }
    
    
    
        if (isset($_POST['cat']))
        {
          $cat_string=implode("','",$_POST['cat']);
           //   join array with a string
       
       
          $query.=" AND category_id IN ('" .$cat_string . "')" ;
        }
        if (isset($_POST['rid']))
    {
    
      $ret_string=implode("','",$_POST['rid']);
    //   join array with a string
      $query.=" AND retailer_id IN  ('".$ret_string ."')" ;
    }

    $stmt=$object->connect()->query($query);
    $row=$stmt->rowCount();
    if($stmt->rowCount()>0){

    

 while ($row=$stmt->fetch()){ 
              $pid=$row['product_id'];
              $images='uploads/'.$row['product_image1'];
            ?>
            
                                      <div class="col-md-4 mt-3" >
                                          <div class="card" style="width: 18rem;">
                                              <div class="inner">
                                              <a href='productdetails.php?id=<?php echo $pid; ?>'><img   class="card-img-top"src="<?php echo $images;?>" alt="Card image cap"></a>
                                            </div>
                                              <div class="card-body">
                                              <center><h4 class="card-text"> <?php echo $row['product_name'];?></h4><center>
                                                <a href='addtocart.php?id=<?php echo $pid; ?>&amp;uid=<?php echo urlencode($user_id);   ?>' onclick="return alert('Item added to cart')" class="btn btn-outline-primary btn-lg btn-block">Add to cart</a>
                                              </div>
                                              </div>
                                              </div>          
                                               <?php }}
                                              else{
                                               echo" <div class='row'>";
                                               echo "<div class='col-md-12'>";
                                               
                                                echo "<img src='images/filter.gif' alt='' class='empty'>";
                                               
                                                echo "</div>";
                                                echo "</div>";
                                              }
                                               }?>
    
