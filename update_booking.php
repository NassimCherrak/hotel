<?php

include 'include/login.php';

// guest, guestid(optional), room, roomid, datein, dateout(optional), bookingid
$data = $_POST;

$bookingid = $data['bookingid'];
$guest = $data['guestname'];
$room = $data['room'];
$roomid = $data['roomid'];
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
        AND (id_room != '". $roomid ."')
        AND	(
            (start_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR  (end_date BETWEEN '". $booking_time_in ."' AND '". $booking_time_out ."')
        OR ('". $booking_time_in ."' BETWEEN start_date AND end_date)
        OR ('" .$booking_time_out ."' BETWEEN start_date AND end_date)
        ))";
} elseif($booking_time_in != "") {
	$sql_check_available = "SELECT * FROM room WHERE name = '". $room ."' AND room.id NOT IN (SELECT id_room FROM booking WHERE end_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
		AND (id_room != '". $roomid ."')
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
	$sql_booking = "UPDATE booking SET id_guest='". $guestid ."', id_room='". $roomid ."', id_user='". $iduser ."', start_date='". $booking_time_in ."', end_date='". $booking_time_out ."' WHERE id=". $bookingid;

    if($conn->query($sql_booking) === TRUE) {
    	$display .= "Booking updated successfully!<br>";
	} else {
    	$display .= "Error when adding new Booking: " . $conn->error . "<br>";
	}

} else {
	$display .= "The room is already booked for that period";
}

$conn->close();

echo $display;
?>