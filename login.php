<?php
session_start();
require_once ('signup.class.php');
if(isset($_POST['login'])){


$email=$_POST['email'];
$password=$_POST['password'];
$role=$_POST['role'];
$customer="customer";
$retailer="retailer";

$login=new Login();
// class object here
if($role==$customer){
  $login->user_login($email,$password);
}
elseif($role==$retailer)
{
  $login->retailer_login($email,$password);
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Login page for administrator, user and retailer">
    <meta name="author" content="Jobin George">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer|Retailer Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>

<body>
    
       <div class="container">
         
        <!-- <div class="pos"> -->
              <div class="row">
               
                  <div class="col-md-6 offset-md-3">
  
                  
              <div class="card">
                     
                      <div class="card-body">
                              <h5 class="card-title text-center">LogIn</h5>
                            
                                     
                                    
                                   
                                  
                              <form method='post' action=''>
                                <div class="form-group">
                                <label for="user-role">Choose Role</label>
                                <select name="role" id="user-role">
                               
                                        <option class="dropdown-item" value="retailer" >Retailer</option>
                                       
                                        <option class="dropdown-item" value="customer" >Customer</option>
                                      </select>
                                </div>
                                  <div class="form-group">
                                      <label for="email-address">Email address</label>
                                      <input type="email" class="form-control" id="email-address" name='email' aria-describedby="emailHelp" placeholder="Enter email" required>
                                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>
                                    <div class="form-group">
                                      <label for="user-password">Password</label>
                                      <input type="password" class="form-control" id="user-password" name='password' placeholder="Password" required>
                                    </div>
                                    <!-- <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="remember-me">
                                      <label class="form-check-label" for="remember-me">Remember Me</label>
                                    </div> -->
                                    <button type="submit" name='login' class="btn btn-primary btn-lg btn-block">Login</button>
                                     </form>
                              <a href="customersignup.html" class="form-text"> Not Registered Yet?</a>
                      </div>
                    </div>
                  </div>
              </div>
            <!-- </div> -->
              
          </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <?php
// 			if(isset($_POST['login']))
// 			{

// 				$email=$_POST['email'];
// 				$password=$_POST['password'];
			


// 				$query="SELECT * FROM admin WHERE admin_email = '$email' and admin_password= '$password'";
			

//         $result=mysqli_query($con,$query);
//           while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
//             printf("fjhgjh");
//             header( "Location: adminpanel.html");
//         }
          
             
//       }
// else{
//   echo "DB error";
// }			       
						  
?>
      
</body>
</html>