<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

//query to get the guest information and the number of times they booked a room in the hotel
$sql = "SELECT guest.name as name, guest.id as id, COUNT(*) as c FROM booking INNER JOIN guest ON guest.id = booking.id_guest GROUP BY booking.id_guest";

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"name":"'. $rs["name"] . '",';
    $outp .= '"id":"'. $rs["id"] . '",';
    $outp .= '"number":"'. $rs["c"] . '"}';
}

$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>