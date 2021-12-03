<!DOCTYPE html>
<html>
    <head>
        <title>Ordering</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $n95num = $_REQUEST["num1"];
                $surgicalnum = $_REQUEST["num2"];
                $surgicaln95num = $_REQUEST["num3"];
                $repsid = $_REQUEST["reps"];
                $orderstatus = "Processing";
            
                require("access.php");
                // check if reps ID exists
                $sql="SELECT rid FROM reps WHERE rid = '$repsid'";
                $result=mysqli_query($conn,$sql);
                $row=mysqli_fetch_row($result);
                if($row == null){
                    echo "<p>Sale representation ID is not exist. Order fails.</p>";
                }
                else{
                    session_start();
                    $uname = $_SESSION["uname"];
                    // check if reps ID is valid
                    $sql="SELECT * FROM reps, customer WHERE customer.username = '$uname' and customer.region = reps.region and rid = '$repsid'";
                    $result=mysqli_query($conn,$sql);
                    $row=mysqli_fetch_row($result);
                    if($row == null){
                        echo "<p>Please select the representative in your region. Order fails.</p>";
                    }
                    else{
                        $amount = $n95num*2 + $surgicalnum*1 + $surgicaln95num*3;
                        $sql="SELECT quota FROM reps WHERE rid = '$repsid'";
                        $result=mysqli_query($conn,$sql);
                        $row = $result->fetch_assoc();
                        $quota = $row["quota"];
                        $quota = $quota - $n95num - $surgicalnum - $surgicaln95num;
                        // insert order
                        $sql="insert into orders(customer, orderdate, n95num, surgicalnum, surgicaln95num, amount, repsid, repsquota, orderstatus)values('$uname', now(), '$n95num', '$surgicalnum', '$surgicaln95num', '$amount', '$repsid', '$quota', '$orderstatus')";
                        $result=mysqli_query($conn,$sql);
                        if($result==true){
                            // update quota
                            $sql = "UPDATE reps SET quota = '$quota' WHERE rid = '$repsid'";
                            $result=mysqli_query($conn,$sql);
                            if($result==true){
                                echo "<p>Order successfully. Loading...</p>";
                                header("Refresh:2;url=customer.php");
                                exit();
                            }
                            else{
                                echo "<p>Order failed.</p>";
                            }
                        }
                        else{
                            echo "<p>Order failed.</p>";
                        } 
                    }    
                }
                $conn->close();
            
            ?>
            <a href = "customer.php" id = "back"> Back </a>
        </div>
    </body>
</html>
