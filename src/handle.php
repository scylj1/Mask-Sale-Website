<!DOCTYPE html>
<html>
    <head>
        <title>Delete</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
    <?php
            require("access.php");
            $id = $_REQUEST["id"];
            // delete the anomalies
            $sql = "UPDATE orders SET repsquota = '0' WHERE oid = '$id'";
            $result=mysqli_query($conn,$sql);
            if($result==true){ 
                echo "<p>Deleted successfully.</p>";
                header("Refresh:2;url=manager.php");
                $conn->close(); 
                exit();
            }
            else {
                echo "<p>Deleted failed.</p>";
            }
            $conn->close();
        ?>
        <a href = "manager.php" id = "back"> Back </a>
    </div>
    </body>
</html>
