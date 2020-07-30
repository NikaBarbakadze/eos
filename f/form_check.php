<?php
include __DIR__ . "/conn.php";


$sql = "SELECT  Our_Rate FROM rates WHERE VALUTE='{$_POST['valute']}'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       echo $row["Our_Rate"];
    }
}else{}

?>