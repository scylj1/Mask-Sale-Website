<!DOCTYPE html>
<html>
    <head>
        <title>Setting quota</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $rid = $_REQUEST["reps"];
                $quota = 20000;

                require("access.php");
                $sql="SELECT quota FROM reps WHERE rid = '$rid'";
                $result=mysqli_query($conn,$sql);
                $row = $result->fetch_assoc();
                // check if reps ID exists
                if($row == null){
                    echo "<p>Re-grant failed. Representative ID dost not exist.</p>";
                }
                // check if the quota is still available
                else if($row["quota"] > 0){
                    echo "<p>Re-grant failed. The quota is still available, but you can update it.</p>";
                }
                else {
                    // update the quota
                    $sql = "UPDATE reps SET quota = '$quota' WHERE rid = '$rid'";
                    $result=mysqli_query($conn,$sql);
                    if($result==true){
                        echo "<p>Quota re-grant successfully. Loading...</p>";
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
