<?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
  
  if(isset($_POST['action']))
  {
    if(isset($_POST['product_id'])&&isset($_POST['quantity']))
    {
      $data=[
        'q'=>$_POST['quantity'],
        'pid'=>$_POST['product_id']
      ];
    
// $cartid=intval($_GET['cid']);


$res=$object->connect()->prepare("UPDATE  cart set quantity=:q where product_id=:pid "); 
            $res->execute($data);
// $q=$object->connect()->prepare("SELECT * FROM product where product_id= ? AND retailer_id= ?  "); 
//             $q->execute(array($catsid,$retsid));
    
// $row5 = $q->fetch(PDO::FETCH_BOTH);

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
                <meta charset="UTF-8">
                <meta name="description" content="Product Checkout Page.">
                <meta name="author" content="Jobin George">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Check Out</title>
                <link rel="stylesheet" href="css/retailerpanel.css">
                <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
               <link rel="icon" href="images/rtailericon.png">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
                <script src="bootstrap/js/bootstrap.min.js"></script>
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
                            <form class=" form-inline my-2 my-lg-0 ml-auto">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                          </form>
                       
                        <ul class="nav navbar-nav ml-auto">
                         
                         
                          <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout<i class="fa fa-power-off" aria-hidden="true"></i></i></a>
                          </li>
                        </ul>
                    </div>
                      </nav>
                      <span class="glyphicon glyphicon-asterisk"></span>
                </header>
                


<div class="card" style="width: 50%;margin-left:25%;">
  <div class="card-body">
    <h5 class="card-title">Checkout</h5>
    <!-- <h6 class="card-subtitle mb-2 text-muted">Reupload your images on update</h6> -->
    <form method="post" action="" enctype='multipart/form-data'>
                                   
                                   <div class="form-group ">
                                           <label for="product_name">Product Name</label>
                                           <input type="text" class="form-control" id="product_name" name="name" value="<?php echo $row5['product_name'];?>" placeholder="Product Name" required>
                                         
                                         </div>
                                         <div class="form-group">
                                               <label for="product_model">Model</label>
                                               <input type="text" class="form-control" id="product_model" name="model" value="<?php echo $row['product_model'];?>" placeholder="Enter product model"  required>
                                          </div>
                                          <div class="form-group ">
                          <label for="product_category">Category</label>
                          <select class="mdb-select" id="product_category" name="category">
                         
                            <?php
                            $query1="SELECT * FROM category";
                            $stmt=$object->connect()->query($query1);
                           
                            while ($row2=$stmt->fetch()){
                             echo "<option>" . $row2['category_name'] . "</option>";
              
                          }
                      ?>
                             
                            </select>
                            <script type="text/javascript">
                            document.getElementById('product_category').value='<?php echo $cat_name;?>';
                    
                            </script>
                            
                          </div>
                                         
                                             <div class="form-group ">
                                                   <label for="product_brand">Brand</label>
                                                   <input type="text" class="form-control" id="product_brand" name="brand" value="<?php echo $row['product_brand'];?>"  placeholder="Product Brand"  required>
                                                 </div>
                                         
                                             <div class="form-group ">
                                                   <label for="product_specificaton">Specifications</label>
                                                   
                                                   <textarea class="form-control" id="product_specificaton"  name="specification" required><?php echo $row['product_specification'];?></textarea>
                                                  
                                               </div>
                                               <div class="form-group ">
                                                   <label for="product_price">Price</label>
                                                   
                                                   <input type="text" class="form-control" id="product_price" value="<?php echo $row['product_price'];?>"  name="price" required>
                                                  
                                               </div>
                                  
                            
                             <div class="form-group">
                                   <label for="product_quantity">Quantity</label>
                                   <input type="number"   min="0" class="form-control" id="product_quantity" value="<?php echo $row['product_quantity'];?>" name="quantity"  required>
                                 </div>
                            
                        
                             <div class="form-group">
                                 <label for="product_image_1"> Product Image 1</label>
                                 <input type="file" class="form-control" id="product_image_1" name="image1"  value="<?php echo $row['product_image1'];?>" required>
                             </div>
                             <div class="form-group">
                                 <label for="product_image_2"> Product Image 2</label>
                                 <input type="file" class="form-control" id="product_image_2" name="image2" value="<?php echo $row['product_image2'];?>" required>
                             </div>
                             <div class="form-group">
                                 <label for="product_image_3"> Product Image 1</label>
                                 <input type="file" class="form-control" id="product_image_3" name="image3" value="<?php echo $row['product_image3'];?>" required>
                             </div>
                           
                           
                             <button type="submit" class="btn btn-primary btn-lg btn-block" name="update-product">Update Product</button>
                           </form>
     
   
  </div>
  <!-- card body  -->
</div>
<!-- card -->
    



                <footer>
                        <p class="category-label-text">Ecommerce By Jobin,All rights reserved 2019</p>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-rss"></a>
                 </footer>
                 
</div>   
<!-- container div    -->
</body>
</html>