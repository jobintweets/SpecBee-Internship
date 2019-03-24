
 <?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
  $user_id= $_SESSION['userid'];
  ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8">
                <meta name="description" content="Ecommerce Product details page.">
                <meta name="author" content="Jobin George">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Product Details</title>
                <link rel="stylesheet" href="css/productdetails.css">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            </head>
<body>
    <!-- <div class="container-fluid"> -->
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
                          <input class="form-control mr-sm-2" type="search" name="searchinput"   id="search" placeholder="Search" aria-label="Search" required>
                          <!-- <a   href="javascript:void(0);" name="searchbtn" id="searchbtn" type="submit" class="btn btn-outline-primary my-2 my-sm-0"  data-toggle="modal" data-target="#exampleModal">Search</a> -->
                          <button class="btn btn-outline-primary my-2 my-sm-0"  name="search" type="submit">Search</button>
                        </form>
                       
                        <ul class="nav navbar-nav ml-auto">
                          <li class="nav-item">
                            <a class="nav-link" href="login.html">Login<i class="fa fa-sign-in" aria-hidden="true"></i></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Signup<i class="fa fa-user-plus" aria-hidden="true"></i></a>
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
<div class="row mt-3">
<?php
if(isset($_GET['id']))
{
  $product_id=preg_replace('#[^0-9]#i','',$_GET['id']);


  $res=$object->connect()->prepare("SELECT * FROM product where product_id= ? "); 
  $res->execute(array($product_id));

            while ($row = $res->fetch(PDO::FETCH_BOTH)){ 
             
              $image1='uploads/'.$row['product_image1'];
              $image2='uploads/'.$row['product_image2'];
              $image3='uploads/'.$row['product_image3'];
            ?>
        <div class="card col-md-12">
           <div class="row">
            <div class="col-md-6">
               <figure><img src="<?php echo $image1;?>" alt="product" class="main-image" id="main-image"></figure>
               <div class=" row img-thumb">
                   <div class="col-md-4">
                    <figure><img src="<?php echo $image1;?>" alt="product" onclick="change_image(this)"></figure>
               
                </div>
                <div class="col-md-4">
                        <figure><img src="<?php echo $image2;?>" alt="product" onclick="change_image(this)"></figure>
                   
                    </div>
                    <div class="col-md-4">
                            <figure><img src="<?php echo $image3;?>" alt="product" onclick="change_image(this)"></figure>
                       </div>
                   
               
         </div>
            </div>
          
          
           
            <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-12 mt-5 fluid">
                           <div class="product-name">
                                <h2><?php echo $row['product_name'];?></h2>
                                <strike><h4>$1200</h4></strike>
                                <h5><?php echo $row['product_price'];?></h5>
                           </div>
                           <p  data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                               Product  Description
                           </p>
                              <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                    <?php echo $row['product_specification'];?>
                                    </div>
                                  </div>
                                  <p>  <?php echo $row['product_specification'];?></p>

                            <a href="#" class="btn btn-outline-primary btn-lg btn-block">Buy Now</a>  
                            <!-- <a href='https://www.payumoney.com/paybypayumoney/#/6211A59D203EDB9E6C8040CE45F88E18' class="btn btn-outline-primary btn-lg btn-block">Pay Now</a> -->
                            <a href='addtocart.php?id=<?php echo $product_id; ?>&amp;uid=<?php echo urlencode($user_id);   ?>' onclick="return alert('Item added to cart')" class="btn btn-outline-primary btn-lg btn-block">Add to cart</a>
                       </div>
                   </div>

                </div>
            
            </div>
            </div>
            <!-- card ends here -->
            <?php  }} ?>
</div>
<!-- the main row -->

    
                <footer>
                        <p class="category-label-text">Ecommerce By Jobin,All rights reserved 2019</p>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-rss"></a>
                 </footer>
                 
    <!-- </div> -->
    <script src="js/products.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>