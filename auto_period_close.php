<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ttop2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$all_periods_sql = "SELECT `p`.*, `r`.`region_name`, `p`.`region_id` FROM `period_closing` as `p` INNER JOIN `region` as `r` ON `p`.`region_id`=`r`.`reg_id`";
$all_periods = $conn->query($all_periods_sql);
if ($all_periods->num_rows > 0) {
    foreach ($all_periods as $period) {
        if ($period['to_date'] < date('Y-m-d') && $period['status']==1) {
//            echo $period['to_date'] . "<br/>";
            $sql = "UPDATE `period_closing` SET `status` = 2 WHERE `period_id` = '" . $period['period_id'] . "' ";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
}


