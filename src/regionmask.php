<!DOCTYPE html>
<html>
    <head>
        <title>Masks in a region</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
        <div id = "page">
            <?php
                $region = $_REQUEST["region"];

                require("access.php");
                $sql = "SELECT * FROM orders,reps WHERE orderstatus = 'Sold' and repsid = rid and region = '$region' and repsquota >= 0";
                $result = mysqli_query($conn,$sql);
                $nrows = $result->num_rows;
                $n95 = 0;
                $surgical = 0;
                $surgicaln95 = 0;
                $revenue = 0;
                if ($nrows > 0) {
                    while ($row = $result->fetch_assoc()){
                        $n95 += $row["n95num"]*1;
                        $surgical += $row["surgicalnum"]*1; 
                        $surgicaln95 += $row["surgicaln95num"]*1;
                    }
                }
                echo "<p>Masks sold in " . $region . " : </p><p>N95 respirators: " . $n95 . "</p><p>Surgical masks: " . $surgical ."</p><p>Surgical N95 respirators: " .$surgicaln95 ."</p>";
                $conn->close();
            ?>
            <a href = "manager.php" id = "back"> Back </a>
        </div>
    </body>
</html>
