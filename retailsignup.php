<?php

session_start();
require_once('phpfiles/database.php');



			if(isset($_POST['signup']))
			{

				$retailer_name=$_POST['retailer-name'];
				$shop_name=$_POST['shop-name'];
				$shop_address=$_POST['shop-address'];
				
				$retailer_email=$_POST['retailer-email'];
				$retailer_phone=$_POST['retailer-phone'];
                $retailer_password=$_POST['retailer-password'];
                $retailer_password_repeat=$_POST['retailer-password-repeat'];



				$query="SELECT * FROM retailer WHERE retailer_email = '$retailer_email'";
				

				$result=mysqli_query($con,$query);
				if($result)
				{
				    if(mysqli_num_rows($result)>0)
				    {
					echo "<script>
					  alert('Email Already Exists');
					  </script>";
				    }
			    
              
			       else
			       {
					
				    if($retailer_password==$retailer_password_repeat)
				    {

						
						
					   $query = "select * from retailer where retailer_name='$retailer_name'";
				
				       $query_run = mysqli_query($con,$query);
				
				       if($query_run)
					   {
						 
					   
                               $query = "insert into retailer (retailer_name,retailer_shop_name,
                               retailer_password,retailer_address,retailer_email,retailer_contact,retailer_approved)
                                values('$retailer_name','$shop_name','$retailer_password',
                                '$shop_address','$retailer_email','$retailer_phone','0')";
							   $query_run = mysqli_query($con,$query);
							   if($query_run)
							   {
                                header( "Location: login.php");
								echo '<script type="text/javascript">alert("User Registered.. Welcome")</script>';
								$_SESSION['username'] = $username;
								$_SESSION['password'] = $password;
								$_SESSION['user_email'] = $useremail;
							 	
							   }
							   else
							   {
								  echo '<p class="bg-danger msg-block">Registration Unsuccessful due to server error. Please try later</p>';
							   }
						    
						}
					   else
					   {
						echo '<script type="text/javascript">alert("DB error")</script>';
					   }
					
					}
				    else
				    {
					echo '<script type="text/javascript">alert("Password and Confirm Password do not match")</script>';
				    }
				}
			}
		}
			?>