<!DOCTYPE html>
<html>
    <head>
        <title>Masks sold in the past weeks</title>
        <link rel="stylesheet" type="text/css" href="check.css"/>
    </head>
    <body>
    <div id = "page">
        <?php
            $week = $_REQUEST["week"];
            $day = $week * 7;
            require("access.php");
            $sql = "SELECT * FROM orders WHERE orderstatus = 'Sold' and now() <= date_add(orderdate, interval '$day' day) and repsquota >= 0";
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
            echo "<p>Masks sold in the past " . $week . " weeks: </p><p>N95 respirators: " . $n95 . "</p><p>Surgical masks: " . $surgical ."</p><p>Surgical N95 respirators: " .$surgicaln95 ."</p>";           
            $conn->close();
        ?>
        <a href = "manager.php" id = "back"> Back </a>
    </div>
    </body>
</html>
