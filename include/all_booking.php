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

$items_per_page = 3;

$number_of_pages = 1;

$offset = ($page - 1) * $items_per_page;

$sql_count = "SELECT COUNT(*) as c FROM booking";
$sql_count .= " WHERE end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";

$sql = "SELECT booking.id, booking.start_date, booking.end_date, guest.name as guest, booking.id_guest as idguest, room.name as room, booking.id_room as idroom, user.name as user FROM booking 
		INNER JOIN guest ON guest.id = booking.id_guest
		INNER JOIN room ON room.id = booking.id_room
		INNER JOIN user ON user.id = booking.id_user";
$sql .= " WHERE booking.end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
$sql .= " LIMIT " . $offset . "," . $items_per_page;

$pages_request = $conn->query($sql_count);

$result = $conn->query($sql);

$total_result = $pages_request->fetch_array(MYSQLI_ASSOC)['c'];

$number_of_pages = (int)ceil(intval($total_result) / $items_per_page);

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
$outp ='{"records":['.$outp.'], "pages": "'. $number_of_pages .'"}';
$conn->close();

echo($outp);
?>