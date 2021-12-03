<!DOCTYPE html>
<html>
    <head>
        <title> Update information </title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
    <?php
            session_start();
            $uname = $_SESSION["uname"];
            require("access.php");
            $upwd = $_REQUEST["upwd"];
            $email = $_REQUEST["email"]; 
            $phone = $_REQUEST["phone"];
            $region = $_REQUEST["region"];
            if ($upwd != ""){
                $sql = "UPDATE customer SET userpassword = '$upwd' WHERE username = '$uname'";
                $result=mysqli_query($conn,$sql);
            }
            if($result==true){ 
                echo "<p>Password updated successfully.</p>";
            }
            if ($email != ""){
                $sql = "UPDATE customer SET email = '$email' WHERE username = '$uname'";
                $result=mysqli_query($conn,$sql);
                if($result==true){ 
                    echo "<p>Email updated successfully.</p>";
                }
            }
            if ($phone != ""){
                $sql = "UPDATE customer SET phone = '$phone' WHERE username = '$uname'";
                $result=mysqli_query($conn,$sql);
                if($result==true){ 
                    echo "<p>Phone updated successfully.</p>";
                }
            }
            if ($region != ""){
                $sql = "UPDATE customer SET region = '$region' WHERE username = '$uname'";
                $result=mysqli_query($conn,$sql);                
                if($result==true){ 
                    echo "<p>Region updated successfully.</p>";
                }
            }
            if ($upwd == "" && $email == "" && $phone == "" && $region == ""){
                echo "<p>You do not update anything.</p>";
                header("Refresh:2;url=customer.php");
                $conn->close(); 
                exit();
            }
            $conn->close();
        ?>
        <a href = "login.html" id = "back"> Back to login </a>
    </div>
    </body>
</html>
