<!DOCTYPE html>
<html>
    <head>
        <title> Welcome Manager </title>
        <link rel="stylesheet" type="text/css" href="manager.css"/>
        <script type="text/javascript" src="manager.js"></script>
    </head>
    <body>
    <div id = "page">
        <?php
            session_start();
            $uname = $_SESSION["uname"];
            // update database
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
            <h2> Welcome Manager </h2>
        </section>
        <section id = "abnormal">
            <h2> Abnormal ordering </h2>
            <div>
            <?php
                // notice anormaly
                $sql = "SELECT * FROM orders WHERE orderstatus = 'Sold' and repsquota<0";
                $result = mysqli_query($conn,$sql);
                $nrows = $result->num_rows;
                $a1 = 0;
                $a2 = 0;
                $a3 = 0;
                if ($nrows > 0) {
                    echo "<p>Anomalies: ". "</p>";
                    while ($row = $result->fetch_assoc()){
                        $oid = $row["oid"];
                        $rid = $row["rid"];
                        echo "<form action = 'handle.php' method = 'post'><p>Order ID: " . $oid ." - Reps ID: " . $rid . " - Remaining quota after this order: " . $row["repsquota"] . "<input type = 'hidden' name = 'id' value = '$oid'><input type = 'submit' value = 'DELETE' id = 'delete'></p></form>";                        
                        $a1 += $row["n95num"]*1;
                        $a2 += $row["surgicalnum"]*1;
                        $a3 += $row["surgicaln95num"]*1;
                    }
                    $anormal = $a1 + $a2 + $a3;
                }
                else{
                    echo "<p>No anomalies.</p>";
                }
            ?>
            </div>
        </section>
        
        <section id = "statistic">
            <h2> Statistics</h2>
            <div>
                <div>
                <?php
                    echo"<h2> Masks statistics: </h2>";
                    // total no. of masks sold (w/ or w/o anomalies), total revenues
                    $sql = "SELECT * FROM orders WHERE orderstatus = 'Sold'";
                    $result = mysqli_query($conn,$sql);
                    $nrows = $result->num_rows;
                    $w1 = 0;
                    $w2 = 0;
                    $w3 = 0;
                    if ($nrows > 0) {
                        while ($row = $result->fetch_assoc()){
                            $w1 += $row["n95num"]*1;
                            $w2 += $row["surgicalnum"]*1;
                            $w3 += $row["surgicaln95num"]*1;
                        }
                    }
                    $w = $w1 + $w2 + $w3;
                    echo "<div><p>Total no. of masks sold:</p></div><p>With anomalies: ". $w ."</p><p>Without anomalies: " . ($w-$anormal)."</p>";
                ?>
                <!-- Draw gragh -->
                <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo $w?></p> 
                            <div style="height:
                                <?php if ($w > ($w-$anormal)){$height = 150;}
                                      else {$height=floor(($w/($w-$anormal))*150);}
                                      echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo ($w-$anormal)?></p> 
                            <div style="height:
                                <?php if ($w > ($w-$anormal)){$height=floor((($w-$anormal)/$w)*150);}
                                      else {$height=150;}
                                      echo $height.'px'?>"></div>
                        </td>  
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>w/</p></td> 
                        <td><p>w/o</p></td> 
                    </tr> 
                </table>
                <div><p>Masks sold without anomalies:</p></div>
                <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo ($w1 -$a1)?></p> 
                            <div style="height:
                                <?php
                                    if ((($w1 -$a1)>($w2-$a2)) && (($w1 -$a1) > ($w3-$a3))){$height = 150;}
                                    else if ((($w2 -$a2)>($w1-$a1)) && (($w2 -$a2) > ($w3-$a3))){$height=floor((($w1-$a1)/($w2 -$a2))*150);}
                                    else {$height=floor((($w1-$a1)/($w3 -$a3))*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo ($w2-$a2)?></p> 
                            <div style="height:
                                <?php
                                    if ((($w1 -$a1)>($w2-$a2)) && (($w1 -$a1) > ($w3-$a3))){$height=floor((($w2-$a2)/($w1 -$a1))*150);}
                                    else if ((($w2 -$a2)>($w1-$a1)) && (($w2 -$a2) > ($w3-$a3))){$height=150;}
                                    else {$height=floor((($w2-$a2)/($w3 -$a3))*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo ($w3-$a3)?></p> 
                            <div style="height:
                                <?php 
                                    if ((($w1 -$a1)>($w2-$a2)) && (($w1 -$a1) > ($w3-$a3))){$height=floor((($w3-$a3)/($w1 -$a1))*150);}
                                    else if ((($w2 -$a2)>($w1-$a1)) && (($w2 -$a2) > ($w3-$a3))){$height=floor((($w3-$a3)/($w2 -$a2))*150);}
                                    else {$height = 150;}
                                    echo $height.'px'?>"></div> 
                        </td>
                    </tr> 
                    <tr align="center" valign="top">
                        <td><p>N95</p></td> 
                        <td><p>Surgical</p></td>
                        <td><p>Surgical N95</p></td>
                    </tr> 
                </table>
                <?php
                    // calculate revenue and draw gragh
                    $revenue1 = (($w1-$a1)*2-1);
                    $revenue2 = (($w2-$a2)*1-0.5);
                    $revenue3 = (($w3-$a3)*3-2);
                    $revenue = $revenue1 + $revenue2 + $revenue3;
                    echo "<div><p>Total revenue without anomalies: </div>$" .$revenue ."</p>";
                ?>
                <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo "$".$revenue1?></p> 
                            <div style="height:
                                <?php
                                    if (($revenue1>$revenue2) && ($revenue1 > $revenue3)){$height = 150;}
                                    else if (($revenue2>$revenue1) && ($revenue2 > $revenue3)){$height=floor(($revenue1/$revenue2)*150);}
                                    else {$height=floor(($revenue1/$revenue3)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo "$".$revenue2?></p> 
                            <div style="height:
                                <?php
                                    if (($revenue1>$revenue2) && ($revenue1 > $revenue3)){$height=floor(($revenue2/$revenue1)*150);}
                                    else if (($revenue2>$revenue1) && ($revenue2 > $revenue3)){$height=150;}
                                    else {$height=floor(($revenue2/$revenue3)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo "$".$revenue3?></p> 
                            <div style="height:
                                <?php 
                                    if (($revenue1>$revenue2) && ($revenue1 > $revenue3)){$height=floor(($revenue3/$revenue1)*150);}
                                    else if (($revenue2>$revenue1) && ($revenue2 > $revenue3)){$height=floor(($revenue3/$revenue2)*150);}
                                    else {$height = 150;}
                                    echo $height.'px'?>"></div> 
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>N95</p></td> 
                        <td><p>Surgical</p></td>
                        <td><p>Surgical N95</p></td>
                    </tr> 
                </table>
                
                <?php
                // masks under ordering
                $sql = "SELECT * FROM orders WHERE orderstatus = 'Processing'";
                $result = mysqli_query($conn,$sql);
                $nrows = $result->num_rows;
                $n95 = 0;
                $surgical = 0;
                $surgicaln95 = 0;
                if ($nrows > 0) {
                    while ($row = $result->fetch_assoc()){
                              $n95 += $row["n95num"]*1;
                        $surgical += $row["surgicalnum"]*1; 
                        $surgicaln95 += $row["surgicaln95num"]*1;
                    }
                }
                echo "<div><p>Masks under ordering: </p></div><p>N95 respirators: " . $n95 . "</p><p>Surgical masks: " . $surgical ."</p><p>Surgical N95 respirators: " .$surgicaln95 ."</p>";
                ?>
                <!-- Draw gragh -->
                <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo $n95?></p> 
                            <div style="height:
                                <?php
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height = 150;}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=floor(($n95/$surgical)*150);}
                                    else {$height=floor(($n95/$surgicaln95)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo $surgical?></p> 
                            <div style="height:
                                <?php
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height=floor(($surgical/$n95)*150);}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=150;}
                                    else {$height=floor(($surgical/$surgicaln95)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo $surgicaln95?></p> 
                            <div style="height:
                                <?php 
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height=floor(($surgicaln95/$n95)*150);}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=floor(($surgicaln95/$surgical)*150);}
                                    else if ($surgicaln95!=0){$height = 150;}
                                    echo $height.'px'?>"></div> 
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>N95</p></td> 
                        <td><p>Surgical</p></td>
                        <td><p>Surgical N95</p></td>
                    </tr> 
                </table>
                </div>
                
                <div>
                    <?php
                        // customer statistics
                        echo "<h2>Customers statistics: </h2>";
                        $sql = "SELECT * FROM customer";
                        $result = mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        $count1 = 0;
                        $count2 = 0;
                        $count3 = 0;
                        $count4 = 0;
                        if ($nrows > 0) {
                            while ($row = $result->fetch_assoc()){
                                if ($row["region"] == "China"){
                                    $count1++;
                                }
                                if ($row["region"] == "America"){
                                    $count2++;
                                }
                                if ($row["region"] == "Japan"){
                                    $count3++;
                                }
                                if ($row["region"] == "UK"){
                                    $count4++;
                                }
                            }
                        }
                        $total = $count1 + $count2 + $count3 + $count4;
                        echo "<div><p>Total number of customers: " . $total . "</p></div><p>Customers in China: " . $count1 . "</p><p>Customers in America: " . $count2 ."</p><p>Customers in Japan: " . $count3 ."</p><p>Customers in UK: " . $count4 ."</p>";            
                    ?>
                    <!-- Draw gragh -->
                    <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo $count1?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height = 150;}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count1/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count1/$count3)*150);}
                                    else {$height=floor(($count1/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo $count2?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count2/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=150;}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count2/$count3)*150);}
                                    else {$height=floor(($count2/$count4)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo $count3?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count3/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count3/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=150;}
                                    else {$height=floor(($count3/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td>
                        <td> 
                            <p><?php echo $count4?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count4/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count4/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count4/$count3)*150);}
                                    else if ($count4 != 0){$height=150;}
                                    echo $height.'px'?>"></div>
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>China</p></td> 
                        <td><p>America</p></td>
                        <td><p>Japan</p></td>
                        <td><p>UK</p></td>
                    </tr> 
                    </table>
                    <!-- Average number of masks sold to a customer -->
                    <div><p>Average number of masks sold to a customer (without anomalies):</p></div>
                    <?php
                        $n95 = ($w1 - $a1)/$total;
                        $surgical = ($w2 - $a2)/$total;
                        $surgicaln95 = ($w3 - $a3)/$total;
                    ?>
                    <!-- draw gragh -->
                    <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo number_format($n95,2) ?></p> 
                            <div style="height:
                                <?php
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height = 150;}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=floor(($n95/$surgical)*150);}
                                    else {$height=floor(($n95/$surgicaln95)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo number_format($surgical, 2) ?></p> 
                            <div style="height:
                                <?php
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height=floor(($surgical/$n95)*150);}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=150;}
                                    else {$height=floor(($surgical/$surgicaln95)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo number_format($surgicaln95, 2)?></p> 
                            <div style="height:
                                <?php 
                                    if (($n95>$surgical) && ($n95 > $surgicaln95)){$height=floor(($surgicaln95/$n95)*150);}
                                    else if (($surgical>$n95) && ($surgical > $surgicaln95)){$height=floor(($surgicaln95/$surgical)*150);}
                                    else {$height = 150;}
                                    echo $height.'px'?>"></div> 
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>N95</p></td> 
                        <td><p>Surgical</p></td>
                        <td><p>Surgical N95</p></td>
                    </tr> 
                </table>
                <!-- Masks sold in regions -->
                <div><p>Masks sold in regions (without anomalies):</p></div>
                <?php
                $sql = "SELECT * FROM orders,reps WHERE orderstatus = 'Sold' and rid = repsid";
                $result = mysqli_query($conn,$sql);
                $nrows = $result->num_rows;
                $count1 = 0;
                $count2 = 0;
                $count3 = 0;
                $count4 = 0;
                if ($nrows > 0) {
                    while ($row = $result->fetch_assoc()){
                        if ($row["region"] == "China"){
                            $count1 += $row["n95num"]*1 + $row["surgicalnum"]*1 + $row["surgicaln95num"]*1;
                        }
                        if ($row["region"] == "America"){
                            $count2 += $row["n95num"]*1 + $row["surgicalnum"]*1 + $row["surgicaln95num"]*1;
                        }
                        if ($row["region"] == "Japan"){
                            $count3 += $row["n95num"]*1 + $row["surgicalnum"]*1 + $row["surgicaln95num"]*1;
                        }
                        if ($row["region"] == "UK"){
                            $count4 += $row["n95num"]*1 + $row["surgicalnum"]*1 + $row["surgicaln95num"]*1;
                        }
                    }
                }
                ?>
                <!-- draw gragh -->
                <table border="0"> 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo $count1?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height = 150;}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count1/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count1/$count3)*150);}
                                    else {$height=floor(($count1/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo $count2?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count2/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=150;}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count2/$count3)*150);}
                                    else {$height=floor(($count2/$count4)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo $count3?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count3/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count3/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=150;}
                                    else {$height=floor(($count3/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td>
                        <td> 
                            <p><?php echo $count4?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count4/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count4/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count4/$count3)*150);}
                                    else if ($count4 != 0){$height=150;}
                                    echo $height.'px'?>"></div>
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>China</p></td> 
                        <td><p>America</p></td>
                        <td><p>Japan</p></td>
                        <td><p>UK</p></td>
                    </tr> 
                    </table>
                    
                    <div><p>Reps in regions:</p></div>
                    <?php
                        $sql = "SELECT * FROM reps";
                        $result = mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        $count1 = 0;
                        $count2 = 0;
                        $count3 = 0;
                        $count4 = 0;
                        if ($nrows > 0) {
                            while ($row = $result->fetch_assoc()){
                                if ($row["region"] == "China"){
                                    $count1++;
                                }
                                if ($row["region"] == "America"){
                                    $count2++;
                                }
                                if ($row["region"] == "Japan"){
                                    $count3++;
                                }
                                if ($row["region"] == "UK"){
                                    $count4++;
                                }
                            }
                        }
                    ?>
                    <!-- draw gragh -->
                    <table border="0" > 
                    <tr align="center" valign="bottom"> 
                        <td> 
                            <p><?php echo $count1?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height = 150;}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count1/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count1/$count3)*150);}
                                    else {$height=floor(($count1/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td> 
                        <td> 
                            <p><?php echo $count2?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count2/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=150;}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count2/$count3)*150);}
                                    else {$height=floor(($count2/$count4)*150);}
                                    echo $height.'px'?>"></div>
                        </td> 
                        <td> 
                            <p><?php echo $count3?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count3/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count3/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=150;}
                                    else {$height=floor(($count3/$count4)*150);}
                                    echo $height.'px'?>"></div> 
                        </td>
                        <td> 
                            <p><?php echo $count4?></p> 
                            <div style="height:
                                <?php
                                    if (($count1>$count2) && ($count1 > $count3) && ($count1>$count4)){$height=floor(($count4/$count1)*150);}
                                    else if (($count2>$count1) && ($count2 > $count3) && ($count2>$count4)){$height=floor(($count4/$count2)*150);}
                                    else if (($count3>$count1) && ($count3 > $count2) && ($count3>$count4)){$height=floor(($count4/$count3)*150);}
                                    else if ($count4 != 0){$height=150;}
                                    echo $height.'px'?>"></div>
                        </td>
                    </tr> 
                    <tr align="center" valign="top"> 
                        <td><p>China</p></td> 
                        <td><p>America</p></td>
                        <td><p>Japan</p></td>
                        <td><p>UK</p></td>
                    </tr> 
                    </table>
                </div>
            </div>
        </section>
        
        <section id = "assign">
            <h2> Assign reps </h2>
            <div>
                <div>
                    <form action = "assignreps.php" method = "post" onsubmit = "return checkform1()">
                        <p id = "subtitle"> You can choose one user and assign to sale representativies </p>
                        <p><label class = "prompt"> User ID: <input type="text" id="user" name="user" class = "input"></label></p>
                        <p class = "prompt">Region: 
                        <label class = "button"> <input type = "radio" value = "China" name = "region" id = "region1">China</label>
                        <label class = "button"> <input type = "radio" value = "America" name = "region" id = "region2">America</label>
                        <label class = "button"> <input type = "radio" value = "Japan" name = "region" id = "region3">Japan</label>
                        <label class = "button"> <input type = "radio" value = "UK" name = "region" id = "region4">UK</label>
            
                        <p><label class = "prompt"> Quota: <input type="text" id="quota" name="quota" class = "input"></label>
                        <input type="submit" value="Assign" id = "confirm"></p>
                    </form>
                </div>
                <div id = "users">
                    <?php
                        // Registered users
                        $sql = "SELECT * FROM customer";
                        $result = mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        if ($nrows > 0) {
                            echo "<p>All registered users: " . "</p>";
                            while ($row = $result->fetch_assoc()){
                                echo "<p>User ID: " . $row["uid"] ." - Username: " . $row["username"] . "</p>";                
                            }
                        }
                    ?>
                </div>
            </div>
        </section>
        
        <section id = "assign">
            <h2> Update & Re-grant quota </h2>
            <div>
                <div>
                    <form action = "setquota.php" method = "post" onsubmit = "return checkform2()">
                           <p id = "subtitle"> You can update a representative's quota </p>
                           <p><label class = "prompt"> Reps ID: <input type="text" id="reps1" name="reps" class = "input"></label></p>
                        <p><label class = "prompt"> Quota: <input type="text" id="quota2" name="quota" class = "input"></label>
                        <input type="submit" value="Confirm" id = "confirm"></p>
                    </form>
                    
                    <form action = "regrantquota.php" method = "post" onsubmit = "return checkform3()">
                           <p id = "subtitle"> You can re-grant a representative's quota with 20,000</p>
                           <p><label class = "prompt"> Reps ID: <input type="text" id="reps2" name="reps" class = "input" ></label>
                        <input type="submit" value="Confirm" id = "confirm"></p>
                    </form>
                </div>
                <div id = "users">
                    <?php
                        // All reps
                        $sql = "SELECT * FROM reps";
                        $result = mysqli_query($conn,$sql);
                        $nrows = $result->num_rows;
                        if ($nrows > 0) {
                            echo "<p>All sale representatives: " . "</p>";
                            while ($row = $result->fetch_assoc()){
                                echo "<p>Reps ID: " . $row["rid"] ." - Region: " . $row["region"] . " - Quota: " . $row["quota"] . "</p>";                
                            }
                        }
                        $conn->close();
                    ?>
                </div>
            </div>
        </section>
                
        <section id = "condition">
            <h2>Check masks sold in specific condition</h2>
            <div>
            <form action = "checkorder.php" method = "post" onsubmit = "return checkorder()">
                <p class = "prompt"> Check the specific ordering</p>
                <p><label class = "prompt"> The order ID : <input type="text" id="order" name="order" class = "input"></label>
                <input type="submit" value="Confirm" id = "confirm"></p>
            </form>
            </div>
            
            <div>
            <form action = "repsmask.php" method = "post" onsubmit = "return checkreps3()">
                <p class = "prompt"> Check the number of masks sold by a specific representative(without anomalies).</p>
                <p><label class = "prompt"> Reps ID : <input type="text" id="reps3" name="reps" class = "input"></label>
                <input type="submit" value="Confirm" id = "confirm"></p>
            </form>
            </div>
            <div>
            <form action = "regionmask.php" method = "post" onsubmit = "return checkregion2()">
                <p class = "prompt"> You can choose one region to check the masks sold there(without anomalies): </p>
                <p class = "prompt"><label class = "button"> <input type = "radio" value = "China" name = "region" id = "region5">China</label>
                <label class = "button"> <input type = "radio" value = "America" name = "region" id = "region6">America</label>
                <label class = "button"> <input type = "radio" value = "Japan" name = "region" id = "region7">Japan</label>
                <label class = "button"> <input type = "radio" value = "UK" name = "region" id = "region8">UK</label>
                <input type="submit" value="Confirm" id = "confirm"></p>
            </form>
            </div>
                   
            <div>
            <form action = "weekmask.php" method = "post" onsubmit = "return checkweek()">
                <p class = "prompt"> Check the number of masks sold in past weeks(without anomalies).</p>
                <p><label class = "prompt"> The number of weeks passed : <input type="text" id="week" name="week" class = "input"></label>
                <input type="submit" value="Confirm" id = "confirm"></p>
            </form>
            </div>
        </section>
        <div id = "bottom"> <a href = "login.html" id = "back"> Back to login </a> </div>
    <div>
    </body>
</html>
