<!DOCTYPE html>
<html>
    <head>
        <title>Updating quota</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $rid = $_REQUEST["reps"];
                $quota = $_REQUEST["quota"];

                require("access.php");
                $sql="SELECT * FROM reps WHERE rid = '$rid'";
                $result=mysqli_query($conn,$sql);
                $row = $result->fetch_assoc();
                // check if reps ID exists
                if($row == null){
                    echo "<p>Update failed. Representative ID dost not exist.</p>";
                }
                else {
                    // update the quota
                    $sql = "UPDATE reps SET quota = '$quota' WHERE rid = '$rid'";
                    $result=mysqli_query($conn,$sql);
                    if($result==true){
                        echo "<p>Quota updated successfully. Loading...</p>";
                        header("Refresh:2;url=manager.php");
                        $conn->close();
                        exit();
                    }
                    else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                $conn->close();
            ?>
            <a href = "manager.php" id = "back"> Back </a>
        </div>
    </body>
</html>
