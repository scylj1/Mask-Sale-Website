<!DOCTYPE html>
<html>
    <head>
        <title>Deleting</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $oid = $_REQUEST["order"];
                require("access.php");
                // check if the order can be deleted
                $sql="SELECT * FROM orders WHERE oid='$oid' and now() <= date_add(orderdate, interval 1 day) and repsquota < 0";
                $result = $conn->query($sql);
                $row=mysqli_fetch_row($result);
                if($row == null){
                    echo "<p>Failed. You entered a wrong ID or it has been more than 1 day after the order or it does not exceed your quota.</p> ";
                }
                else{
                    $sql="SELECT * FROM reps, orders WHERE oid = '$oid' and rid = repsid";
                    $result=mysqli_query($conn,$sql);
                    $row = $result->fetch_assoc();
                    $quota = $row["quota"];
                    $repsid = $row["rid"];
                    $quota = $quota + $row["n95num"] + $row["surgicalnum"] + $row["surgicaln95num"];
                    // update the quota
                    $sql = "UPDATE reps SET quota = '$quota' WHERE rid = '$repsid'";
                    $result=mysqli_query($conn,$sql);
                    if($result==true){
                        // delete the order record
                        $sql = "DELETE FROM orders WHERE oid = '$oid'";
                        if($conn->query($sql) === true){
                            echo "<p>Order deleted successfully. Loading...</p>";
                            header("Refresh:2;url=reps.php");
                            $conn->close(); 
                            exit();
                        }
                        else{
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }           
            ?>
            <a href = "reps.php" id = "back"> Back </a>
            <?php $conn->close(); ?>
        </div>
    </body>
</html>
