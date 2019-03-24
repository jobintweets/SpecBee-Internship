<?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
   $user_id= $_SESSION['userid'];
   if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:forbidden.html');
    exit;
  }
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="description" content="Search Results ">
      <meta name="author" content="Jobin George">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Search Results</title>
      <link rel="stylesheet" href="css/search.css">
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel="icon" href="images/ecomicon.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="filtertest.js"></script>
     
       

    </head>
  <body>
          <div class="container-fluid">
        
              <header>
                  <nav class="navbar navbar-expand-lg bg-dark navbar-dark"  role = "navigation">
                      
                      <a class="navbar-brand" href="index.php">
                        <img src="images/mylogo.png" alt="logo" style="width:100px;">
                      </a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                              <span class="navbar-toggler-icon"></span>
                            </button>
                    
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">                    
                      <form class=" form-inline my-2 my-lg-0 ml-auto" method="post" action="displaysearch.php" >
                          <input class="form-control mr-sm-2" type="search" name="searchinput" id="search" placeholder="Search" aria-label="Search">
                          <!-- <a   href="javascript:void(0);" name="searchbtn" id="searchbtn" type="submit" class="btn btn-outline-primary my-2 my-sm-0"  data-toggle="modal" data-target="#exampleModal">Search</a> -->
                          <button class="btn btn-outline-primary my-2 my-sm-0"  name="search" type="submit">Search</button>
                        </form>
                      <ul class="nav navbar-nav ml-auto">
                      <?php
                    if (isset($_SESSION['userid'])) {
                     echo '<li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout<i class="fa fa-power-off" aria-hidden="true"></i></i></a>
                          </li>';
                    }
                    else{
                      echo'<li class="nav-item">
                      <a class="nav-link" href="login.php">Login<i class="fa fa-sign-in" aria-hidden="true"></i></a>
                    </li>';
                    }
                    ?>
                        <!-- <li class="nav-item">
                          <a class="nav-link" href="login.html">Login<i class="fa fa-sign-in" aria-hidden="true"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout<i class="fa fa-power-off" aria-hidden="true"></i></i></a>
                          </li> -->
                        <li class="nav-item">
                          <a class="nav-link" href='cart.php?uid=<?php echo $user_id;?>'><span class='badge badge-warning'> 
                          <?php
                               $query = $object->connect()->prepare("SELECT * FROM cart where user_id=?");
                               $query->execute(array($user_id));
                               echo $query->rowCount();
                                   ?> </span><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></a>
                        </li>
                      </ul>
                  </div>
                    </nav>
                    <span class="glyphicon glyphicon-asterisk"></span>
              </header>
    
                      <div class="main-container">
                          
                          
                          
                    <div class="row mt-3">
                    
                   
                      <!-- <div class="col-sm-2 col-xs-4 col-md-3 aside-section">
                              <aside>
                            <div class="prooduct-filter-header">
                                  <p>Filter out Products</p>
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
                                  <p>Choose Sellers</p>
                            </div>
                            <?php
                            $stmt3=$object->connect()->query("SELECT * FROM retailer");
                            while ($row=$stmt3->fetch()){ 
                            ?>
                            <ul>
                            <li><input type="checkbox"  class="sellers filter" value="<?php echo $row['retailer_id'];?>"> <?php echo $row['retailer_shop_name'];?></li>
                                  </ul>
                              <?php } ?>
                          </aside>
                      </div> -->
                      <!-- col-md-3 ends here -->
                     
                          <div class="col-sm-10 col-xs-3 col-md-12">
                          <!-- <div class="filterdata row"></div> -->
                          <div class="row">
                          <?php
                            if(isset($_POST['search'])){
                                $str=$_POST['searchinput'];
                               if($str==''){
                                echo"<div class='card col-md-12'>";
                                echo "<img src='images/no_result.gif' alt='' class='empty'>";
                                echo "</div>";
                               }
                              
                               else{


                               
                               
                                $stmt=$object->connect()->prepare("SELECT * from product WHERE product_name LIKE '%$str%' OR product_brand LIKE '%$str%' OR product_model LIKE '%$str%' ");
                         $stmt->execute(array($str));
                         if($stmt->rowCount()>0)
                         {
                            while ($row = $stmt->fetch(PDO::FETCH_BOTH))
                            { 
                              
                                $product_id=$row['product_id'];
                           
                            $query=$object->connect()->prepare("SELECT * FROM product where product_id= ? "); 
                             $query->execute(array($product_id));
                             $row1 = $query->fetch(PDO::FETCH_BOTH);
                            $images='uploads/'.$row1['product_image1'];
                            $cartproductid=$row1['product_id'];
                            ?>
                          
                          
                       
                         
                       
                           
                           
                              <div class="col-md-4">
                                <figure><img src="<?php echo $images;?>" alt="product-image" class="product-image"></figure>
                            </div>
                            <div class="col-md-4">
                            <div class="product-name">
                                    <h3> <?php echo $row1['product_name'];?></h3>
                                </div>
                                <div class="product-description">
                                <p  data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                               Product  Description
                           </p>
                              <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                    <?php echo $row1['product_specification'];?>
                                    </div>
                                  </div>
                                    <p>
                                       
                                    <?php echo $row1['product_specification'];?>
                                    </p>
                                </div>
                                <div class="product-price">
                                        <strike> <h5>$2100</h5></strike>
                                  <h4>  <?php echo $row1['product_price'];?></h4>
                                </div>
                            </div>
                            <div class="col-md-4 mt-5">
                           
                                      <div class="twobuttons">
                                      <a href='addtocart.php?id=<?php echo  $product_id; ?>&amp;uid=<?php echo urlencode($user_id);   ?>' onclick="return alert('Item added to cart')" class="btn btn-outline-primary btn-lg btn-block">Add to cart</a>
                                            <a href='removefromcart.php?uid=<?php echo $user_id; ?>&amp;cpid=<?php echo urlencode ($cartproductid);?>'class="btn btn-outline-danger btn-lg btn-block" onclick="return confirm('Remove Product From Cart?')">Remove</a>
                                      </div>
                                    
                            </div>
                           
                          
                            <!-- another row -->
                    <?php }}
                     else {
                      echo"<div class='card col-md-12'>";
                      echo "<img src='images/no_result.gif' alt='' class='empty'>";
                      echo "</div>";
                  } }
                
                // else of no results ends here
              }

                // main if  ends here
               
                ?>
                                  
                    
             </div> 
             <!-- col-md-9 ends here          -->
              </div>
              <!-- sub row ends here -->
              </div>
              
              </div>
                    <footer>
                        <p class="category-label-text">Ecommerce By Jobin,All rights reserved 2019</p>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-rss"></a>
                </footer>
                      </div>
                    
                      
                    </div>
                  
                    
                   
                    
      </div>
     
    


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Search Results</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
        
      <center><div id="search_result"></div></center>
     
        
    
      </div>
      
    </div>
  </div>
</div>
  </body>
  </html>