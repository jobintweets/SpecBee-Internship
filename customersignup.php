<?php
session_start();
// require_once ('database.php');
require_once ('signup.class.php');

$user=new SignUser();
if(isset($_POST['signup']))
{
                $username=$_POST['customer-name'];
				$password=$_POST['customer-password'];
				$cpassword=$_POST['customer-password-confirm'];
				
				$useremail=$_POST['customer-email'];
				$usernumber=$_POST['customer-phone'];
                $useraddress=$_POST['customer-address'];
                $user->signup($username,$password,$cpassword,$useremail,$usernumber,$useraddress);

            // $sql = "insert into user (user_name,user_password,user_email,user_contact,user_address ) values('$username','$password','$useremail','$usernumber','$useraddress')";
            // $result=mysqli_query($pdo,$query);
            

}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Sigup page for customer">
    <meta name="author" content="Jobin George">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer  Signup</title>
    <link rel="stylesheet" href="css/customersignup.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>

<body>
    <div class="container">
        <!-- <div class="login-form"> -->
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">

                
            <div class="card">
                   
                    <div class="card-body">
                            <h5 class="card-title text-center">Customer Sign Up</h5>
                            
                            <form method="POST" action="customersignup.php">
                                   
                                    <div class="form-group ">
                                            <label for="customer_name">Full Name</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer-name" placeholder="Enter full name" required>
                                          
                                          </div>
                                          <div class="form-group">
                                                <label for="customer_email">Email address</label>
                                                <input type="email" class="form-control" id="customer_email" name="customer-email" aria-describedby="emailHelp" placeholder="Enter email"  required>
                                                
                                              </div>
                                              <div class="form-group ">
                                                    <label for="customer_password">Password</label>
                                                    <input type="password" class="form-control" id="customer_password" name="customer-password" placeholder="Password"  required>
                                                  </div>
                                                  <div class="form-group ">
                                                    <label for="customer_password">Retype Password</label>
                                                    <input type="password" class="form-control" id="customer_password1" name="customer-password-confirm" placeholder="Password"  required>
                                                  </div>
                                          
                                              <div class="form-group ">
                                                    <label for="customer_address">Address</label>
                                                    
                                                    <textarea class="form-control" id="customer_address" name="customer-address"required></textarea>
                                                   
                                                </div>
                                   
                             
                              <div class="form-group">
                                    <label for="customer_phone">Contact number</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer-phone" placeholder="Enter phone number"  required>
                                  </div>
                             
                         
                           
                              <button type="submit" class="btn btn-primary btn-lg btn-block" name="signup">SignUp</button>
                              
                            </form>
                          
                            <a href="login.php"> <small id="emailHelp" class="form-text ">Already a member?</small></a>
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