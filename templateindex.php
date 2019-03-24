<?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
   $user_id= $_SESSION['userid'];
   if (isset($_POST['category'])) {

    foreach($_POST['category'] as $check)

    $location = $check;
    echo $location;
   }

  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  
      <meta charset="UTF-8">
      <meta name="description" content="Ecommerce Home Page.Page is designed with basic HTML5 and CSS3">
      <meta name="author" content="Jobin George">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Ecommerce Home Page</title>
      <link rel="stylesheet" href="css/main.css">
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel="icon" href="images/ecomicon.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="search.js"></script>
  </head>
  <body>
          <div class="container-fluid">
        
              <header>
                  <nav class="navbar navbar-expand-lg bg-dark navbar-dark"  role = "navigation">
                      
                      <a class="navbar-brand" href="#">
                        <img src="images/mylogo.png" alt="logo" style="width:100px;">
                      </a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                              <span class="navbar-toggler-icon"></span>
                            </button>
                           
                    
                      <div class="collapse navbar-collapse" id="navbarSupportedContent">                    
                          <form class=" form-inline my-2 my-lg-0 ml-auto" method="post" action="displaysearch.php" >
                          <input class="form-control mr-sm-2" type="search" name="searchinput"   id="search" placeholder="Search" aria-label="Search" required>
                          <!-- <a   href="javascript:void(0);" name="searchbtn" id="searchbtn" type="submit" class="btn btn-outline-primary my-2 my-sm-0"  data-toggle="modal" data-target="#exampleModal">Search</a> -->
                          <button class="btn btn-outline-primary my-2 my-sm-0"  name="search" type="submit">Search</button>
                        </form>
                    
                      <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                          <a class="nav-link" href="login.html">Login<i class="fa fa-sign-in" aria-hidden="true"></i></a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout<i class="fa fa-power-off" aria-hidden="true"></i></i></a>
                          </li>
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
                          
                            
                              <div class="hero-image">
                                      <div class="hero-text">
                                        <h1>Welcome To Shopping</h1>
                                        <p>My Ecommerce Website</p>
                                      </div>
                              </div>
                            
                          
                    <div class="row mt-3">
                        
                          
                      <div class="col-sm-2 col-xs-4 col-md-3 aside-section ">
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
                      <!-- col-md-3 ends here -->
                    
                          <div class="col-sm-10 col-xs-3 col-md-9">
                          <div class="row">
                               <?php
            $stmt=$object->connect()->query("SELECT * FROM product");
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
                                               <?php } ?>
              </div>          
              </div>
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

</script>
  </body>
  </html>