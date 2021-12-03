<!DOCTYPE html>
<html>
    <head>
        <title>Cancelling</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
        <?php
            $oid = $_REQUEST["order"];
            require("access.php");
            // check if the order can be canceled
            $sql="SELECT orderdate FROM orders WHERE oid='$oid' and now() <= date_add(orderdate, interval 1 day)";
            $result = $conn->query($sql);
            $row=mysqli_fetch_row($result);
            if($row == null){
                echo "<p>Failed. You entered a wrong ID or it has been more than 1 day after the order. </p>";
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
                    // delete the record in orders table
                    $sql = "DELETE FROM orders WHERE oid = '$oid'";
                    if($conn->query($sql) === true){
                        echo "<p>Order canceled successfully. Loading...</p>";
                        header("Refresh:2;url=customer.php");
                        $conn->close();
                        exit();
                    }
                }
                else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            $conn->close();
        ?>
        <a href = "customer.php" id = "back"> Back </a>
    </div>
    </body>
</html>
