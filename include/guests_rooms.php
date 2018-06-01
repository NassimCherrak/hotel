<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'login.php';

//query to get the list of guests
$sql = "SELECT * FROM guest";

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"name":"'. $rs["name"] . '",';
    $outp .= '"id":"'. $rs["id"] . '"}';
}

$outp1 ='{"guestdata":['.$outp.'],';

//query to get he list of rooms
$sql = "SELECT * FROM room";

$result = $conn->query($sql);

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"name":"'. $rs["name"] . '",';
    $outp .= '"id":"'. $rs["id"] . '"}';
}

$outp2 = $outp1 . '"roomdata":['.$outp.']}';

$conn->close();

echo($outp2);
?>