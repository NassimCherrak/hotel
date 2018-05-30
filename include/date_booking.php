<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

$booking_time_in = $_GET['timein'];
$booking_time_out = $_GET['timeout'];

$sql = "SELECT name, room.id as room FROM room WHERE room.id NOT IN (SELECT id_room FROM booking WHERE end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        AND (
            (start_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR  (end_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR ('". $booking_time_in ."' BETWEEN start_date AND end_date)
        OR ('" .$booking_time_out ."' BETWEEN start_date AND end_date)
        ))";

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"room":"'. $rs["name"] . '",';
    $outp .= '"id":"'. $rs["room"] . '"}';
}

$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>