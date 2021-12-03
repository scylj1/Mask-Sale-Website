<!DOCTYPE html>
<html>
    <head>
        <title>Log in</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
        <?php
            require("access.php");
            $uname=$_REQUEST["uname"];
            $password = $_REQUEST["upwd"];
            // check if username exists
            $sql="SELECT * FROM customer,reps, manager WHERE customer.username='$uname' or reps.username='$uname' or manager.username='$uname'";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_row($result);
            if($row != null){
                session_start();
                $_SESSION["uname"] = $uname;
                // check if customer's username and password are correct
                $sql="SELECT * FROM customer WHERE username='$uname' and userpassword = '$password'";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_row($result);
                if($row != null){
                   echo "<p>Log in successfully. Loading...</p>";
                   header("Refresh:2;url=customer.php");
                   exit();
                }
                else{
                    // check if reps's username and password are correct
                    $sql="SELECT * FROM reps WHERE username='$uname' and userpassword = '$password'";
                    $result=mysqli_query($conn,$sql);
                    $row=mysqli_fetch_row($result);
                    if($row != null){
                        echo "<p>Log in successfully. Loading...</p>";
                        header("Refresh:2;url=reps.php");
                        exit();
                    }
                    else{
                        // check if manager's username and password are correct
                        $sql="SELECT * FROM manager WHERE username='$uname' and userpassword = '$password'";
                        $result=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_row($result);    
                        if($row != null){
                            echo "<p>Log in successfully. Loading...</p>";
                            header("Refresh:2;url=manager.php");
                            exit();
                        }
                        else{
                            echo "<p>Sorry, password is not correct.</p>";
                        }
                    }
                }
            }    
            else {
                echo "<p>Sorry, username is not exist.</p>";
            }
            $conn->close();
        ?>
        <a href = "login.html" id = "back"> Back to log in</a>
    </div>
    </body>
</html>