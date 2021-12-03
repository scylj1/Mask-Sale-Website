<!DOCTYPE html>
<html>
    <head>
        <title> Welcome customer </title>
        <link rel="stylesheet" type="text/css" href="customer.css"/>
        <script type="text/javascript" src="order.js"></script>
    </head>
    <body>
    <div id = "page">
        <?php
            session_start();
            $uname = $_SESSION["uname"];
            require("access.php");
            // Update database
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
            <h2> Welcome Customers</h2>
        </section>
        <section id = "makeorder">
            <div>
                <div>
                    <form action = "order.php" method = "post" onsubmit = "return checkform()">
                        <div id = "make"> Make a new order: </div>
                        <p><label class = "prompt"> Number of N95 respirators($2): <input type = "text" id = "num1" name = "num1" class = "input"></label></p>
                        <p><label class = "prompt"> Number of surgical masks($1): <input type = "text" id = "num2" name = "num2" class = "input"></p></label>
                        <p><label class = "prompt"> Number of surgical N95 respirators($3): <input type = "text" id = "num3" name = "num3" class = "input"></p></label>
                        <p><label class = "prompt"> Select 1 sale representation in your region with Id: <input type = "text" id = "reps" name = "reps" class = "input"></label> </p>
                        <?php                
                            $sql="SELECT rid, reps.region, quota FROM reps, customer WHERE customer.username = '$uname' and customer.region = reps.region";
                            $result=mysqli_query($conn,$sql);        
                            while ($row = $result->fetch_assoc()){
                                   echo "<p class = 'repid'>Id: " . $row["rid"]. " - Region: " . $row["region"]. " - Quota: " . $row["quota"] . "</p>";
                            }
                        ?>
                        <p><input type = "submit" value = "Submit" id = "submit"></p>
                    </form>
                </div>
                
                <div>
                    <div id = "person">
                    <?php
                        // personal information
                        $sql = "SELECT * FROM customer WHERE username = '$uname'";
                        $result = mysqli_query($conn,$sql);
                        $row = $result->fetch_assoc();
                        echo "<p>Your information: </p>";
                        echo "<p>Username: " . $row["username"]. "</p>";
                        echo "<p>Realname: " . $row["realname"] . "</p>";
                        echo "<p>Passport: " . $row["passport"] ."</p>";
                        echo "<p>Email: " . $row["email"] . "</p>";
                        echo "<p>Phone: " . $row["phone"] ."</p>";
                        echo "<P>Region: " . $row["region"]. "</p>";
                        echo "<p><a href = 'update.html' id = 'back'> Update information </a><p>";
                        echo "<p><a href = 'login.html' id = 'back'> Back to login </a><p>";
                    ?>
                    </div>
                </div>
            </div>
        </section>
        
        <div id = "pastorder">
            <div id = "subtitle"> Your past orders:</div>
            <form action = "cancelorder.php" method = "post" onsubmit = "return checknum5()">
                <p><label class = "prompt"> You can cancel an order within one day. If you want to cancel an order, please input the order ID: <input type = "text" id = "order" name = "order" class = "input2"></label>
                <input type = "submit" value = "Confirm" id = "confirm"></p>
            </form>            
            <div id = "seperate">
                <div>
                    <?php
                        // print past orders on the left
                        $sql="SELECT * FROM orders WHERE customer = '$uname'";
                        $result=mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        if ($nrows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()){
                                if($i % 2 == 1){
                                    echo "<div><p>NO. " . $i . "</p>";
                                    echo "<p>Order ID: " . $row["oid"]. "</p>";
                                    echo "<P>Order time: " . $row["orderdate"]. "</p>";
                                    echo "<p>Number of N95 respirators: " . $row["n95num"]. "</p>";
                                    echo "<p>Number of surgical masks: " . $row["surgicalnum"]. "</p>";
                                    echo "<p>Number of surgical N95 respirators: " . $row["surgicaln95num"]. "</p>";
                                    echo "<p>Amount: $" . $row["amount"]. "</p>";
                                    echo "<p>Sale Represent ID: " . $row["repsid"]. "</p>";
                                    echo "<p>Order Status: " . $row["orderstatus"]. "</p></div>";
                                }
                                $i++;
                            }
                        }
                        else{
                            echo "0 results";
                        }
                    ?>
                </div>
                <div>
                    <?php
                        // print past orders on the right
                        $sql="SELECT * FROM orders WHERE customer = '$uname'";
                        $result=mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        if ($nrows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()){
                                if($i % 2 == 0){
                                    echo "<div><p>NO. " . $i . "</p>";
                                    echo "<p>Order ID: " . $row["oid"]. "</p>";
                                    echo "<P>Order time: " . $row["orderdate"]. "</p>";
                                    echo "<p>Number of N95 respirators: " . $row["n95num"]. "</p>";
                                    echo "<p>Number of surgical masks: " . $row["surgicalnum"]. "</p>";
                                    echo "<p>Number of surgical N95 respirators: " . $row["surgicaln95num"]. "</p>";
                                    echo "<p>Amount: $" . $row["amount"]. "</p>";
                                    echo "<p>Sale Represent ID: " . $row["repsid"]. "</p>";
                                    echo "<p>Order Status: " . $row["orderstatus"]. "</p></div>";
                                }
                                $i++;
                            }
                        }
                        $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
