<?php
session_start();
require_once('dboconnection.php');
$url="http://localhost:8888/a/retailerpanel.php";
if(!isset($_SERVER['HTTP_REFERER'])){
  // redirect them to your desired location
  header('location:forbidden.html');
  exit;
}
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
 


if(isset($_POST['add-product']))
{
  
  
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
   
    $category_id=0;
    $query="SELECT * FROM category";
 $stmt=$object->connect()->query($query);
  while ($row=$stmt->fetch()){
 if($_POST['category']==$row['category_name']){
   $category_id=$row['category_id'];
// fetching the category id
// retailer_id will be passed through session
// product addition validation is done her
        }
        
   }
     
   

   $pname=$_POST['name'];
   $model=$_POST['model'];
  //  $category=$_POST['category'];
   $brand=$_POST['brand'];
   $spec=$_POST['specification'];
   $price=$_POST['price'];
   $q=$_POST['quantity'];
   $i1=$_FILES['image1']['name'];
   $i2=$_FILES['image2']['name'];

   $i3=$_FILES['image3']['name'];
   $p_array_select=[
    'cid'=>$category_id,
    'rid'=>$r_id,
    'pn'=>$pname,
    'b'=>$brand,
    'm'=>$model,
    's'=>$spec
];

$p_array=[
    'c'=>$category_id,
    'rid'=>$r_id,
    'nm' => $pname,
    'b'=>$brand,
    'md'=>$model,
    'p'=>$price,
    's'=>$spec,
    'i1'=>$i1,
    'i2'=>$i2,
    'i3'=>$i3,
    'q'=>$q
    ];
    $query = $object->connect()->prepare("SELECT * FROM product WHERE category_id=? AND retailer_id=? AND product_name=? AND product_brand=? AND product_model=? AND product_specification=? ");
    $query->execute(array($category_id,$r_id,$pname,$brand,$model,$spec));
    $row = $query->fetch(PDO::FETCH_BOTH);
    if($query->rowCount()>0) 
    {
// header( "Location:adminpanel.php");
  echo '<script type="text/javascript">
    alert("Product already exists");
        </script>';
    }
    else
    {
      $target1='uploads/' .$i1;
      $target2='uploads/' .$i2;
      $target3='uploads/' .$i3;
      if(move_uploaded_file($_FILES['image1']['tmp_name'], $target1) and move_uploaded_file($_FILES['image2']['tmp_name'], $target2)and move_uploaded_file($_FILES['image3']['tmp_name'], $target3))
      {
        $sql="INSERT INTO product (category_id,retailer_id,product_name,product_brand,product_model,
        product_price,product_specification,product_image1,product_image2,product_image3,product_quantity)
         VALUES (:c,:rid,:nm,:b,:md,:p,:s,:i1,:i2,:i3,:q)";
         $query=$object->connect()->prepare($sql);
         $query->execute($p_array);

         if($query){
          echo '<script type="text/javascript">alert("Product Added")</script>';
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
  }
  // try block

  catch(PDOException $e)
  {
      echo "Database error :".$e->getMessage();
  }

  
// $object1->add_product($r_id, $category_id,$pname, $model,$brand,$specification,$price, $quantity,$image1, $image2,$image3);

}
// if button press
?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8">
                <meta name="description" content="Retailers admin panel.">
                <meta name="author" content="Jobin George">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Retailer Page</title>
                <link rel="stylesheet" href="css/retailerpanel.css">
                <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
                <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
               <link rel="icon" href="images/rtailericon.png">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script>
                  
</script>
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

                <div class="row mt-5">
                        <div class="col-md-3">
                                <div class="card border-warning mb-3">
                                        <div class="card-header retailer-header">
                                        <?php echo "<h3>" . $_SESSION["retaileremail"] ."</h3>";?> 
                                        </div>
                                        <div class="card-body text-primary">
                                                <button type="button" class="btn btn-outline-warning btn-lg btn-block"><i class="fa fa-home" aria-hidden="true"></i>Home</button>
                                                <button type="button" class="btn btn-outline-warning btn-lg btn-block" data-toggle="modal" data-target="#add_new_product"><i class="fa fa-plus" aria-hidden="true"></i>Add product</button>
                                                <button type="button" class="btn btn-outline-warning btn-lg btn-block"><i class="fa fa-shopping-bag" aria-hidden="true"></i>Ordered Products</button>
                                        </div>
                                      </div>
                        </div>
                        <cdiv class="col-md-9">
                           <div class="row">
                               <div class="col-md-4">
                                    <div class="card text-center text-white bg-danger mb-3" >
                                            <div class="card-body">
                                              <h5 class="card-title">Number Of Orders</h5>
                                              <p class="card-text">10789</p>
                                             
                                            </div>
                                          </div>   
                               </div>
                               <div class="col-md-4">
                                    <div class="card text-center text-white bg-danger mb-3" >
                                            <div class="card-body">
                                              <h5 class="card-title">Number Of Products</h5>
                                              <p class="card-text">52300</p>
                                             
                                            </div>
                                          </div>   
                               </div>
                               <div class="col-md-4">
                                    <div class="card text-center text-white bg-danger mb-3" >
                                            <div class="card-body">
                                              <h5 class="card-title">Total Sales</h5>
                                              <p class="card-text">$54789</p>
                                             
                                            </div>
                                          </div>   
                               </div>
                           </div>
                           <div class="row">
                             
           <?php
            $r_id=$_SESSION["retailerid"];
            
            $stmt=$object->connect()->prepare("SELECT * FROM product where retailer_id=? ");
            $stmt->execute(array($r_id));
            while ($row=$stmt->fetch()){ 
              $pid=$row['product_id'];
              $images='uploads/'.$row['product_image1'];
            ?>
           
              
                <div class="col-md-4 mt-3">
           
                <div class="card" style="width: 18rem;">
                    <div class="inner">
                   <img class='card-img-top' src="<?php echo $images;?>" alt='Card image cap'>
               </div>
                    <div class="card-body">
                     <center><h4 class="card-text"> <?php echo $row['product_name'];?></h4><center>
                     <a href='productupdate.php?id=<?php echo $pid; ?>'   class="btn btn-outline-success btn-lg btn-block">Update</a>
                     <a href='productdelete.php?id=<?php echo $pid; ?>' onclick="return confirm('Are you sure?')" class="btn btn-outline-danger btn-lg btn-block"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
                
                
                       <!-- <button type="button" name="remove" class="btn btn-outline-danger btn-lg btn-block">Remove</button> -->
            </div>
            </div>
            </div>
                

            <?php } ?>
           
           
           
           
           
              
     
        </script>
        
    
         
          
                     
            </div>
            <!-- row ends here -->
                        </div>
                        <!-- column ends here -->
                    </div>
                    <!-- main row ends here -->
                   
    
                <footer>
                        <p class="category-label-text">Ecommerce By Jobin,All rights reserved 2019</p>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-rss"></a>
                 </footer>
              
                  
</div>

  
  <!-- Modal -->
  <div class="modal fade" id="add_new_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Add New Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="" enctype='multipart/form-data'>
                                   
                <div class="form-group ">
                        <label for="customer_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="name" placeholder="Product Name" required>
                      
                      </div>
                      <div class="form-group">
                            <label for="product_model">Model</label>
                            <input type="text" class="form-control" id="product_model" name="model" placeholder="Enter product model"  required>
                       </div>
                       <div class="form-group ">
                          <label for="product_category">Category</label>
                          <select class="mdb-select" id="product_category" name="category">
                         
                            <?php
                            $query1="SELECT * FROM category";
                            $stmt=$object->connect()->query($query1);
                           
                            while ($row=$stmt->fetch()){
                             echo "<option>" . $row['category_name'] . "</option>";
              
                          }
                      ?>
                             
                            </select>
                          </div>
                          <div class="form-group ">
                                <label for="product_brand">Brand</label>
                                <input type="text" class="form-control" id="product_brand" name="brand" placeholder="Product Brand"  required>
                              </div>
                      
                          <div class="form-group ">
                                <label for="product_specificaton">Specifications</label>
                                
                                <textarea class="form-control" id="product_specificaton"  name="specification" required></textarea>
                               
                            </div>
                            <div class="form-group ">
                                <label for="product_price">Price</label>
                                
                                <input type="text" class="form-control" id="product_price"  name="price" required>
                               
                            </div>
               
         
          <div class="form-group">
                <label for="product_quantity">Quantity</label>
                <input type="number"   min="0" class="form-control" id="product_quantity" name="quantity"  required>
              </div>
         
     
          <div class="form-group">
              <label for="product_image_1"> Product Image 1</label>
              <input type="file" class="form-control" id="product_image_1" name="image1"   required>
          </div>
          <div class="form-group">
              <label for="product_image_2"> Product Image 2</label>
              <input type="file" class="form-control" id="product_image_2" name="image2"  required>
          </div>
          <div class="form-group">
              <label for="product_image_3"> Product Image 1</label>
              <input type="file" class="form-control" id="product_image_3" name="image3"  required>
          </div>
        
        
          <button type="submit" class="btn btn-primary btn-lg btn-block" name="add-product">Add Product</button>
        </form>
        </div>
        <!-- <div class="modal-footer">
         
        </div> -->
      </div>
    </div>
  </div>
<!-- main container ends here -->



    <script src="js/products.js"></script>



</body>
</html>
