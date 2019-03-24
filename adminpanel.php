<?php
session_start();
require_once('dboconnection.php');
require_once ('signup.class.php');

$object=new Dbh();
if(!isset($_SERVER['HTTP_REFERER'])){
  // redirect them to your desired location
  header('location:forbidden.html');
  exit;
}
if(isset($_POST['add-category'])){
  $obj=new addCategory();
  $category_name=ucfirst($_POST['category-name']);
  
  $obj->add_category($category_name);
}

if(isset($_REQUEST['cancelid']))
  {
$cid=intval($_GET['cancelid']);
$status=0;
$res=$object->connect()->prepare("UPDATE  retailer SET retailer_approved=? WHERE retailer_id=?"); 
$res->execute(array($status,$cid));
if($res){
  header( "Location:adminpanel.php");
}

}
if(isset($_REQUEST['apid']))
  {
$cid=intval($_GET['apid']);
$status=1;
$res=$object->connect()->prepare("UPDATE  retailer SET retailer_approved=? WHERE retailer_id=?"); 
$res->execute(array($status,$cid));
if($res){
  header( "Location:adminpanel.php");
}

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce admin Page.Admin can approve new retailers add categories.">
    <meta name="author" content="Jobin George">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/adminpanel.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="icon" href="images/adminicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div class="container-fluid">

        <header>
            <nav class="navbar navbar-expand-lg  bg-dark navbar-dark" role="navigation">
                
                <a class="navbar-brand" href="#">
                <img src="images/mylogo.png" alt="logo" style="width:100px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">                    
                <form class=" form-inline my-2 my-lg-0 ml-auto" action="adminpanel.php" method="post">
                    <input class="form-control mr-sm-2" type="search" name="searchval" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary my-2 my-sm-0" name="searches" type="submit">Search</button>
                  </form>
               
                <ul class="nav navbar-nav ml-auto">
                  
                  <li class="nav-item">
                    <a class="nav-link" href="login.html">Logout<i class="fa fa-power-off" aria-hidden="true"></i></a>
                  </li>
                </ul>
                </div>
              </nav>
           
        </header>
    
        <div class="row mt-5">
            <div class="col-md-3">
                    <div class="card border-warning mb-3">
                            <div class="card-header">Hello  <?php echo "<h3>" . $_SESSION["adminname"] ."</h3>";?></div>
                            <div class="card-body text-primary">
                                    <a  href="#retailers" class="btn btn-outline-warning btn-lg btn-block">Retailers</a>
                                    <button type="button" class="btn btn-outline-warning btn-lg btn-block">Users</button>
                                    <button type="button"data-toggle="modal" data-target="#addcategories" class="btn btn-outline-warning btn-lg btn-block">Add categories</button>
                            </div>
                          </div>
            </div>
            <div class="col-md-9">
               <div class="row">
                   <div class="col-md-4">
                        <div class="card text-center text-white bg-danger mb-3" >
                                <div class="card-body">
                                  <h5 class="card-title">Number Of Users</h5>
                                  <p class="card-text"><?php
                               $query = $object->connect()->prepare("SELECT * FROM user");
                               $query->execute();
                               echo $query->rowCount();
                                   ?></p>
                                 
                                </div>
                              </div>   
                   </div>
                   <div class="col-md-4">
                        <div class="card text-center text-white bg-danger mb-3" >
                                <div class="card-body">
                                  <h5 class="card-title">Number Of retailers</h5>
                                  <p class="card-text"><?php
                               $query = $object->connect()->prepare("SELECT * FROM retailer");
                               $query->execute();
                               echo $query->rowCount();
                                   ?></p>
                                 
                                </div>
                              </div>   
                   </div>
                   <div class="col-md-4">
                        <div class="card text-center text-white bg-danger mb-3" >
                                <div class="card-body">
                                  <h5 class="card-title">Number Of Products</h5>
                                  <p class="card-text"> <?php
                                  $count=0;
                               $query = $object->connect()->prepare("SELECT product_quantity FROM product");
                               $query->execute();
                               while($row=$query->fetch(PDO::FETCH_BOTH)) {
                                 $count +=$row['product_quantity'];

                               }
                               echo $count; ?></p>
                                 
                                </div>
                              </div>   
                   </div>
               </div>
               <div class="row">
               
                 
               
                   <div class="col-md-12">
                   <h3>Users</h3>
                     <div class="table-responsive-sm">

                    
                   <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">User Id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Mobile</th>
      <th scope="col">Address</th>
    </tr>
  </thead>
  
                    
  <tbody>
  <?php
                 $stmt=$object->connect()->query("SELECT * FROM user");
                 while ($row=$stmt->fetch()){?>
    <tr>
      <!-- <th scope="row">1</th> -->
      <td><?php echo $row['user_id'];?></td>
      <td><?php echo $row['user_name'];?></td>
      <td><?php echo $row['user_email'];?></td>
      <td><?php echo $row['user_contact'];?></td>
      <td><?php echo $row['user_address'];?></td>

      
   
    </tr>
    <?php } ?>
    
  </tbody>
</table>
</div>
<!-- users div ends here -->
<h3>Retailer Requests</h3>
<div class="row mt-2">
<div class="col-md-12">

<div class=" table-responsive-sm retailers">

                    
<table class="table table-dark table-striped">
<thead>
<tr>
<th scope="col">Retailer Id</th>
<th scope="col">Retailer Name</th>
<th scope="col">Shop Name</th>
<th scope="col">Mobile</th>
<th scope="col">Address</th>
<th scope="col">Status</th>
</tr>
</thead>

 
<tbody>
<?php
$stmt2=$object->connect()->query("SELECT * FROM retailer WHERE retailer_approved=0");
if($stmt2->rowCount()>0){


while ($row2=$stmt2->fetch()){
  $r_id=$row2['retailer_id'];
  ?>
<tr>
<!-- <th scope="row">1</th> -->
<td><?php echo $row2['retailer_id'];?></td>
<td><?php echo $row2['retailer_name'];?></td>
<td><?php echo $row2['retailer_shop_name'];?></td>
<td><?php echo $row2['retailer_contact'];?></td>
<td><?php echo $row2['retailer_address'];?></td>

<td><a href="adminpanel.php?apid=<?php echo ($r_id);?>" onclick="return confirm('Approve The Retailer?')" class="btn btn-outline-success ">Approve</a> / <a href="adminpanel.php?cancelid=<?php echo ($r_id);?>" onclick="return confirm('Reject the retailer? ')" class="btn btn-outline-danger ">Reject</a>
                    </td>

</tr>
<?php }} 
else {
 echo "No new requests";
}?>

</tbody>
</table>
</div>



</div>
<!-- sub column -->




</div>
<!-- sub row -->
<div id="retailers"><h3>Retailers</h3></div>
<div class="row mt-2">
<div class="col-md-12">

<div class=" table-responsive-sm retailers1">

                    
<table class="table table-dark table-striped">
<thead>
<tr>
<th scope="col">Retailer Id</th>
<th scope="col">Retailer Name</th>
<th scope="col">Shop Name</th>
<th scope="col">Mobile</th>
<th scope="col">Address</th>
<th scope="col">Email</th>
<th scope="col">Status</th>
</tr>
</thead>

 
<tbody>
<?php
$stmt2=$object->connect()->query("SELECT * FROM retailer WHERE retailer_approved=1");
if($stmt2->rowCount()>0){


while ($row3=$stmt2->fetch()){
  $r_id=$row3['retailer_id'];
  ?>
<tr>
<!-- <th scope="row">1</th> -->
<td><?php echo $row3['retailer_id'];?></td>
<td><?php echo $row3['retailer_name'];?></td>
<td><?php echo $row3['retailer_shop_name'];?></td>
<td><?php echo $row3['retailer_contact'];?></td>
<td><?php echo $row3['retailer_address'];?></td>
<td><?php echo $row3['retailer_email'];?></td>
<td><a href="adminpanel.php?cancelid=<?php echo ($r_id);?>" onclick="return confirm('Revoke the retailer operations? ')" class="btn btn-outline-danger ">Revoke</a>
                    </td>


</tr>
<?php }} 
else {
 echo "No new requests";
}?>

</tbody>
</table>
</div>



</div>
<!-- sub column -->




</div>
<!-- sub row -->


</div>           
</div>
            </div>
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
<div class="modal fade" id="addcategories" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="">
                                   
                                   <div class="form-group ">
                                           <label for="category_name">Category Name</label>
                                           <input type="text" class="form-control" id="category_name" name="category-name"  placeholder="Category Name" required>
                                        </div>
                                       <button type="submit" class="btn btn-primary btn-lg btn-block" name="add-category">Add Product</button>
                           </form>
      </div>
    
    </div>
  </div>
</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>