<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

//number of guests
$sql_guest = "SELECT COUNT(*) as c FROM guest";

//past bookings
$sql_booking_past = "SELECT COUNT(*) as bp FROM booking WHERE end_date < DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
//currently booked rooms
$sql_booking_current = "SELECT COUNT(*) as bc FROM booking WHERE DATE_SUB(NOW(), INTERVAL 15 MINUTE) BETWEEN start_date AND end_date";
//future bookings
$sql_booking_future = "SELECT COUNT(*) as bf FROM booking WHERE start_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";

$outp = "";

$result_store = [];

$result = $conn->query($sql_guest);
$result_store['c'] = $result->fetch_array(MYSQLI_ASSOC)['c'];
$outp .= '{"guests":"'. $result_store["c"] . '",';

$result = $conn->query($sql_booking_past);
$result_store['bp'] = $result->fetch_array(MYSQLI_ASSOC)['bp'];
$outp .= '"past":"'. $result_store["bp"] . '",';

$result = $conn->query($sql_booking_current);
$result_store['bc'] = $result->fetch_array(MYSQLI_ASSOC)['bc'];
$outp .= '"current":"'. $result_store["bc"] . '",';

$result = $conn->query($sql_booking_future);
$result_store['bf'] = $result->fetch_array(MYSQLI_ASSOC)['bf'];
$outp .= '"future":"'. $result_store["bf"] . '"}';


$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>