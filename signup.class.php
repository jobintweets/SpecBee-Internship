    <?php
        
        require_once('dboconnection.php');
        // class addProduct extends Dbh{
        //     public function add_product($r_id,$catid,$pname,$model,$brand,$spec,$price,$q,$i1,$i2,$i3){
        //         try{



        //             $p_array_select=[
        //                 'cid'=>$catid,
        //                 'rid'=>$r_id,
        //                 'pn'=>$pname,
        //                 'b'=>$brand,
        //                 'm'=>$model,
        //                 's'=>$spec
        //             ];

        //             $p_array=[
        //                 'c'=>$catid,
        //                 'rid'=>$r_id,
        //                 'nm' => $pname,
        //                 'b'=>$brand,
        //                 'md'=>$model,
        //                 'p'=>$price,
        //                 's'=>$spec,
        //                 'i1'=>$i1,
        //                 'i2'=>$i2,
        //                 'i3'=>$i3,
        //                 'q'=>$q
        //                 ];
        //            $query = $this->connect()->prepare("SELECT * FROM product WHERE category_id=? 
        //             AND retailer_id=? AND product_name=? AND product_brand=? AND product_model=? AND product_specification=? ");
        //             $query->execute($p_array_select);
        //             $row = $query->fetch(PDO::FETCH_BOTH);
        //             if($query->rowCount()>0) 
        //             {
        //   // header( "Location:adminpanel.php");
        //           echo '<script type="text/javascript">
        //             alert("Product already exists");
        //                 </script>';
        //             }
        //             else
        //             {
        //                 $sql="INSERT INTO product (category_id,retailer_id,product_name,product_brand,product_model,
        //                 product_price,product_specification,product_image1,product_image2,product_image3,product_quantity)
        //                  VALUES (:c,:rid,:nm,:b,:md,:p,:s,:i1,:i2,:i3,:q)";
                        
        //                 $query=$this->connect()->prepare($sql);
        //                 $query->execute($p_array);
        //                 if($query){
        //                     echo '<script type="text/javascript">alert("Product Added")</script>';
        //                 }
        //                 else{
        //                     echo '<script type="text/javascript">alert("Failed to add product")</script>';
        //                 }
                       
        //             }
        //         }
        //         // try ends here
        //         catch(PDOException $e)
        //         {
        //             echo "Database error :".$e->getMessage();
        //         }

        //     }
        // }





        class addCategory extends Dbh
        {
            public function add_category($category){
                try{
                    $cate_array=[
                        'cat' => $category
                    ];
                    $query = $this->connect()->prepare("SELECT * FROM category WHERE category_name=?");
                    $query->execute(array($category));
                    $row = $query->fetch(PDO::FETCH_BOTH);
                    if($query->rowCount()>0) 
                    {
        
                     
                        // header( "Location:adminpanel.php");
                  
                        echo '<script type="text/javascript">
                        alert("Category already exists");
                        </script>';
                                  
                    }
                    else
                    {
                        $sql="INSERT INTO category (category_name) VALUES (:cat)";
                        $query=$this->connect()->prepare($sql);
                        $query->execute($cate_array);
                        if($query){
                            echo '<script type="text/javascript">alert("Category Added")</script>';
                        }
                        else{
                            echo '<script type="text/javascript">alert("Failed to add category")</script>';
                        }
                       
                    }
                }
                // try ends here
                catch(PDOException $e)
                {
                    echo "Database error :".$e->getMessage();
                }

            }
        }
        
    class adminLogin extends Dbh{

    public function admin_login($admin_email,$password){
        try{
            $query = $this->connect()->prepare("SELECT * FROM admin WHERE admin_email=? AND admin_password=? ");
            $query->execute(array($admin_email,$password));
            $row = $query->fetch(PDO::FETCH_BOTH);
            if($query->rowCount() > 0) 
            {

                $_SESSION['adminemail'] = $admin_email;
                $_SESSION['password'] = $password;
                $stmt=$this->connect()->query("SELECT * FROM admin");
                while ($row=$stmt->fetch()){
                    $_SESSION['adminname']=$row['admin_name'];

                }
                header( "Location:adminpanel.php");
            }
            else
            {
                echo '<script type="text/javascript">alert("No such User exists. Invalid Credentials")</script>';
            }
        }
        catch(PDOException $e)
                {
                    echo "Database error :".$e->getMessage();
                }
            }
            }
    class Login extends Dbh
        {
    public function user_login($user_email,$password)
            {
                try{
                    $query = $this->connect()->prepare("SELECT * FROM user WHERE user_email=? AND user_password=? ");
                    $query->execute(array($user_email,$password));
                    $row = $query->fetch(PDO::FETCH_BOTH);
                    if($query->rowCount() > 0) 
                    {
        
                        $_SESSION['useremail'] = $user_email;
                        $_SESSION['password'] = $password;
                        $stmt=$this->connect()->query("SELECT * FROM user WHERE user_email='$user_email'");
                        while ($row=$stmt->fetch()){
                            $_SESSION['username']=$row['user_name'];
                            $_SESSION['userid']=$row['user_id'];
            
                        }
                        header( "Location:index.php");
                    }
                    else
                    {
                        echo '<script type="text/javascript">alert("No such User exists. Invalid Credentials")</script>';
                    }
        }
                catch(PDOException $e)
                {
                    echo "Database error :".$e->getMessage();
                }
            
            }


        public function retailer_login($retailer_email,$password)
            {

                try{


                    $query = $this->connect()->prepare("SELECT * FROM retailer WHERE retailer_email=? AND retailer_password=? ");
                    $query->execute(array($retailer_email,$password));
                    $row = $query->fetch(PDO::FETCH_BOTH);
        
                    if($query->rowCount() > 0) 
                    {

                        header( "Location:retailerpanel.php");
                        $_SESSION['retailerid'] = $row['retailer_id'];
                        $_SESSION['retaileremail'] = $retailer_email;
                        $_SESSION['password'] = $password;
                        $stmt=$this->connect()->query("SELECT * FROM retailer");
                        while ($row=$stmt->fetch()){
                            $_SESSION['username']=$row['retailer_name'];
            
                        }
                        
                        
                    }
                    else
                    {
                        echo '<script type="text/javascript">alert("No such User exists. Invalid Credentials")</script>';
                    }




                }
                catch(PDOException $e)
                {
                    echo "Database error :".$e->getMessage();
                }
                
            }




        }

        class SignUser extends Dbh
        {

            public function signup($username,$password,$cpassword,$useremail,$usernumber,$useraddress)
            {
                try
                {
                    $details_array = [
                        'name' => $username,
                        'pw' => $password,
                    
                        'ue'=> $useremail,
                        'un'=>$usernumber,
                        'ua'=>$useraddress
                    ];

                    $query = $this->connect()->prepare("SELECT * FROM user WHERE user_email=? ");
                    $query->execute(array($useremail));

                    
                        if($query->rowCount() > 0)
                        {
                        echo "<script>
                        alert('Email Already Exists');
                        </script>";
                        }
                        else
                    {
                        
                        if($password==$cpassword)
                        {
                            $sql="INSERT INTO user (user_name,user_password,user_email,user_contact,user_address) VALUES (:name,:pw,:ue,:un,:ua)";
                            $query=$this->connect()->prepare($sql);
                            $query->execute($details_array);
                                if($query->rowCount() > 0)
                            
                                {
                                    echo '<script type="text/javascript">alert("User Registered.. Welcome")</script>';
                                    $_SESSION['username'] = $username;
                                    $_SESSION['password'] = $password;
                                    $_SESSION['user_email'] = $useremail;
                                    header( "Location: login.php");
                                }
                                else
                                {
                                    echo '<p class="bg-danger msg-block">Registration Unsuccessful due to server error. Please try later</p>';
                                }
                                
                        
                        }
                        else
                        {
                        echo '<script type="text/javascript">alert("Password and Confirm Password do not match")</script>';
                        }
                    }
                

                }
                catch(PDOException $e)
                {
                    echo "Database error :".$e->getMessage();
                }

            }

        }









        class retailersignup  extends Dbh {
    public function retailsignup($retailer_name,$shop_name,$retailer_password,$retailer_password_repeat,$shop_address,$retailer_email,$retailer_phone)
    {

    try{
        $accepted=0;
        $details_array = [
            'rn' => $retailer_name,
            'sn' => $shop_name,
            'pw'=>$retailer_password,
            'sa'=>$shop_address,
            're'=>$retailer_email,
            'rp'=>$retailer_phone,
            'ac'=>$accepted
        ];

        $query = $this->connect()->prepare("SELECT * FROM retailer WHERE retailer_email=? ");
        $query->execute(array($retailer_email));

        
            if($query->rowCount() > 0)
            {
            echo "<script>
            alert('Email Already Exists');
            </script>";
            }
            else 
            {
                if($retailer_password==$retailer_password_repeat){

                    $sql="INSERT INTO retailer (retailer_name,retailer_shop_name,
                    retailer_password,retailer_address,retailer_email,retailer_contact,retailer_approved) VALUES (:rn,:sn,:pw,:sa,:re,:rp,:ac)";
                    $query=$this->connect()->prepare($sql);
                    $query->execute($details_array);
                    if($query)
                    {
                    echo '<script type="text/javascript">alert("User Registered.. Welcome")</script>';
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['user_email'] = $useremail;
                    header( "Location: login.php");
                    }
                    else
                    {
                    echo '<p class="bg-danger msg-block">Registration Unsuccessful due to server error. Please try later</p>';
                    }

                }

                else {

                    echo '<script type="text/javascript">alert("Password and Confirm Password do not match")</script>';
                }
    }
        }
        // try ends here

    catch(PDOException $e)
    {
        echo "Database error :".$e->getMessage();
    }
    }
    // method ends here
    }
    // class ends here


        
    ?>

