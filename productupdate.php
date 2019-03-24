<?php
  session_start();
  require_once('dboconnection.php');
  $object=new Dbh();
  
  if(isset($_GET['id']))
  {
    $product_id=preg_replace('#[^0-9]#i','',$_GET['id']);
  
  $res=$object->connect()->prepare("SELECT * FROM product where product_id= ? "); 
  $res->execute(array($product_id));
  $row = $res->fetch(PDO::FETCH_BOTH);
  $cat_id=$row['category_id'];
  
  $query=$object->connect()->prepare("SELECT category_name FROM category where category_id= ? "); 
  $query->execute(array($cat_id));
  $row1 = $query->fetch(PDO::FETCH_BOTH);
  $cat_name=$row1['category_name'];
  }
 
  
  if(isset($_POST['update-product'])){
    echo '<script type="text/javascript">alert("product updated");</script>';
    try{
      $r_id=$_SESSION["retailerid"];
    
      $res=$object->connect()->prepare("SELECT retailer_approved FROM retailer where retailer_id= ? "); 
      $res->execute(array($r_id));
      $row = $res->fetch(PDO::FETCH_BOTH);
        if($row['retailer_approved']==0)
        {
          echo'<script type="text/javascript">alert("wait for approval from admin");</script>';
        }
        else{
   
          
         $pname=$_POST['name'];
         $model=$_POST['model'];
         $category=$_POST['category'];
         $brand=$_POST['brand'];
         $spec=$_POST['specification'];
         $price=$_POST['price'];
         $q=$_POST['quantity'];
         $i1=$_FILES['image1']['name'];
         $i2=$_FILES['image2']['name'];
      
         $i3=$_FILES['image3']['name'];
        
         $cat_query=$object->connect()->prepare("SELECT category_id FROM category where category_name= ? "); 
         $cat_query->execute(array($category));
         $row3 = $cat_query->fetch(PDO::FETCH_BOTH);
         $category_id=$row3['category_id'];
      $p_array=[
          'c'=>$category_id,
          'nm' => $pname,
          'b'=>$brand,
          'md'=>$model,
          'p'=>$price,
          's'=>$spec,
          'i1'=>$i1,
          'i2'=>$i2,
          'i3'=>$i3,
          'q'=>$q,
          'pid'=>$product_id
          ];
          
         
       
          
            $target1='uploads/' .$i1;
            $target2='uploads/' .$i2;
            $target3='uploads/' .$i3;
            if(move_uploaded_file($_FILES['image1']['tmp_name'], $target1) and move_uploaded_file($_FILES['image2']['tmp_name'], $target2)and move_uploaded_file($_FILES['image3']['tmp_name'], $target3))
            {
              $sql="UPDATE product SET category_id=:c,product_name=:nm,product_brand=:b,product_model=:md,
              product_price=:p,product_specification=:s,product_image1=:i1,product_image2=:i2,product_image3=:i3,product_quantity=:q WHERE product_id=:pid";
             
               $query=$object->connect()->prepare($sql);
               $query->execute($p_array);
      
               if($query){
                header( "Location:retailerpanel.php");
                echo '<script type="text/javascript">alert("Product Updated");</script>';
            }
            else{
                echo '<script type="text/javascript">alert("Failed to add product")</script>';
            }
      
            }
            else {
              echo "file uploading failed";
            }
             
              
              
             
             
             
          
      
        }

    }
    catch(PDOException $e)
  {
      echo "Database error :".$e->getMessage();
  }
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
                <meta charset="UTF-8">
                <meta name="description" content="Product Update Page.">
                <meta name="author" content="Jobin George">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Update Product</title>
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
    <h5 class="card-title">Update Product</h5>
    <h6 class="card-subtitle mb-2 text-muted">Reupload your images on update</h6>
    <form method="post" action="" enctype='multipart/form-data'>
                                   
                                   <div class="form-group ">
                                           <label for="product_name">Product Name</label>
                                           <input type="text" class="form-control" id="product_name" name="name" value="<?php echo $row['product_name'];?>" placeholder="Product Name" required>
                                         
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