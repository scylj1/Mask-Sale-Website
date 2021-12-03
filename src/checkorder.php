<!DOCTYPE html>
<html>
    <head>
        <title>Checking order</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
        <?php
            $id = $_REQUEST["order"];
            require("access.php");
            // check if the order ID exists
            $sql = "SELECT * FROM orders, customer WHERE oid = '$id' and orders.customer = customer.username";
            $result = mysqli_query($conn,$sql);
            $nrows = $result->num_rows;
            if ($nrows > 0) {
                // print the order can customers' information
                while ($row = $result->fetch_assoc()){
                    echo "<p>Order ID: " . $row["oid"]. "</p>";
                    echo "<p>Order time: " . $row["orderdate"]. "</p>";
                    echo "<p>Number of N95 respirators: " . $row["n95num"]. "</p>";
                    echo "<p>Number of surgical masks: " . $row["surgicalnum"]. "</p>";
                    echo "<p>Number of surgical N95 respirators: " . $row["surgicaln95num"]. "</p>";
                    echo "<p>Amount: $" . $row["amount"]. "</p>";
                    echo "<p>Customer information: </p>";
                    echo "<p>Customer ID: " . $row["uid"]. "</p>";
                    echo "<p>Username: " . $row["username"]. "</p>";
                    echo "<p>Real name: " . $row["realname"]. "</p>";
                    echo "<p>Passport: " . $row["passport"]. "</p>";
                    echo "<p>Email: " . $row["email"]. "</p>";
                    echo "<p>Phone: " . $row["phone"]. "</p>";
                }
            }
            else{
                echo "<h3>0 results</h3>";
            }
            $conn->close();
        ?>
        
        <a href = "manager.php" id = "back"> Back </a>
    </div>
    </body>
</html>
