<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
        <?php
            require("access.php");
            $uname=$_REQUEST["uname"];
            // check if username has already existed
            $sql="SELECT * FROM customer,reps, manager WHERE customer.username='$uname' or reps.username='$uname' or manager.username='$uname'";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_row($result);
            if($row!=null){
                echo "<p>Sorry, username has already existed.</p>";
            }
            else{
                $uname = $_REQUEST["uname"];
                $upwd = $_REQUEST["upwd"];
                $rname = $_REQUEST["rname"];
                $passport = $_REQUEST["passport"];
                $email = $_REQUEST["email"]; 
                $phone = $_REQUEST["phone"];
                $region = $_REQUEST["region"];
                // insert into customer
                $sql="insert into customer (username, userpassword, realname, passport, email, phone, region)values('$uname', '$upwd', '$rname', '$passport', '$email', '$phone', '$region')";
                $result=mysqli_query($conn,$sql);
                
                if($result==true){ 
                    echo "<p>Register successfully. Loading...</p>";
                    header("Refresh:2;url=login.html");
                    $conn->close(); 
                    exit();
                }
                else{
                    echo "<p>Register failed</p>";
                }   
            }
            $conn->close();
        ?>

        <a href = "register.html" id = "back"> Back to register </a>

    </div>
    </body>
</html>
