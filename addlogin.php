<?php 
session_start();
require_once('phpfiles/database.php');
if(isset($_POST['login']))
			{

				$email=$_POST['email'];
				$password=$_POST['password'];
                $query="SELECT * FROM admin WHERE admin_email = '$email' and admin_password= '$password'";
                $result=mysqli_query($con,$query);
                 if($result){
                     
                  
                    if(mysqli_num_rows($result)>0)
				    {
                        // $a=5;
                        // $row=mysql_fetch_array($result,MYSQLI_ASSOC);
         
                        header( "Location: adminpanel.html");
         
         
          
            
            }
          else{
             echo "Invalid credentials";
            }   
                        }
                // result if ends here
                else{
                    echo "query execution failed";
                }
            }
else{
  echo "Data base conection error";
}			       
?>