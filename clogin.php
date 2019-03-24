 <?php
session_start();
require_once('phpfiles/database.php');
if(isset($_POST['login']))
			{

				$email=$_POST['email'];
                $password=$_POST['password'];
                $role=$_POST['role'];
                $customer="customer";
                $retailer="retailer";
                if($role==$customer){
                    $query="SELECT * FROM user WHERE user_email = '$email' and user_password= '$password'";
                    $result=mysqli_query($con,$query);
                     if($result){
                         
                      
                        if(mysqli_num_rows($result)>0)
                        {
                            header( "Location: index.php");
                        }
              else{
                 echo "Invalid credentials";
                }   
                            }
                 
                    else{
                        echo "query execution failed";
                    }
                    
                }
                else {

                    $query="SELECT * FROM retailer WHERE retailer_email = '$email' and retailer_password= '$password'";
                    $result=mysqli_query($con,$query);
                    if($result){
                         
                      
                        if(mysqli_num_rows($result)>0)
                        {
                            header( "Location:retailerpanel.php");
                            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                            $_SESSION['useremail']=$email;
                           

                        }
              else{
                 echo "Invalid credentials";
                }   
                            }





                }

               
            }
           
else{
  echo "Data base conection error";
}			       
?> 