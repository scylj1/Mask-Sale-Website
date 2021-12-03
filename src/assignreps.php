<!DOCTYPE html>
<html>
    <head>
        <title>Assign</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $user = $_REQUEST["user"];
                $region = $_REQUEST["region"];
                $quota = $_REQUEST["quota"];
                       
                require("access.php");
                $sql="SELECT * FROM customer WHERE uid = '$user'";
                $result=mysqli_query($conn,$sql);
                $row = $result->fetch_assoc();
                // check if user ID exists
                if($row == null){
                    echo "<p>Assign failed. User ID dost not exist.</p>";
                }
                else{
                    $username = $row["username"];
                    $password = $row["password"];
                    $realname = $row["realname"];
                    $email = $row["email"];
                    $phone = $row["phone"];
                    // insert into reps table
                    $sql="insert into reps(username, userpassword, realname, email, phone, region, quota)values('$username', '$password', '$realname', '$email', '$phone', '$region', '$quota')";
                    $result=mysqli_query($conn,$sql);
                    if($result==true){
                        // delete it in the user table
                        $sql = "DELETE FROM customer WHERE uid = '$user'";
                        if($conn->query($sql) === true){
                            echo "<p>Assign successfully.</p>";
                            header("Refresh:2;url=manager.php");
                            $conn->close();
                            exit();
                        }
                        else{
                            echo "<p>Assign failed.</p>";
                        }
                    }
                    else{
                        echo "<p>Assign failed.</p>";
                    }
                }          
                $conn->close();
            ?>
        
            <a href = "manager.php" id = "back"> Back </a>
        </div>
    </body>
</html>
