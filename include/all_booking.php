<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

$page = 1;
if(!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if(false === $page) {
        $page = 1;
    }
}

$items_per_page = 5;

$offset = ($page - 1) * $items_per_page;

$sql = "SELECT booking.id, booking.start_date, booking.end_date, guest.name as guest, booking.id_guest as idguest, room.name as room, booking.id_room as idroom, user.name as user FROM booking 
		INNER JOIN guest ON guest.id = booking.id_guest
		INNER JOIN room ON room.id = booking.id_room
		INNER JOIN user ON user.id = booking.id_user
		WHERE booking.end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
		LIMIT " . $offset . "," . $items_per_page;

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"id":"'  . $rs["id"] . '",';
    $outp .= '"start":"'. $rs["start_date"] . '",';
    $outp .= '"end":"'. $rs["end_date"] . '",';
    $outp .= '"guest":"'. $rs["guest"] . '",';
    $outp .= '"idguest":"'. $rs["idguest"] . '",';
    $outp .= '"room":"'. $rs["room"] . '",';
    $outp .= '"idroom":"'. $rs["idroom"] . '",';
    $outp .= '"user":"'. $rs["user"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>