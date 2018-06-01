<?php

include 'include/login_index.php';

//initialize the database with starting information
$conn->query("CREATE DATABASE IF NOT EXISTS ". $dbname); 

mysqli_select_db($conn, $dbname);

$sql_user = "CREATE TABLE ". $dbname .".user (
 			id INT(11) UNSIGNED AUTO_INCREMENT, 
  			name VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
  			);";

$sql_room = "CREATE TABLE ". $dbname .".room (
 			id INT(11) UNSIGNED AUTO_INCREMENT, 
  			name VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
  			);";

$sql_guest = "CREATE TABLE ". $dbname .".guest (
 			id INT(11) UNSIGNED AUTO_INCREMENT, 
  			name VARCHAR(255) NOT NULL,
			PRIMARY KEY (id)
  			);";

$sql_booking = "CREATE TABLE ". $dbname .".booking (
 			id INT(11) UNSIGNED AUTO_INCREMENT, 
  			id_guest INT(11) UNSIGNED,
  			id_room INT(11) UNSIGNED,
  			id_user INT(11) UNSIGNED,
  			start_date date,
  			end_date date,
			PRIMARY KEY (id),
			FOREIGN KEY (id_guest) REFERENCES guest(id),
  			FOREIGN KEY (id_room) REFERENCES room(id),
  			FOREIGN KEY (id_user) REFERENCES user(id)
  			);";

$sql_check = "SELECT * FROM user";

$sql_insert_user = "INSERT INTO user (name)
    		VALUES ('username');";

$sql_insert_rooms = "INSERT INTO room (name)
    		VALUES ('F10";

if($conn->query($sql_user) === TRUE && $conn->query($sql_room) === TRUE && $conn->query($sql_guest) === TRUE && $conn->query($sql_booking) === TRUE) {
	if (mysqli_num_rows($conn->query($sql_check)) == 0) {
      $conn->query($sql_insert_user);
      for ($i = 0; $i < 6; $i++) {
        $conn->query($sql_insert_rooms.$i."');");
      }
  	} else {
    echo "Error creating database: " . $conn->error;
	}
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
      <section class="jumbotron text-center">
        <div class="container center-message">Welcome to My Awesome Hotel</div>
        </section>
    </main>
  </body>
</html>
