<?php
session_start();
require_once ('signup.class.php');
$retailer=new retailersignup();
if(isset($_POST['signup'])){


$retailer_name=$_POST['retailer-name'];
				$shop_name=$_POST['shop-name'];
				$shop_address=$_POST['shop-address'];
				
				$retailer_email=$_POST['retailer-email'];
				$retailer_phone=$_POST['retailer-phone'];
                $retailer_password=$_POST['retailer-password'];
                $retailer_password_repeat=$_POST['retailer-password-repeat'];
                $retailer->retailsignup($retailer_name,	$shop_name,$retailer_password,$retailer_password_repeat,$shop_address,$retailer_email,$retailer_phone);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Sigup page for retailer">
    <meta name="author" content="Jobin George">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Retailer Signup</title>
    <link rel="stylesheet" href="css/retailersignup.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>

<body>
    <div class="container-fluid">
        <!-- <div class="login-form"> -->
            <div class="row top-buffer">
                <div class="col-md-6 offset-md-3">

                
            <div class="card">
                   
                    <div class="card-body">
                            <h5 class="card-title text-center">Retailer Sign Up</h5>
                            
                            <form method="post" action="">
                                 
                                    <div class="form-group ">
                                            <label for="retailer_name">Full Name</label>
                                            <input type="text" class="form-control" id="retailer_name" name="retailer-name"  placeholder="Enter full name" required>
                                          
                                          </div>
                                          <div class="form-group ">
                                                <label for="shop_name">Shop Name</label>
                                                <input type="text" class="form-control" id="shop_name" name="shop-name"  placeholder="Enter shop name"  required>
                                              </div>
                                              <div class="form-group ">
                                                    <label for="shop_address">Shop Address</label>
                                                    <!-- <input type="text" class="form-control" id="shop-name"  placeholder="Enter shop name"> -->
                                                    <textarea class="form-control" id="shop_address" name="shop-address" placeholder="Enter shop address"   required></textarea>
                                                       
                                                            
                                                  </div>
                                    
                              <div class="form-group">
                                <label for="retailer_email">Email address</label>
                                <input type="email" class="form-control" id="retailer_email" name="retailer-email" aria-describedby="emailHelp" placeholder="Enter email"  required>
                                
                              </div>
                              <div class="form-group ">
                                    <label for="retailer_phone">Contact number</label>
                                    <input type="text" class="form-control" id="retailer_phone"  name="retailer-phone" placeholder="Enter phone number"  required>
                                  </div>
                              <div class="form-group ">
                                <label for="user_password">Password</label>
                                <input type="password" class="form-control" id="user_password"  name="retailer-password" placeholder="Password"  required>
                              </div>
                              <div class="form-group ">
                                <label for="user_password2">Confirm Password</label>
                                <input type="password" class="form-control" id="user_password2"  name="retailer-password-repeat" placeholder="Password"  required>
                              </div>
                            <!-- </div>  -->
                              <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember-me">
                                <label class="form-check-label" for="remember-me">Remember Me</label>
                              </div> -->
                              <button type="submit" class="btn btn-outline-primary btn-lg btn-block" name="signup">SignUp</button>
                            </form>
                     
                    </div>
                  </div>
                </div>
            </div>
        </div>
       
  
    

      

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>