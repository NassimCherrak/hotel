<?php

include 'include/login.php';

// guest, guestid(optional), room, roomid, datein, dateout(optional), id_user(need)
$data = $_POST;

$guest = $data['guestname'];
$room = $data['room'];
$booking_time_in = $data['datein'];
$booking_time_out = $data['dateout'];
$iduser = 1;


$display = "";

$sql = "";

$sql_check_guest = "SELECT * FROM guest WHERE name='". $guest ."'";

$check_guest = $conn->query($sql_check_guest);

$sql_check_available = "";


if($booking_time_in !="" && $booking_time_out != "") {
	$sql_check_available = "SELECT * FROM room WHERE name = '". $room ."' AND room.id NOT IN (SELECT id_room FROM booking WHERE end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        AND (
            (start_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR  (end_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR ('". $booking_time_in ."' BETWEEN start_date AND end_date)
        OR ('" .$booking_time_out ."' BETWEEN start_date AND end_date)
        ))";
} elseif($booking_time_in != "") {
	$sql_check_available = "SELECT * FROM room WHERE name = '". $room ."' AND room.id NOT IN (SELECT id_room FROM booking WHERE end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        AND '". $booking_time_in ."' BETWEEN start_date AND end_date
        )";
}

if($booking_time_out == "") {
	$booking_time_out = $booking_time_in;
}

$check_available = $conn->query($sql_check_available);

if(mysqli_num_rows($check_available) == 1) {
	$roomid = $check_available->fetch_array(MYSQLI_ASSOC)['id'];
	if(mysqli_num_rows($check_guest) == 0) {
		$sql = "INSERT INTO guest (name) VALUES ('". $guest ."')";
		if($conn->query($sql) === TRUE) {
    		$guestid = $conn->insert_id;
		} else {
    		$display .= "Error when adding new Guest: " . $conn->error . "<br>". $sql;
		}
	} else {
		$guestid = $check_guest->fetch_array(MYSQLI_ASSOC)['id'];
	}
	$sql_booking = "INSERT INTO booking (id_guest, id_room, id_user, start_date, end_date)
    				VALUES ('". $guestid ."', '". $roomid ."', '". $iduser ."', '". $booking_time_in ."', '". $booking_time_out ."')";
    if($conn->query($sql_booking) === TRUE) {
    	$display .= "Booking added successfully!<br>";
	} else {
    	$display .= "Error when adding new Booking: " . $conn->error . "<br>";
	}

} else { 
  $display .= "The room is not available during that period.";
}

$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/logo.jpg">

    <title>Hotel Booking</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="style/main.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script type="text/javascript" src="js/viewbooking.js"></script>
  </head>
  <body ng-app="AApp" ng-controller="ACtrl">

    <div class="container">
      <header class="blog-header py-3" ng-include="'layout/header.html'">
      </header>
      <div class="nav-scroller py-1 mb-2" ng-include="'layout/menu.html'">
    </div>
    <main>
      <section class="jumbotron text-center" ng-if="viewbooking">
        <div class="center-message"><?=$display ?></div>
        </section>
    </main>
  </body>
</html>