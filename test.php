<!-- <?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
  $user_id= $_SESSION['userid'];
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="search.js"></script>
</head>
<body>
<div class="row mt-3">
                        
                          
                        <div class="col-sm-2 col-xs-4 col-md-12 aside-section ">
                                <aside>
                                <?php
                                 $query = $object->connect()->prepare("SELECT user_name FROM user where user_id=?");
                                 $query->execute(array($user_id));
                                 $row1 = $query->fetch(PDO::FETCH_BOTH);
                                 $name=$row1['user_name'];
                                 echo "<h3>Hello ". $name . "</h3>";
                                 ?>
                              <div class="prooduct-filter-header">
                             
                                    <h5>Filter out Products</h5>
                              </div>
                              <?php
                              $stmt2=$object->connect()->query("SELECT * FROM category");
                              while ($row=$stmt2->fetch()){ 
                               
                              ?> 
                              <ul>
                              
                                  <li><input type="checkbox"   class="category filter"  value="<?php echo $row['category_id'];?>" ><?php echo $row['category_name'];?> </li>
                                
                              </ul>
                              <?php } ?>
                              <div class="prooduct-filter-header">
                                    <h5>Choose Sellers</h5>
                              </div>
                              <?php
                              $stmt3=$object->connect()->query("SELECT retailer_shop_name FROM retailer");
                              while ($row=$stmt3->fetch()){ 
                              ?>
                              
                              <form action="" id="form" method="post">
                              <ul>
                               <li><input type="checkbox"  class="sellers filter" value="<?php echo $row['retailer_id'];?>"> <?php echo $row['retailer_shop_name'];?></li>
                                    </ul>
                                <?php } ?>
                                </form>
                            </aside>
                        </div>
                      
                       
                      
                       
                       
                          
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                       
                        <div class="filterdata row "></div>
                        </div>
                        </div>
</body>
</html> -->