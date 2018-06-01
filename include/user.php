<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

$guest = $_GET['id'];

//query to get the booking history of a guest
$sql = "SELECT booking.id, booking.start_date, booking.end_date, guest.name as guest, room.name as room, user.name as user FROM booking 
		INNER JOIN guest ON guest.id = booking.id_guest
		INNER JOIN room ON room.id = booking.id_room
		INNER JOIN user ON user.id = booking.id_user
		WHERE guest.id = ". $guest;

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"room":"'. $rs["room"] . '",';
    $outp .= '"start":"'. $rs["start_date"] . '",';
    $outp .= '"end":"'. $rs["end_date"] . '"}';
}

$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>