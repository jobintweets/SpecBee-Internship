<?php
session_start();
require_once('dboconnection.php');
if(!isset($_SERVER['HTTP_REFERER'])){
  // redirect them to your desired location
  header('location:forbidden.html');
  exit;
}
$object=new Dbh();
$total=0;
$MERCHANT_KEY = "6iv3VmZi";
$SALT = "h3cRE8bZJR";
// Merchant Key and Salt as provided by Payu.

$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
//$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|name|email|address|phone";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['name'])
          || empty($posted['email'])
          || empty($posted['pname'])

          || empty($posted['ps'])
          || empty($posted['address'])
          || empty($posted['phone'])
          
		 
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}




?>
<!DOCTYPE html>
<html lang="en">
   
        <head>
       
                <meta charset="UTF-8">
                <meta name="description" content="Cart Page.All the products to be checked out will be shown here">
                <meta name="author" content="Jobin George">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Cart Page</title>
                <link rel="stylesheet" href="css/cart.css">
                <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
                <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
               <link rel="icon" href="images/cart.png">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
                <script src="bootstrap/js/bootstrap.min.js"></script>
                <script src="filtertest.js"></script>
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
                            <a class="nav-link" href="#">Logout<i class="fa fa-power-off" aria-hidden="true"></i></i></a>
                          </li>
                        </ul>
                    </div>
                      </nav>
                    
            </header>
        
            <div class="row mt-3">
            <div class=" filterdata "></div>
            <?php
            if(isset($_GET['uid']))
            {
              
              $user_id=preg_replace('#[^0-9]#i','',$_GET['uid']);
            
            $res=$object->connect()->prepare("SELECT * FROM cart where user_id= ? "); 
            $res->execute(array($user_id));
            
            if($res->rowCount()>0)
            {

           
          
            while ($row = $res->fetch(PDO::FETCH_BOTH))
            { 
              
                $product_id=$row['product_id'];
                $cart_id=$row['cart_id'];
           
            $query=$object->connect()->prepare("SELECT * FROM product where product_id= ? "); 
             $query->execute(array($product_id));
             $row1 = $query->fetch(PDO::FETCH_BOTH);
            $images='uploads/'.$row1['product_image1'];
            $cartproductid=$row1['product_id'];
            $retid=$row1['retailer_id'];
            //  $cat_name=$row1['category_name'];
           
            $total += $row1['product_price'];
           
            
            ?>
           
            
          
                <div class="card col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                                <figure><img src="<?php echo $images;?>" alt="product-image" class="product-image"></figure>
                            </div>
                            <div class="product-details col-md-6">
                                <div class="product-name">
                                    <h3> <?php echo $row1['product_name'];?></h3>
                                </div>
                                <div class="product-description">
                                    <p>
                                       
                                    <?php echo $row1['product_specification'];?>
                                    </p>
                                </div>
                                <div class="product-price">
                                        <strike> <h5>$2100</h5></strike>
                                  <h4>  <?php echo "<p>  <span id='price".$product_id."'>₹".$row1['product_price']."</span><p>";?></h4>
                                </div>
                               
                            </div>
                           
                            <div class=" line col-md-3 mt-5" >
                                    <form action="#">
                                        Quantity:
                                       
                                        <input type="number" name="qty" min="1" value=1 max="5" id="<?php echo $product_id;?>" custom="<?php echo $row1['product_price'];?>"> 
                                    
                                        <!-- <input type="submit"> -->
                                      </form>
                                      <div class="twobuttons">
                                           
                                              <a   href='checkout.php?cid=<?php echo $cart_id; ?>' class="btn btn-outline-warning btn-lg btn-block" >Pay Now</a>
                                              <!-- <a href='https://www.payumoney.com/paybypayumoney/#/6211A59D203EDB9E6C8040CE45F88E18' class="btn btn-outline-warning btn-lg btn-block">Pay Now</a> -->
                                            <a href='removefromcart.php?uid=<?php echo $user_id; ?>&amp;cpid=<?php echo urlencode ($cartproductid);?>'class="btn btn-outline-danger btn-lg btn-block" onclick="return confirm('Remove Product From Cart?')">Remove</a>
                                      </div>
                                 
                                   
                                 
                            </div>
                            
                            
                            <?php
                             }
                            }
                         
                            else{
                                echo"<div class='card col-md-12'>";
                               echo "<img src='js/empty1.gif' alt='' class='empty'>";
                               echo "</div>";
                            }
                        }
                            ?> 
                            
                </div>
             
              </div>
            </div>
          
          
            
            <div class="row">
                <div class="col-md-12 amt">
                <?php
                 echo  "<h4>Total Amount  ₹ <span class='total'>".$total."</span></h4>" 
                 ?>
                </div>
            </div>
            
            <footer>
                    <p class="category-label-text">Ecommerce By Jobin,All rights reserved 2019</p>
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-rss"></a>
             </footer>
 
 
 
<!-- </div> -->
<!-- main container ends here -->
   
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
       

<?php

?>
<!-- Modal -->
<?php

if(isset($_REQUEST['uid'])&&isset($_REQUEST['cpid'])&&isset($_REQUEST['retrid']))
  {
$userid=intval($_GET['uid']);
$catsid=intval($_GET['cpid']);
$retsid=intval($_GET['retrid']);
echo $userid;
echo $catsid;
echo $retsid;
$status=0;
$res=$object->connect()->prepare("SELECT * FROM cart where user_id= ? AND product_id= ?  "); 
            $res->execute(array($userid,$catsid));
$q=$object->connect()->prepare("SELECT * FROM product where product_id= ? AND retailer_id= ?  "); 
            $q->execute(array($catsid,$retsid));
    
$row5 = $q->fetch(PDO::FETCH_BOTH);


}
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form  method="post" action="<?php echo $action; ?>"  name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                                
                                  <div class="form-group">
                                      <label for="amount">Amount</label>
                                      <input type="email" class="form-control" id="amount" name='amount' aria-describedby="emailHelp"  required>
                                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                      <input type="text" class="form-control" id="name" name='name'required>
                                    </div>
                                    <div class="form-group">
                                      <label for="email-address">Email Address</label>
                                      <input type="email" class="form-control" id="email-address" name='email' aria-describedby="emailHelp" placeholder="Enter email" required>
                                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                 
                                    <div class="form-group">
                                      <label for="pname">Product Name</label>
                                      <input type="text" class="form-control" id="pname"  value="<?php echo $row5['product_name'];?>" name='pname'required>
                                    </div>
                                    <div class="form-group">
                                      <label for="name">Product Specification</label>
                                      <input type="text" class="form-control" id="ps" name='ps'required>
                                    </div>
                                    <div class="form-group">
                                      <label for="name">Address</label>
                                      <input type="text" class="form-control" id="address" name='address'required>
                                    </div>
                                    <div class="form-group">
                                      <label for="phone">Phone</label>
                                      <input type="text" class="form-control" id="phone" name='phone'required>
                                    </div>
                                    <!-- <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="remember-me">
                                      <label class="form-check-label" for="remember-me">Remember Me</label>
                                    </div> -->
                                    <a href='https://www.payumoney.com/paybypayumoney/#/6211A59D203EDB9E6C8040CE45F88E18' class="btn btn-outline-warning btn-lg btn-block">Pay Now</a>
                                     </form>
      </div>
     
    </div>
  </div>
</div>
</body>
</html>