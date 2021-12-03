<!DOCTYPE html>
<html>
    <head>
        <title> Welcome Sale Representative </title>
        <link rel="stylesheet" type="text/css" href="reps.css"/>
        <script type="text/javascript" src="order.js"></script>
    </head>
    <body>
    <div id = "page">
        <?php
            session_start();
            $uname = $_SESSION["uname"];
            // Update database
            require("access.php");
            $sql = "SELECT * FROM orders  WHERE orderstatus = 'Processing' and now() > date_add(orderdate, interval 1 day)";
            $result = mysqli_query($conn,$sql);
            $nrows = $result->num_rows;
            if ($nrows > 0) {
                while ($row = $result->fetch_assoc()){
                    $id = $row["oid"];
                    $sql1 = "UPDATE orders SET orderstatus = 'Sold' WHERE oid = '$id'";
                    if ($conn->query($sql1) == False){
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        ?>
        <section>
            <h2> Welcome sales representatives</h2>
        </section>

        <section id = "deleteorder">
            <div>
                <div>
                    <form action = "deleteorder.php" method = "post" onsubmit = "return checknum5()">
                        <div id = "delete">You can delete the ordering record if the customer’s ordering amount exceeds your quota </div>
                        <p><label class = "prompt"> Order ID :<input type="text" id="order" name="order" class = "input"></label></p>
                        <p><input type="submit" value="Confirm" id = "confirm"></p>
                    </form>
                </div>

                <div>
                    <div id = "person">
                        <?php
                            // personal information
                            $sql = "SELECT * FROM reps WHERE username = '$uname'";
                            $result = mysqli_query($conn,$sql);
                            $row = $result->fetch_assoc();
                            $quota = $row["quota"];
                            echo "<p>Your information: </p>";
                            echo "<p>Username: " . $row["username"]. "</p>";
                            echo "<p>Realname: " . $row["realname"] . "</p>";
                            echo "<p>Employee ID: " . $row["rid"] ."</p>";
                            echo "<p>Email: " . $row["email"] . "</p>";
                            echo "<p>Phone: " . $row["phone"] ."</p>";
                            echo "<p>Region: " . $row["region"]. "</p>";
                            echo "<p>Quota: " . $quota. "</p>";
                            echo "<p><a href = 'login.html' id = 'back'> Back to login </a><p>";                        
                        ?>
                    </div>
                </div>
            </div>
        </section>
        
        <div id = "seperate">
             <div>
                <?php
                    // order in processing
                    $rid = $row["rid"]; 
                    echo "<h2>Your order in processing: </h2>";
                    $sql = "SELECT * FROM orders WHERE repsid = '$rid' and orderstatus = 'Processing'";
                    $result = mysqli_query($conn,$sql);
                    $nrows = $result->num_rows;
                    if ($nrows > 0) 
                    {
                        $i = 1;
                            while ($row = $result->fetch_assoc()){
                            echo "<div><p>NO. " . $i . "</p>";
                            $i++;
                            echo "<p>Order ID: " . $row["oid"]. "</p>";
                            echo "<p>Order time: " . $row["orderdate"]. "</p>";
                            echo "<p>Number of N95 respirators: " . $row["n95num"]. "</p>";
                            echo "<p>Number of surgical masks: " . $row["surgicalnum"]. "</p>";
                            echo "<p>Number of surgical N95 respirators: " . $row["surgicaln95num"]. "</p>";
                            echo "<p>Amount: $" . $row["amount"]. "</p>";
                            echo "<p>Customer information: </p>";
                            // require("access.php");
                            $customer = $row["customer"];
                            $sql1 = "SELECT * FROM customer WHERE username = '$customer'";
                            $result1 = $conn->query($sql1);
                            while ($row1 = $result1 -> fetch_assoc()){
                                echo "<p>Customer ID: " . $row1["uid"]. "</p>";
                                echo "<p>Username: " . $row1["username"]. "</p>";
                                echo "<p>Real name: " . $row1["realname"]. "</p>";
                                echo "<p>Passport: " . $row1["passport"]. "</p>";
                                echo "<p>Email: " . $row1["email"]. "</p>";
                                echo "<p>Phone: " . $row1["phone"]. "</p></div>";
                            }
                        }
                   }
                   else{
                       echo "<h3>0 results</h3>";
                   } 
                ?>
            </div>
            
            <div>
                <?php
                    // order completed
                    echo "<h2>Your order completed: </h2>";
                    $sql = "SELECT * FROM orders WHERE repsid = '$rid' and orderstatus = 'Sold'";
                    $result = mysqli_query($conn,$sql);
                    $nrows = $result->num_rows;
                    if ($nrows > 0) 
                    {
                        $i = 1;
                        while ($row = $result->fetch_assoc()){
                            echo "<div><p>NO. " . $i . "</p>";
                            $i++;
                            echo "<p>Order ID: " . $row["oid"]. "</p>";
                            echo "<p>Order time: " . $row["orderdate"]. "</p>";
                            echo "<p>Number of N95 respirators: " . $row["n95num"]. "</p>";
                            echo "<p>Number of surgical masks: " . $row["surgicalnum"]. "</p>";
                            echo "<p>Number of surgical N95 respirators: " . $row["surgicaln95num"]. "</p>";
                            echo "<p>Amount: $" . $row["amount"]. "</p>";
                            echo "<p>Customer information: </p>";
                            // require("access.php");
                            $customer = $row["customer"];
                            $sql1 = "SELECT * FROM customer WHERE username = '$customer'";
                            $result1 = $conn->query($sql1);
                            while ($row1 = $result1 -> fetch_assoc()){
                                echo "<p>Customer ID: " . $row1["uid"]. "</p>";
                                echo "<p>Username: " . $row1["username"]. "</p>";
                                echo "<p>Real name: " . $row1["realname"]. "</p>";
                                echo "<p>Passport: " . $row1["passport"]. "</p>";
                                echo "<p>Email: " . $row1["email"]. "</p>";
                                echo "<p>Phone: " . $row1["phone"]. "</p></div>";
                            }
                        }
                    }
                    else{
                        echo "<h3>0 results</h3>";
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </div>
    </body>
</html>
