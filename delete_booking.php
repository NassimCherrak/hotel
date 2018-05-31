<?php

include 'include/login.php';

$bookid = json_decode($_POST['bookingdel']);

$sql = 'DELETE FROM booking WHERE id =' . $bookid;

$res = $conn->query($sql);


$conn->close();

?>